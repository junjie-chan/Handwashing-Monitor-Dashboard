var chart_height = 200;

function generate_minute_wise_time_series(date, count) {
  /**
   * Generate time series data for chart initialization
   *
   * @param {string} date - The starting date.
   * @param {number} count - Number of data couples.
   * @return {array} [[timestamp, value], ...]
   */
  var base_value = new Date(date).getTime();
  var i = 0;
  var series = [];
  for (let i = 0; i < count; i++) {
    var y = 50; //TODO: to be changed
    series.push([base_value, y]);
    base_value += 300000; // Time Interval
  }
  return series;
}

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

var line_options = {
  chart: {
    type: "area",
    stacked: true,
    animations: {
      easing: "linear",
      dynamicAnimation: {
        speed: 1000,
      },
    },
    events: {
      animationEnd: function (chartCtx) {
        const newData1 = chartCtx.w.config.series[0].data.slice();
        newData1.shift();
        const newData2 = chartCtx.w.config.series[1].data.slice();
        newData2.shift();
        window.setTimeout(function () {
          chartCtx.updateOptions(
            {
              series: [
                {
                  data: newData1,
                },
                {
                  data: newData2,
                },
              ],
              // TODO: show on an external p tag
              // subtitle: {
              //   text: parseInt(getRandom() * Math.random()).toString(),
              // },
            },
            false,
            false
          );
        }, 300); // NOTE: ???
      },
    },
  },
  stroke: {
    curve: "smooth", // Can try straight
  },
  series: [
    {
      name: "This Trolley",
      // TODO: use initial data from database
      data: generate_minute_wise_time_series("01/01/2023 00:00:00", 12),
    },
    {
      name: "Other Trolleys",
      // TODO: use initial data from database
      data: generate_minute_wise_time_series("01/01/2023 00:00:00", 12),
    },
  ],
  // Minimum range to display on x-axis
  xaxis: {
    type: "datetime",
    range: 2700000, //60000 = 1 minute
  },
  // TODO: change to p tag
  // subtitle: {
  //   text: "20",
  //   floating: true,
  //   align: "right",
  //   offsetY: -8,
  //   style: {
  //     fontSize: "22px",
  //   },
  // },
  legend: {
    offsetY: 0.2,
    offsetX: -20,
  },
};
var line_chart = new ApexCharts(
  document.querySelector("#line_chart"),
  line_options
);
line_chart.render();
