<template>
    <div>
        <v-chart :options="options" ref="trainingScatter"/>
    </div>
</template>
<style>
/**
 * 默认尺寸为 600px×400px，如果想让图表响应尺寸变化，可以像下面这样
 * 把尺寸设为百分比值（同时请记得为容器设置尺寸）。
 */
.echarts {
  width: 100%;
  height: 600px;
}
</style>
<script>
    import 'echarts/lib/chart/scatter';
// 引入提示框和标题组件
    require('echarts/lib/component/tooltip');
    require('echarts/lib/component/title');
    export default {
        props: ['id'],
        data() {  
            return {
                records: null,
                data:null  
                  };  
        },
        computed:{
            options(){
                return {
    xAxis: {
        type: 'time',
        name: 'Training date',
        },
    yAxis: {
        name:'Score'
    },
    tooltip: {
        padding: 10,
        backgroundColor: '#222',
        borderColor: '#777',
        borderWidth: 1,
        formatter: function (obj) {
            var value = obj.value;
            return '<div style="border-bottom: 1px solid rgba(255,255,255,.3); font-size: 18px;padding-bottom: 7px;margin-bottom: 7px">'
                +  value[0]
                + '</div>'
                + "Test type" + '：' + value[2] + '<br>'
                + "Test score" + '：' + value[1] + '<br>';
        }
    },
    series: [{
        symbolSize: 20,
        emphasis: {
            label: {
                show: true,
                formatter: function (param) {
                    return param.data[2];
                },
                position: 'top'
            }
        },
        data: [
            ['2020-08-01', 8.04,"COC"],
            ["2020-08-02", 6.95,"COC"],
            ["2020-08-02", 7.58,"COC"],
            ["2020-08-03", 8.81,"COC"],
            ["2020-08-05", 8.33,"COC"],
        ],
        type: 'scatter'
    }]

}
}
},      
        mounted() {  
                //this.showRecords(this.id, this);
                this.$refs.trainingScatter.showLoading();
                this.quality(this.id,this);
        },
        methods: {
            showRecords: _.debounce( function (id, vm) {
                axios.get('/visit-records?id=' + id).then( res => {
                    vm.records = res.data;
                });
            },350),
            quality:_.debounce(function(id,vm){
                axios.get('/visit/quality?id='+id).then(res=>{
                    vm.data=res.data.sort(function(a,b){
                        return(a.value-b.value);
                    });
                    this.$refs.trainingScatter.hideLoading();
                });
            },350)
        }
    }
</script>
