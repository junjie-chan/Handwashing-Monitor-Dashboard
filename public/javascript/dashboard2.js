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

// Create line charts
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
const individual = [0, 8, 12, 9, 15, 7, 4, 6, 10];

// Individual vs Yesterday
const yesterday = [0, 3, 4, 9, 16, 12, 15, 11, 8];

new Chart("individual_yesterday", {
  type: "line",
  data: {
    labels: time,
    datasets: [
      // Draw individual average line
      {
        label: "Today",
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: individual,
      },
      // Draw standard line
      {
        label: "Yesterday",
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(255,0,0,1.0)",
        borderColor: "rgba(255,0,0,0.1)",
        data: yesterday,
        pointRadius: 0,
      },
    ],
  },
  options: {
    legend: {
      position: "bottom",
      labels: {
        padding: 10,
      },
    },
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

// Individual vs Others
const others = [0, 5, 7, 6, 8, 10, 7, 6.7, 6];

new Chart("individual_others", {
  type: "line",
  data: {
    labels: time,
    datasets: [
      // Draw individual average line
      {
        label: "My Average",
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: individual,
      },
      // Draw standard line
      {
        label: "Others' Average",
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(255,0,0,1.0)",
        borderColor: "rgba(255,0,0,0.1)",
        data: others,
        pointRadius: 0,
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      position: "bottom",
      labels: {
        padding: 10,
      },
    },
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
