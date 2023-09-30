const total_beat_y = [55, 45];
const hourly_rate_y = [55, 25];
const background_color = ["#b91d47", "white"];

// Create donut charts
new Chart("total_beat", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: total_beat_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});

new Chart("hourly_rate", {
  type: "doughnut",
  data: {
    datasets: [
      {
        backgroundColor: background_color,
        data: hourly_rate_y,
      },
    ],
  },
  options: {
    tooltips: {
      enabled: false,
    },
  },
});
