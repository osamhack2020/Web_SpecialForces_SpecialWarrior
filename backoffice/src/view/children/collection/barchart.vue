<script>
import { HorizontalBar,mixins } from 'vue-chartjs';
const { reactiveProp } = mixins
export default {
  extends: HorizontalBar,
  mixins: [reactiveProp],
  props:['type'],
  data:()=>({
    options:{
        responsive:true,
        maintainAspectRatio:false,
        tooltips: {
            displayColors: true,
            callbacks: {
                label: function(tooltipItem, data) {
                  if(data['type']==0)
                    return data['datasets'][tooltipItem['datasetIndex']]['label'] + ": " + data['datasets'][tooltipItem['datasetIndex']]['hourAndMinute'][tooltipItem['index']];
                  else if(data['type']==1)
                    return data['datasets'][tooltipItem['datasetIndex']]['label'] + ": " + data['datasets'][tooltipItem['datasetIndex']]['data'][tooltipItem['index']]+"kg";  
                  else if(data['type']==2)
                    return data['datasets'][tooltipItem['datasetIndex']]['label'] + ": " + data['datasets'][tooltipItem['datasetIndex']]['data'][tooltipItem['index']]+"bpm";  
                },
            }
        },
    },
  }),
  mounted () {
    this.renderChart(this.chartData, this.options);
  }
}
</script>

<style>

</style>