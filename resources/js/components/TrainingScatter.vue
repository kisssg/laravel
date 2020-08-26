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
    require('echarts/lib/component/dataset');
    export default {
        props: ['id'],
        data() {  
            return {
                data:[]  
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
                                +  value.training_date
                                + '</div>'
                                + "Test type" + '：' + value.training_type + '<br>'
                                + "Test score" + '：' + value.general_score + '<br>'
                                + (value.remark===""?"":"Remark: "+value.remark);
                        }
                    },
                    dataset:{
                        dimensions: ['training_date','general_score','training_type'],
                        source:this.data,
                    },
                    series: [{
                        symbolSize: 20,
                        emphasis: {
                            label: {
                                show: true,
                                formatter: function (param) {
                                    return param.data.training_type;
                                },
                                position: 'top'
                            }
                        },
                        type: 'scatter'
                    }]
                }
            }
        },      
        mounted() {  
                this.$refs.trainingScatter.showLoading();
                this.showTest(this.id,this);
        },
        methods: {
            showTest: _.debounce(function (id, vm) {
                axios.get('/training/' + id).then(res => {
                    vm.data = res.data;
                    vm.$refs.trainingScatter.hideLoading();
                });
                } , 1000)
        }
    }
</script>
