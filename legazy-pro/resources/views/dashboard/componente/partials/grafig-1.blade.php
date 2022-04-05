<div id="chart"></div>
<style>
  .apexcharts-tooltip, .apexcharts-canvas .apexcharts-tooltip, .apexcharts-menu.apexcharts-menu-open, .apexcharts-canvas .apexcharts-toolbar .apexcharts-menu .apexcharts-menu-item {
    /*background: #000 !important;*/
    color: #000 !important;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
<script>
        axios.get('/dashboard/dataGrafica').then( function(response){
         
          var options = {
            colors: ['#BA8621'],
            series: [{
              name: "Numero de ventas",
              data: response.data.valores
          }],
            chart: {
            height: 350,
            type: 'line',
            zoom: {
              enabled: false
            },
          },
          dataLabels: {
            enabled: true,
          },
          
          colors: ['#D6A83E'],

          stroke: {
            curve: 'smooth'
          },
          title: {
            text: '',
            align: 'left',
            style:{
              color: '#fff'
            }
          },
          grid: {
          row: {
            colors: [], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
          labels: {
            style: {
                colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff' ,'#fff', '#fff', '#fff', '#fff', '#fff', '#fff']
            },               
          }
        },
        yaxis: {
            type:'category',
            axisTicks: {
              show: true,
              width: 1,
            },
            labels: {
              style: {
                  colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff' ,'#fff', '#fff', '#fff']
              },               
            }
        },
        tooltip: {
          enabled: true,
          style:{
            colors: ['#000']
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        }).catch(e => console.log(e))          
        
      
      
    </script>