<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use DateInterval;
use DateTime;

class DatabaseManagerModel extends Model
{
    public static function connect_database($db_name = 'handwashing_activities')
    {
        $db = \Config\Database::connect();
        $db->query("CREATE DATABASE IF NOT EXISTS {$db_name};");
        $params = [
            'DSN'      => '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => $db_name,
            'DBDriver' => 'MySQLi',
            'DBPrefix' => ''
        ];
        return \Config\Database::connect($params);
    }
    public static function connect_table($db, $table_name = 'records')
    {
        $db->query("CREATE TABLE IF NOT EXISTS {$table_name} (
                        record_id INT AUTO_INCREMENT PRIMARY KEY,
                        device_id VARCHAR(10) NOT NULL,
                        date VARCHAR(10) NOT NULL,
                        time VARCHAR(8) NOT NULL
                    );");
    }
    public static function save_record($device_id, $date, $time, $table_name = 'records')
    {
        $db = self::connect_database();
        self::connect_table($db, $table_name);
        $query = "INSERT INTO {$table_name} (device_id, date, time)
                  VALUES ('{$device_id}', '{$date}', '{$time}');";
        $db->query($query);
    }

    // Time Object Handling
    public static function interval_to_seconds($interval)
    {
        return $interval->s + $interval->i * 60;
    }

    public static function seconds_to_interval($seconds)
    {
        $time_1 = new DateTime("@0");
        $time_2 = new DateTime("@$seconds");
        return $time_1->diff($time_2);
    }

    public static function add_intervals($interval_1, $interval_2, $subtract = false)
    {
        if ($subtract) {
            $seconds = self::interval_to_seconds($interval_1) - self::interval_to_seconds($interval_2);
        } else {
            $seconds = self::interval_to_seconds($interval_1) + self::interval_to_seconds($interval_2);
        }
        return self::seconds_to_interval($seconds);
    }

    // Base Data Generation
    public static function generate_hourly_data($device_id, $date, $starting_time, int $hourly_freq)
    {
        $current_time = clone $starting_time;
        $time_left = 60 * 60; //60 minutes

        for ($i = 0; $i < $hourly_freq; $i++) {
            $interval = rand(5, (int)($time_left / 3));
            $current_time = $current_time->add(self::seconds_to_interval($interval));
            $time_left -= $interval;
            // Insert data
            self::save_record($device_id, $date, $current_time->format('H:i:s'));
        }
    }

    // freq_level: [xx, xx] inclusive.
    public static function generate_daily_data($device_id, $date, $freq_level)
    {
        $starting_time = new DateTime('09:00:00');

        for ($i = 0; $i < 8; $i++) {
            self::generate_hourly_data($device_id, $date, $starting_time, rand(...$freq_level));
            $starting_time = $starting_time->add(new DateInterval('PT1H'));
        }
    }

    // Generate n-month data from yesterday (inclusive), for example, if n=2 and today is 10-13, then the starting day is 08-01
    public static function generate_n_month_data_from_now($device_id, $n, $freq_level)
    {
        date_default_timezone_set('Australia/Brisbane');
        $today = new DateTime();

        // Generate data upto yesterday (including)
        $starting_date = (new DateTime())->modify('-' . (string)$n . ' months')->modify('first day of this month');
        $days = $today->diff($starting_date)->days + 1;

        $today_start_time = (new DateTime())->setTime(9, 0, 0);
        $today_end_time = (new DateTime())->setTime(17, 0, 0);

        if ($today > $today_end_time) {
            $days += 1;
        }

        for ($i = 0; $i < $days; $i++) {
            self::generate_daily_data($device_id, $starting_date->format('Y-m-d'), $freq_level);
            $starting_date = $starting_date->modify('+1 day');
        }

        // Generate data for today if the current time is within the day shift
        if ($today_start_time < $today && $today < $today_end_time) {
            $starting_time = new DateTime('09:00:00');

            for ($i = 0; $i < $today->diff($today_start_time)->h; $i++) {
                self::generate_hourly_data($device_id, $today->format('Y-m-d'), $starting_time, rand(...$freq_level));
                $starting_time = $starting_time->add(new DateInterval('PT1H'));
            }
        }
    }
    public function generate_base_data($n_month, $trolley_num = 12)
    {
        // Remove existing database before data generation
        $db = self::connect_database();
        $db->query('DROP TABLE IF EXISTS records;');
        // Reset the max_execution_time to 10 minutes
        set_time_limit(600);

        // Generate data for n month m trolleys at random frequency level
        for ($i = 0; $i < $trolley_num; $i++) {
            // Randomly select one frequency level for one trolley
            $freq_levels = [[5, 15], [16, 30], [31, 45]];
            $freq_level = $freq_levels[array_rand($freq_levels)];
            self::generate_n_month_data_from_now('TROLLEY-' . sprintf('%02d', $i + 1), $n_month, $freq_level);
        }
    }

    // Data Retrieval
    public function get_label_base_data($trolley_id = 'TROLLEY-06')
    {
        date_default_timezone_set('Australia/Brisbane');
        $now = new DateTime();
        $date = $now->format('Y-m-d');
        // For quick simulation and view the changes, shrink 90% of the waiting time
        // $start_time = $second_now->modify('-1 hour')->format('H:i:s');
        $start_time = $now->modify('-6 minutes')->format('H:i:s');
        $db = self::connect_database();

        $today_total = $db->table('records')
            ->where('date', $date)
            ->countAllResults();
        $trolley_today = $this->calculate_total($date, (new DateTime())->format('H:i:s'), $trolley_id, true, $start_time);

        return [
            'today_total' => $today_total,
            'trolley_today' => $trolley_today,
            'hourly_rate' => $this->calculate_hourly_rate($trolley_id)
        ];
    }

    // continuous: if true, get the number of handwashing activities an hour from now. Otherwise,
    // get the number of handwashing activities from 9:00:00 to now.
    public function calculate_total(
        $date,
        $time,
        $trolley_id = 'TROLLEY-06',
        $continuous = true,
        $starting_time = null
    ) {
        $db = self::connect_database();
        if ($continuous) {
            if ($trolley_id != 'all') {
                return $db->table('records')
                    ->where('date', $date)
                    ->where('time <=', $time)
                    ->where('time >=', $starting_time)
                    ->where('device_id', $trolley_id)
                    ->countAllResults();
            } else {
                return $db->table('records')
                    ->where('date', $date)
                    ->where('time <=', $time)
                    ->where('time >=', $starting_time)
                    ->countAllResults();
            }
        } else {
            if ($trolley_id != 'all') {
                return $db->table('records')
                    ->where('date', $date)
                    ->where('time <=', $time)
                    ->where('device_id', $trolley_id)
                    ->countAllResults();
            } else {
                return $db->table('records')
                    ->where('date', $date)
                    ->where('time <=', $time)
                    ->countAllResults();
            }
        }
    }

    // Calculate hourly handwashing rate for single trolley or all as a whole
    // $today: if false, means yesterday, otherwise, means today.
    public function calculate_hourly_rate(
        $trolley_id = 'TROLLEY-06',
        $today = true,
        $continuous = true
    ) {
        date_default_timezone_set('Australia/Brisbane');
        $now = new DateTime();
        $second_now = new DateTime();
        $starting_time = new DateTime('09:00:00');
        $ending_time = new DateTime('17:00:00');
        if (!$today) {
            $now = $now->modify('-1 day');
            $starting_time = $starting_time->modify('-1 day');
            $ending_time = $ending_time->modify('-1 day');
        }
        $date = $now->format('Y-m-d');
        $time = $now->format('H:i:s');

        // Calculate total handwashing activities during the day
        if ($continuous) {
            // For quick simulation and view the changes, shrink 90% of the waiting time
            // $start_time = $second_now->modify('-1 hour')->format('H:i:s');
            $start_time = $second_now->modify('-6 minutes')->format('H:i:s');
            $hourly_rate = $this->calculate_total($date, $time, $trolley_id, true, $start_time);
        } else {
            $total = $this->calculate_total($date, $time, $trolley_id, false);
        }

        if (!$continuous) {
            if ($now < $starting_time) {
                $hourly_rate = 0;
            } else {
                if ($now >= $ending_time) {
                    $hourly_rate = $total / 8;
                } else {
                    $diff = $now->diff($starting_time);
                    $hourly_rate = $total / ((($diff->h) * 3600 + ($diff->i) * 60 + ($diff->s)) / 60 / 60);
                }
            }
        }

        // General rate needs to divided by 12 as we totally have 12 trolleys
        // and we need data for xx times per trolley per hour.
        if ($trolley_id == 'all') {
            $hourly_rate /= 12;
        }

        return number_format($hourly_rate, 2, '.', '');
    }

    public function get_all_temp()
    {
        $db = self::connect_database();
        self::connect_table($db, 'temp');
        $results = $db->query("SELECT * from temp;")->getResultArray();
        // Remove the results from the table
        if (!empty($results)) {
            $ids = [];
            foreach ($results as $item) {
                $ids[] = $item['record_id'];
            }
            $db->query("DELETE FROM temp WHERE record_id IN (" . implode(', ', $ids) . ");");
        }
        return $results;
    }

    // Calculate how much the individual trolley beat the general performance in percentage
    public function single_vs_general()
    {
        $hourly_rate = $this->calculate_hourly_rate();
        $general_hourly_rate = $this->calculate_hourly_rate('all');
        if ($general_hourly_rate == 0) {
            return 100;
        } else {
            return (int)(round($hourly_rate / $general_hourly_rate, 2) * 100);
        }
    }
}
