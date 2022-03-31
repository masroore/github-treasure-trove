<template>
    <div class="StreetLocator">
        <div class="row">
            <div class="col-md-4 col-12 bottommargin-sm">
                <label>{{ lang.origin }}</label>
                <input ref="autocomplete_from" type="text" name="from" class="sm-form-control" :placeholder="lang.origin_placeholder">
                <div class="row" v-if="from_error">
                    <div class="col-12" style="padding-top: 4px;">
                        <span style="color: #ff3f48; font-size: 14px; font-style: italic;">{{ lang.origin_error }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 bottommargin-sm">
                <label>{{ lang.destination }}</label>
                <input ref="autocomplete_to" type="text" name="to" class="sm-form-control" :placeholder="lang.destination_placeholder">
                <div class="row" v-if="to_error">
                    <div class="col-12" style="padding-top: 4px;">
                        <span style="color: #ff3f48; font-size: 14px; font-style: italic;">{{ lang.destination_error }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 bottommargin-sm">
                <label>{{ lang.departure_date }}</label>
                <datetime type="datetime" class="bottommargin-sm theme-orange" input-class="sm-form-control"
                          v-model="datetime"
                          :minute-step='minute_set'
                          :min-datetime="now">
                    <template slot="button-cancel">{{ lang.cancel }}</template>
                    <template slot="button-confirm">{{ lang.ok }}</template>
                </datetime>
            </div>
            <div class="col-md-12 col-12">
                <button class="button button-3d text-center nomargin btn-block rightmargin-sm" @click="Send()">{{ lang.submit }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { Settings } from 'luxon'
    Settings.defaultLocale = window.locale

    export default {
      props: {
        uri: String,
        redirect: String
      },
      //
      data() {
        return {
          autocomplete_from: {},
          autocomplete_to: {},
          datetime: '',
          now: new Date().toISOString(),
          minute_set: 15,
          from_error: false,
          to_error: false,
          lang: ''
        }
      },
      //
      mounted() {
        this.Setup()
        this.lang = window.trans.slider

        //console.log(new Date().toISOString())
      },
      //
      methods: {

        onPlaceChanged(place) {
          console.log(place)
        },

        onNoResult(place) {
          console.log(place)
        },

        /**
         * Setup autocomplete functions.
         *
         * @constructor
         */
        Setup() {
          this.autocomplete_from = new google.maps.places.Autocomplete(
            (this.$refs.autocomplete_from),
            /*{types: ['geocode']}*/
          )

          this.autocomplete_to = new google.maps.places.Autocomplete(
            (this.$refs.autocomplete_to),
            /*{types: ['geocode']}*/
          )
        },

        /**
         * Check autocomplete inputs.
         *
         * @returns {boolean}
         * @constructor
         */
        CheckInputs() {
          if (! this.autocomplete_from.getPlace()) {
            this.from_error = true
          } else {
            this.from_error = false
          }

          if (! this.autocomplete_to.getPlace()) {
            this.to_error = true
          } else {
            this.to_error = false
          }

          if (! this.from_error && ! this.to_error) {
            return true
          }

          return false
        },

        /**
         * Send the request.
         *
         * @constructor
         */
        Send() {
          if (this.CheckInputs()) {
            let from = this.autocomplete_from.getPlace()
            let to = this.autocomplete_to.getPlace()

            let request = {
              from: from.formatted_address,
              from_coordinates: from.geometry.location.lat() + ',' + from.geometry.location.lng(),
              to: to.formatted_address,
              to_coordinates: to.geometry.location.lat() + ',' + to.geometry.location.lng(),
              date: this.datetime
            }

            let context = this
            axios.post(context.uri, {data: request})
              .then(r => {
                if (r.data.success) {
                  location = this.redirect
                }
                //console.log(r.data)
              })
              .catch(e => {
                console.log(e)

              });

            console.log(request)
          }
        }
      }
    };
</script>

<style>
    .theme-optima-blue .vdatetime-popup__header,
    .theme-optima-blue .vdatetime-calendar__month__day--selected > span > span,
    .theme-optima-blue .vdatetime-calendar__month__day--selected:hover > span > span {
        background: #37b6ff !important;
    }

    .theme-optima-blue .vdatetime-year-picker__item--selected,
    .theme-optima-blue .vdatetime-time-picker__item--selected,
    .theme-optima-blue .vdatetime-popup__actions__button {
        color: #37b6ff !important;
    }
</style>
