<?php

namespace App\Controllers;

use CodeIgniter\Model;
use DateTime;

class DataManager extends BaseController
{
    public function index()
    {
        // $model = model('DatabaseManagerModel');
        // $model->save_record('TROLLEY-46', '2023-10-02', '22:00:35');
        // $model->test();

        // foreach ($status as $s) {
        //     echo 'id: ' . $s[0] . ', freq level: ' . $s[1] . ', time left: ' . $s[2] . ', next freq: ' . $s[3] . '<br>';
        // }

        // return view('updates');
    }

    // Inputs: array, array
    public function remove_status_by_trolley_id($status, $trolley_id)
    {
        foreach ($status as $index => $tuple) {
            if (in_array($tuple[0], $trolley_id)) {
                unset($status[$index]);
            }
        }
        return array_values($status);
    }

    public function reset_period()
    {
        // Initialize trolley status
        $freq_levels = [[5, 15], [16, 30], [31, 45]];
        // [[trolley_id, freq_left, freq_length, time_left, next_freq],...]
        // To disable the quick simulation mode, uncomment the original calculations
        return array_map(function ($trolley_num) use ($freq_levels) {
            // Randomly pick one frequency level and generate a frequency
            // For quick simulation and view the changes, shrink 90% of the waiting time
            $freq_level = rand(...$freq_levels[array_rand($freq_levels)]);
            // $freq_level = (int)(rand(...$freq_levels[array_rand($freq_levels)]) * 0.1) - 1;
            // Handle 0 for quick simulation
            // if ($freq_level <= 0) {
            //     $freq_level = 1;
            // }
            // 1 hour time interval
            // For quick simulation and view the changes, shrink 90% of the waiting time
            // $time_left = 60 * 60;
            $time_left = 60 * 60 * 0.1;
            $freq_length = (int)(rand(30, $time_left / 4) * 0.1);
            $time_left -= $freq_length;
            // Each hand wash should occur at least 30 seconds after the previous one
            // For quick simulation and view the changes, shrink 90% of the waiting time
            // $next_freq = rand(30, $time_left / 4);
            $next_freq = $freq_length;
            return ['TROLLEY-' . sprintf('%02d', $trolley_num), $freq_level, $freq_length, $time_left, $next_freq];
        }, range(1, 12));
    }
    public function stream()
    {
        $model = Model('DatabaseManagerModel');

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        ob_end_clean();  // Close output cache

        // Real-time data generation & database update & web pages update
        $current_time = 0;
        // The comment is for testing
        // while ($current_time < 30) {
        while (true) {
            if ($current_time % 360 == 0) {
                $status = $this->reset_period();
            }
            // Generate the new record that matches the current time
            $trolleys = array_filter($status, function ($tuple) use ($current_time) {
                return $tuple[4] === $current_time && $tuple[1] > 0;
            });

            $add_trolley_today = 0;

            // Remove overdue trolley status from the status list
            $trolley_ids = array_map(function ($tuple) {
                return $tuple[0];
            }, $trolleys);
            if (!empty($trolley_ids)) {
                $status = $this->remove_status_by_trolley_id($status, $trolley_ids);
            }

            $now = new DateTime();
            $time_str = $now->format('H:i:s');
            foreach ($trolleys as $index => $trolley) {
                // Update database
                $model->save_record($trolley[0], $now->format('Y-m-d'), $time_str);

                // Update current trolley status and add to the status list
                $trolley[1] -= 1;
                // For quick simulation and view the changes, shrink 90% of the waiting time
                $trolley[2] = (int)(rand(30, $trolley[3] / 4) * 0.1);
                $trolley[3] -= $trolley[2];
                $trolley[4] += $trolley[2];
                $status[] = $trolley;

                // Get current trolley data
                if ($trolley[0] == 'TROLLEY-06') {
                    $add_trolley_today += 1;
                }
            }

            echo var_dump($status);

            // Compute data for charts
            $hourly_rate = $model->calculate_hourly_rate();
            $yesterday_hourly_rate = $model->calculate_hourly_rate(today: false);
            $general_hourly_rate = $model->calculate_hourly_rate('all');
            $general_yesterday_hourly_rate = $model->calculate_hourly_rate('all', false);
            if ($yesterday_hourly_rate == 0 || $general_yesterday_hourly_rate == 0) {
                $single_comparison = $hourly_rate * 100;
                $general_comparison = $general_hourly_rate * 100;
            } else {
                $single_comparison = number_format($hourly_rate / $yesterday_hourly_rate * 100, 2, '.', '');
                $general_comparison = number_format($general_hourly_rate / $general_yesterday_hourly_rate * 100, 2, '.', '');
            }

            // Computer two arrays for column chart update
            $all_trolley_ids = array_map(
                function ($trolley_num) {
                    return 'TROLLEY-' . sprintf('%02d', $trolley_num);
                },
                range(1, 12)
            );
            $all_hourly_rates = array_map(
                function ($id) use ($model) {
                    return $model->calculate_hourly_rate($id);
                },
                $all_trolley_ids
            );
            arsort($all_hourly_rates);
            $top10_general = array_slice($all_hourly_rates, 0, 10);
            array_splice($top10_general, 5, 0, 0);
            $top10_single = array_fill(0, 10, 0);
            array_splice($top10_single, 5, 0, $hourly_rate);

            echo 'data: ' . json_encode([
                // Update Labels
                'add_today_total' => count($trolleys),
                'add_trolley_today' => $add_trolley_today,
                'hourly_rate' => $hourly_rate,
                // Update Table
                'new_records' => json_encode($trolley_ids),
                'time' => $time_str,
                // Update Line Chart
                'general_hourly_rate' => $general_hourly_rate,
                // Update Donut Chart
                'single_comparison' => $single_comparison,
                'general_comparison' => $general_comparison,
                // Update Column Chart
                'top10_general' => $top10_general,
                'top10_single' => $top10_single
            ]) . "\n\n";

            ob_flush();
            flush();
            sleep(2);
            $current_time += 1;
        }

        echo "data: " . json_encode(['text' => 'close']) . "\n\n";
    }
}
