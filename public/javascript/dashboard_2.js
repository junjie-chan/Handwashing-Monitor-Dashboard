var chart_height = 180;

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
    var y = 0; //TODO: to be changed
    series.push([base_value, y]);
    base_value += 300000; // Time Interval
  }
  return series;
}
function generate_random_number(count, range_min, range_max) {
  var data = [];
  for (let i = 0; i < count; i++) {
    data.push(Math.random() * (range_max - range_min) + range_min);
  }
  return data;
}
function generate_this_trolley() {
  return [
    ...Array(5).fill(""),
    generate_random_number(1, 3, 18),
    ...Array(5).fill(""),
  ];
}
function generate_other_trolleys() {
  return [
    ...generate_random_number(5, 3, 18),
    "",
    ...generate_random_number(5, 3, 18),
  ];
}
var trigoStrength = 3;
var iteration = 11;
function getRandom() {
  var i = iteration;
  return (
    (Math.sin(i / trigoStrength) * (i / trigoStrength) +
      i / trigoStrength +
      1) *
    (trigoStrength * 2)
  );
}
function getRangeRandom(yrange) {
  return Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
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
    labels: {
      style: {
        colors: "#bfbfbf",
      },
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
    labels: {
      colors: "#bfbfbf",
    },
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
      style: {
        colors: "#bfbfbf",
      },
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

var column_options = {
  chart: {
    type: "bar",
    stacked: true,
  },
  stroke: {
    width: 0,
  },
  series: [
    {
      name: "This Trolley",
      data: Array(11).fill(0),
    },
    {
      name: "Other Trolleys",
      data: Array(11).fill(0),
    },
  ],
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "vertical",
      shadeIntensity: 0.5,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 0.8,
      stops: [10, 100],
    },
  },
  xaxis: {
    labels: {
      show: false,
    },
  },
};
var column_chart = new ApexCharts(
  document.querySelector("#column_chart"),
  column_options
);
column_chart.render();

// Force table container height
var container = document.querySelector("#line_container");
var table_container = document.querySelector("#table_container");
var style = window.getComputedStyle(container);
var height = style.getPropertyValue("height");
table_container.style.height = height;

// Table Initialization: Initially show 20 empty cells
var table = document.querySelector("tbody");
for (let i = 0; i < 20; i++) {
  var new_row = table.insertRow(0);
  new_row.insertCell(0).innerText = "null";
  new_row.insertCell(1).innerText = "null";
}
