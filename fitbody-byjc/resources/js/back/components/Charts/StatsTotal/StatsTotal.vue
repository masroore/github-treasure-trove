<template>
    <div class="row invisible" :data-toggle="[appear ? 'appear' : '']">
        <div v-for="(panel, index) in data" :class="column">
            <a class="block block-rounded text-right" :href="panel.href">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10">
                        <i :class="[panel.icon + ' fa-3x text-muted text-primary']"></i>
                    </div>
                    <div class="font-size-h3 font-w600 text-primary" data-toggle="countTo" :data-speed="panel.qty / 100" :data-to="panel.qty">{{ panel.qty }}</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">{{ panel.label }}</div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
      //
      props: {
        uri: {type: String, default: null},
        column: {type: String, default: 'col-6 col-xl-3'},
        appear: {type: String, default: true},
      },
      //
      data() {
        return {
          loading: true,
          data: {},
          speed: 1
        }
      },
      //
      async mounted()
      {
        let context = this
        await axios.get(context.uri)
          .then(r => {
            console.log(r)
            context.data = r.data
            context.loading = false
          })
          .catch(e => {
            console.log(e)
          });

      },
      //
      methods: {}
    };
</script>
