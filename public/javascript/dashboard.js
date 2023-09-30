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
