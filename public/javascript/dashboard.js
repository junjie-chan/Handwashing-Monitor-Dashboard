var chart_height = 200;

window.Apex = {
  colors: ["#FCCF31", "#17ead9", "#f02fc2"],
  chart: {
    height: chart_height,
    foreColor: "#fff",
    toolbar: {
      show: false,
    },
  },
  grid: {
    borderColor: "#40475D",
  },
  xaxis: {
    axisTicks: {
      color: "#333",
    },
    axisBorder: {
      color: "#333",
    },
  },
  fill: {
    type: "gradient",
    gradient: {
      gradientToColors: ["#F55555", "#6078ea", "#6094ea"],
    },
  },
  legend: {
    show: true,
    position: "top",
    horizontalAlign: "left",
    onItemClick: {
      toggleDataSeries: false,
    },
  },
  stroke: {
    width: 3,
  },
  zoom: {
    enabled: false,
  },
  dataLabels: {
    enabled: false,
  },
  tooltip: {
    theme: "dark",
    x: {
      formatter: function (val) {
        return moment(new Date(val)).format("HH:mm:ss");
      },
    },
  },
  yaxis: {
    decimalsInFloat: 2,
    opposite: true,
    labels: {
      offsetX: -10,
    },
  },
};

var circle_options = {
  chart: {
    type: "radialBar",
    height: chart_height * 1.5,
    offsetY: -30,
  },
  plotOptions: {
    radialBar: {
      inverseOrder: false,
      hollow: {
        size: "25%",
        background: "transparent",
      },
      track: {
        show: true,
        background: "#40475D",
        strokeWidth: "10%",
        opacity: 1,
        margin: 7, // Margin is in pixels
      },
    },
  },
  // TODO: set initial value
  series: [71, 63],
  labels: ["This Trolley", "Other Trolleys"],
  legend: {
    horizontalAlign: "center",
    offsetX: -20,
    offsetY: 35,
    // TODO: update data
    formatter: function (val, opts) {
      return val + ": " + opts.w.globals.series[opts.seriesIndex] + "%";
    },
  },
  fill: {
    gradient: {
      shade: "dark",
      type: "horizontal",
      shadeIntensity: 0.5,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100],
    },
  },
};
var circle_chart = new ApexCharts(
  document.querySelector("#circleChart"),
  circle_options
);
circle_chart.render();
