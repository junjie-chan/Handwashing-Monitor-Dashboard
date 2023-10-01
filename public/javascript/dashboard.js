const total_y = [55, 45];
const month_y = [38, 62];
const week_y = [79, 21];
const day_y = [86, 14];
const background_color = ["#b91d47", "white"];

// Create donut charts
new Chart("total", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: total_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});

new Chart("month", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: month_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});

new Chart("week", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: week_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});

new Chart("day", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: day_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});

// Create line chart
const time = [
  "9:00",
  "10:00",
  "11:00",
  "12:00",
  "13:00",
  "14:00",
  "15:00",
  "16:00",
  "17:00",
];
const handwashing_times = [0, 8, 12, 9, 15, 7, 4, 6, 10];
const standard = [].concat(...Array(handwashing_times.length).fill([12]));

new Chart("line_chart", {
  type: "line",
  data: {
    labels: time,
    datasets: [
      {
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: handwashing_times,
      },
      // Draw standard line
      {
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: standard,
        pointRadius: 0,
      },
    ],
  },
  options: {
    // legend: { display: false },
    scales: {
      xAxes: [
        {
          gridLines: { display: false },
        },
      ],
      yAxes: [
        {
          ticks: { min: 0, max: 20 },
          gridLines: { display: false },
        },
      ],
    },
  },
});
