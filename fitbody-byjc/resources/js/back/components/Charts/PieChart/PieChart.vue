<template>
    <div class="block block-rounded"
         :class="[!loaded ? 'block-mode-loading' : '']">
        <div class="block-header">
            <h3 class="block-title">
                <span class="">{{ title }}
                    <span class="text-muted ml-20" v-if="widgets.count">Total: <span class="text-info-light">{{ widgets.count }}</span></span>
                    <span class="text-info ml-20" v-if="widgets.count">{{ widgets.title }} - <span class="font-size-sm">{{ widgets.subtitle }}</span></span>
                </span>
            </h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="refreshData()">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full pt-20">
            <!--<div class="row">
                <div class="col-4">

                </div>
                <div class="col-8">

                </div>
            </div>-->
            <div class="pull-all">
                <pie-chart-template v-if="loaded" :chart-data="chartdata" :options="options" style="max-height: 250px"/>
            </div>
        </div>
        <!--<div class="block-content mt-20">
            <div class="row">
                <div class="col-12 text-center">

                </div>
            </div>
        </div>-->
    </div>
</template>

<script>
  import PieChartTemplate from "./PieChartTemplate"

  export default {
    components: {
      PieChartTemplate
    },
    //
    props: {
      uri: {type: String, default: null},
      title: {type: String, default: null}
    },
    //
    data() {
      return {
        loaded: false,
        chartdata: {},
        options: {},
        widgets: {},
        default_preset: 'M',
      }
    },
    //
    async mounted() {
      this.options = this.setOptions()
      this.loaded = false
      let context = this
      await axios.post(context.uri, {data: context.default_preset})
        .then(r => {
          console.log(r.data)
          context.chartdata = context.setChartData(r.data, '#2b2e33')
          context.widgets = r.data.widgets
          context.loaded = true
        })
        .catch(e => {
          console.log(e)
          context.loaded = true
        });

    },
    //
    methods: {
      /**
       * Set chart options.
       *
       * @returns {{legend: boolean, responsive: boolean, scales: {yAxes: {ticks: {callback: ticks.callback, beginAtZero: boolean, fontColor: string}}[], xAxes: {ticks: {fontColor: string}}[]}, maintainAspectRatio: boolean}}
       */
      setOptions() {
        return {
          responsive: true,
          maintainAspectRatio: false,
          cutoutPercentage: 30,
          pieceLabel: {
            mode: 'percentage',
            precision: 1
          }
        }
      },

      /**
       * Set chart data.
       *
       * @param chart_data
       * @param color
       * @returns {{datasets: {backgroundColor: *, data: *}[], labels: *}}
       */
      setChartData(chart_data, color) {
        return {
          labels: chart_data.labels,
          datasets: [{
            borderColor: chart_data.colors[0],
            backgroundColor: chart_data.colors,
            data: chart_data.data
          }]
        }
      },

      /**
       * Refresh the chart data.
       *
       * @param param
       */
      refreshData(param = {data: this.default_preset}) {
        this.loaded = false
        let request = param.data

        let context = this
        axios.post(context.uri, {data: request})
          .then(r => {
            console.log(r.data)
            context.chartdata = context.setChartData(r.data, '#2b2e33')
            context.loaded = true
          })
          .catch(e => {
            console.log(e)
            context.loaded = true
          });
      }
      //
    }
  }
</script>

<style scoped>

</style>
