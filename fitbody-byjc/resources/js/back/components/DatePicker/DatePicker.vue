<template>
    <div class="DatePicker">
        <datetime type="datetime" v-model="datetime" class="bottommargin-sm theme-orange" input-class="sm-form-control"></datetime>
    </div>
</template>

<script>
    export default {
        props: {
        },
      data() {
          return {
            datetime: ''
          }
      }
    };
</script>

<style>
    .theme-orange .vdatetime-popup__header,
    .theme-orange .vdatetime-calendar__month__day--selected > span > span,
    .theme-orange .vdatetime-calendar__month__day--selected:hover > span > span {
        background: #37b6ff !important;
    }

    .theme-orange .vdatetime-year-picker__item--selected,
    .theme-orange .vdatetime-time-picker__item--selected,
    .theme-orange .vdatetime-popup__actions__button {
        color: #37b6ff !important;
    }
</style>
