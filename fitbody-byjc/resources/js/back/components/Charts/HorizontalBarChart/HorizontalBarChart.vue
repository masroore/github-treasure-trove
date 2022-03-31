<template>
    <div class="block block-rounded"
         :class="[loading ? 'block-mode-loading' : '']">
        <div class="block-header">
            <h3 class="block-title">
                <span class="">{{ title }}</span> <!--<span class="font-size-xs font-w100 text-primary-light ml-15">{{ title_by }}</span>-->
            </h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="refreshData()">
                    <i class="si si-refresh"></i>
                </button>
                <div class="dropdown">
                    <button type="button" class="btn-block-option dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="si si-wrench"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button v-for="btn in presets" type="button" class="dropdown-item" @click="refreshData(btn)">
                            <!--<i class="fa fa-fw fa-bell mr-5"></i>-->{{ btn.label }}
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-block-option" @click="filter_show ? filter_show = false : filter_show = true">
                    <i :class="[filter_show ? 'si si-arrow-up' : 'si si-arrow-down']"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full pt-10 pb-10" v-if="filter_show">
            <div class="row items-push">
                <div class="col-5 mb-0">
                    <datepicker v-model="date.from" :bootstrap-styling="true" class="block block-transparent text-black" placeholder="From"></datepicker>
                </div>
                <div class="col-5 mb-0">
                    <datepicker v-model="date.to" :bootstrap-styling="true" class="block block-transparent text-black" placeholder="To"></datepicker>
                </div>
                <div class="col-2 mb-0">
                    <button type="button" class="btn btn-block btn-outline-secondary" @click="refreshData(date)">
                        <i class="si si-control-play"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="block-content block-content-full pt-20">
            <div class="pull-all">
                <horizontal-bar-chart-template v-if="loaded" :chart-data="chartdata" :options="options" style="max-height: 270px"/>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-12 text-center">
                    <h5 class="font-size-sm font-w300 text-info">{{ title_by }}</h5>
                </div>
            </div>
            <div class="row items-push">
                <div v-for="widget in widgets" class="col-6 col-sm-3 text-center text-sm-left">
                    <div class="font-size-xs font-w300 text-uppercase text-info text-muted">{{ widget.label }}</div>
                    <div class="font-size-md font-w100">{{ widget.data }} kn
                    </div>
                    <!--<div class="font-w600 text-success">
                        <i class="fa fa-caret-up"></i> +16%
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HorizontalBarChartTemplate from "./HorizontalBarChartTemplate";
    import Datepicker from 'vuejs-datepicker'

    export default {
      components: {
        HorizontalBarChartTemplate,
        Datepicker
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
          loading: false,
          filter_show: false,
          title_by: '',
          chartdata: {},
          options: {},
          widgets: {},
          presets: {},
          default_preset: 'M',
          date: {
            from: null,
            to: null
          }
        }
      },
      //
      async mounted() {
        this.options = this.setOptions()
        this.loaded = false
        let context = this
        await axios.post(context.uri, {data: context.default_preset})
          .then(r => {
            console.log(r)
            context.chartdata = context.setChartData(r.data, '#a8ba00')
            context.widgets = r.data.widgets
            context.presets = r.data.presets
            context.title_by = context.returnSelectedTitle(r.data.presets, context.default_preset)
            context.loaded = true
          })
          .catch(e => {
            console.log(e)
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
            legend: false,
            scales: {
              xAxes: [{
                ticks: {
                  fontColor: '#3b3e43',
                  beginAtZero: true
                }
              }],
              yAxes: [{
                ticks: {
                  fontColor: '#3b3e43',
                }
              }]
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
              backgroundColor: color,
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

          if (param.hasOwnProperty('from')) {
            request = param
          }

          let context = this
          axios.post(context.uri, {data: request})
            .then(r => {
              console.log(r.data)
              context.chartdata = context.setChartData(r.data, '#a8ba00')
              context.widgets = r.data.widgets
              context.title_by = context.returnSelectedTitle(r.data.presets, param.data)
              context.loaded = true
            })
            .catch(e => {
              console.log(e)
              context.loaded = true
            });
        },


        /**
         * Return presets selected label.
         *
         * @param data
         * @param param
         * @returns {string|*}
         */
        returnSelectedTitle(data, param) {
          for (let i = 0; i < data.length; i++) {
            if (data[i].data == param) {
              return data[i].label
            }
          }

          return 'Unknown!'
        }
      }
    }
</script>
