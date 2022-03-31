import { Pie, mixins } from "vue-chartjs"
const { reactiveProp } = mixins

export default {
    extends: Pie,
    mixins: [reactiveProp],
    props: ['options'],
    mounted () {
        this.renderChart(this.chartData, this.options)
        /*this.renderChart({
            labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
            datasets: [
                {
                    backgroundColor: [
                        '#41B883',
                        '#E46651',
                        '#00D8FF',
                        '#DD1B16'
                    ],
                    data: [40, 20, 80, 10]
                }
            ]
        }, {
            responsive: true,
            maintainAspectRatio: false,
            pieceLabel: {
                mode: 'percentage',
                precision: 1
            }
        })*/
    }
}
