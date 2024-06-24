/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;
  const csrfToken = $('meta[name="csrf-token"]').attr('content');

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  $(document).ready(function() {
    $.ajax({
      url: '/user/ajax',
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken 
    },
      data: {
        action: 'getchart1',
      },

      success: (data) => {
        

        const payment = (data, mo) => {
          if (mo == 1) {

          return Object.values(data.payment).map(value => value.total_amount);

          } else {
            return Object.values(data.payment).map(value => formatDateManual(value.month));
          }
        };

        const withdraw = (data, mo) => {
          if (mo == 1) {

          return Object.values(data.withdraw).map(value => value.amount);

          } else {
            return Object.values(data.withdraw).map(value => value.month);
          }
        };

        const _Users = (data, mo = 1) => {
          if (mo == 1) {

          return Object.values(data.user).map(value => value.total);

          } else {
            return Object.values(data.user).map(value => value.month);
          }
        };
        

        const PaymentspricesArray = payment(data, 1);
        const Months = payment(data, 2);

        

        // Output the array

          // Income Chart - Area chart
  // --------------------------------------------------------------------
  const incomeChartEl = document.querySelector('#incomeChart'),
  incomeChartConfig = {
    series: [
      {
        data: payment(data, 1)
      }
    ],
    chart: {
      height: 215,
      parentHeightOffset: 0,
      parentWidthOffset: 0,
      toolbar: {
        show: false
      },
      type: 'area'
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: 2,
      curve: 'smooth'
    },
    legend: {
      show: false
    },
    markers: {
      size: 6,
      colors: 'transparent',
      strokeColors: 'transparent',
      strokeWidth: 4,
      discrete: [
        {
          fillColor: config.colors.white,
          seriesIndex: 0,
          dataPointIndex: 7,
          strokeColor: config.colors.primary,
          strokeWidth: 2,
          size: 6,
          radius: 8
        }
      ],
      hover: {
        size: 7
      }
    },
    colors: [config.colors.primary],
    fill: {
      type: 'gradient',
      gradient: {
        shade: shadeColor,
        shadeIntensity: 0.6,
        opacityFrom: 0.5,
        opacityTo: 0.25,
        stops: [0, 95, 100]
      }
    },
    grid: {
      borderColor: borderColor,
      strokeDashArray: 3,
      padding: {
        top: -20,
        bottom: -8,
        left: 10,
        right: 8
      }
    },
    xaxis: {
      categories: payment(data, 2),
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        show: true,
        style: {
          fontSize: '13px',
          colors: axisColor
        }
      }
    },
    yaxis: {
      labels: {
        show: false
      },
      min: 1000,
      max: 1000000,
      tickAmount: 4
    }
  };
if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
  const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
  incomeChart.render();
}


const incomeChartEl2 = document.querySelector('#incomeChart2'),
incomeChartConfig2 = {
  series: [
    {
      data: withdraw(data, 1)
    }
  ],
  chart: {
    height: 215,
    parentHeightOffset: 0,
    parentWidthOffset: 0,
    toolbar: {
      show: false
    },
    type: 'area'
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: 2,
    curve: 'smooth'
  },
  legend: {
    show: false
  },
  markers: {
    size: 6,
    colors: 'transparent',
    strokeColors: 'transparent',
    strokeWidth: 4,
    discrete: [
      {
        fillColor: config.colors.white,
        seriesIndex: 0,
        dataPointIndex: 7,
        strokeColor: config.colors.primary,
        strokeWidth: 2,
        size: 6,
        radius: 8
      }
    ],
    hover: {
      size: 7
    }
  },
  colors: [config.colors.primary],
  fill: {
    type: 'gradient',
    gradient: {
      shade: shadeColor,
      shadeIntensity: 0.6,
      opacityFrom: 0.5,
      opacityTo: 0.25,
      stops: [0, 95, 100]
    }
  },
  grid: {
    borderColor: borderColor,
    strokeDashArray: 3,
    padding: {
      top: -20,
      bottom: -8,
      left: 10,
      right: 8
    }
  },
  xaxis: {
    categories: withdraw(data, 2),
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: true,
      style: {
        fontSize: '13px',
        colors: axisColor
      }
    }
  },
  yaxis: {
    labels: {
      show: false
    },
    min: 1000,
    max: 1000000,
    tickAmount: 4
  }
};
if (typeof incomeChartEl2 !== undefined && incomeChartEl2 !== null) {
const incomeChart2 = new ApexCharts(incomeChartEl2, incomeChartConfig2);
incomeChart2.render();
}



  // Profit Report Line Chart
  // --------------------------------------------------------------------
  const profileReportChartEl = document.querySelector('#profileReportChart'),
    profileReportChartConfig = {
      chart: {
        height: 80,
        // width: 100,
        type: 'line',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: true,
          top: 10,
          left: 5,
          blur: 3,
          color: config.colors.warning,
          opacity: 0.15
        },
        sparkline: {
          enabled: true
        }
      },
      grid: {
        show: false,
        padding: {
          right: 8
        }
      },
      colors: [config.colors.warning],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 5,
        curve: 'smooth'
      },
      series: [
        {
          data: _Users(data)
        }
      ],
      xaxis: {
        categories: _Users(data, 2),
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        show: false,
      }
    };
  if (typeof profileReportChartEl !== undefined && profileReportChartEl !== null) {
    const profileReportChart = new ApexCharts(profileReportChartEl, profileReportChartConfig);
    profileReportChart.render();
  }

      },

      error: (xhr,error) => {
        console.log(xhr.responseText);
      }
    });
  });


  // Growth Chart - Radial Bar Chart
  // --------------------------------------------------------------------
  const growthChartEl = document.querySelector('#growthChart'),
    growthChartOptions = {
      series: [78],
      labels: ['Growth'],
      chart: {
        height: 240,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          size: 150,
          offsetY: 10,
          startAngle: -150,
          endAngle: 150,
          hollow: {
            size: '55%'
          },
          track: {
            background: cardColor,
            strokeWidth: '100%'
          },
          dataLabels: {
            name: {
              offsetY: 15,
              color: headingColor,
              fontSize: '15px',
              fontWeight: '600',
              fontFamily: 'Public Sans'
            },
            value: {
              offsetY: -25,
              color: headingColor,
              fontSize: '22px',
              fontWeight: '500',
              fontFamily: 'Public Sans'
            }
          }
        }
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          shadeIntensity: 0.5,
          gradientToColors: [config.colors.primary],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.6,
          stops: [30, 70, 100]
        }
      },
      stroke: {
        dashArray: 5
      },
      grid: {
        padding: {
          top: -35,
          bottom: -10
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof growthChartEl !== undefined && growthChartEl !== null) {
    const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
    growthChart.render();
  }










  // Order Statistics Chart
  // --------------------------------------------------------------------
  const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
    orderChartConfig = {
      chart: {
        height: 165,
        width: 130,
        type: 'donut'
      },
      labels: ['Electronic', 'Sports', 'Decor', 'Fashion'],
      series: [85, 15, 50, 50],
      colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
      stroke: {
        width: 5,
        colors: cardColor
      },
      dataLabels: {
        enabled: false,
        formatter: function (val, opt) {
          return parseInt(val) + '%';
        }
      },
      legend: {
        show: false
      },
      grid: {
        padding: {
          top: 0,
          bottom: 0,
          right: 15
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '75%',
            labels: {
              show: true,
              value: {
                fontSize: '1.5rem',
                fontFamily: 'Public Sans',
                color: headingColor,
                offsetY: -15,
                formatter: function (val) {
                  return parseInt(val) + '%';
                }
              },
              name: {
                offsetY: 20,
                fontFamily: 'Public Sans'
              },
              total: {
                show: true,
                fontSize: '0.8125rem',
                color: axisColor,
                label: 'Weekly',
                formatter: function (w) {
                  return '38%';
                }
              }
            }
          }
        }
      }
    };
  if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
    const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
    statisticsChart.render();
  }



  // Expenses Mini Chart - Radial Chart
  // --------------------------------------------------------------------
  const weeklyExpensesEl = document.querySelector('#expensesOfWeek'),
    weeklyExpensesConfig = {
      series: [65],
      chart: {
        width: 60,
        height: 60,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          startAngle: 0,
          endAngle: 360,
          strokeWidth: '8',
          hollow: {
            margin: 2,
            size: '45%'
          },
          track: {
            strokeWidth: '50%',
            background: borderColor
          },
          dataLabels: {
            show: true,
            name: {
              show: false
            },
            value: {
              formatter: function (val) {
                return '$' + parseInt(val);
              },
              offsetY: 5,
              color: '#697a8d',
              fontSize: '13px',
              show: true
            }
          }
        }
      },
      fill: {
        type: 'solid',
        colors: config.colors.primary
      },
      stroke: {
        lineCap: 'round'
      },
      grid: {
        padding: {
          top: -10,
          bottom: -15,
          left: -10,
          right: -10
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof weeklyExpensesEl !== undefined && weeklyExpensesEl !== null) {
    const weeklyExpenses = new ApexCharts(weeklyExpensesEl, weeklyExpensesConfig);
    weeklyExpenses.render();
  }
})();


function formatDateManual(yearMonth) {
  const [year, month] = yearMonth.split('-').map(Number);
  
  // Array of month names
  const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  
  // Get the month name
  const monthName = monthNames[month - 1];
  
  // Return the formatted string
  return `${monthName}`;
}


