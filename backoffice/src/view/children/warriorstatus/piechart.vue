<script>
import { Doughnut,mixins } from 'vue-chartjs';
const { reactiveProp } = mixins
export default {
  extends: Doughnut,
  mixins: [reactiveProp],
  props:['type'],
  data:()=>({
    options:{
        responsive:true,
        maintainAspectRatio:false,
        tooltips: {
            displayColors: true,
        },
    },
  }),
  mounted () {
    this.renderChart(this.chartData, this.options);
  },
  methods:{

  },
}
</script>

<style>

</style>