<template>
    <div>
        <v-chart :options="options" ref="qualityChart"/>
<!--        <img src="picture/loading.gif" v-if="records===null" alt="Loading...">
        <span v-else-if="records.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>外访日期</th><th>外访结果</th><th>外访备注</th><th>质检结果</th><th>核查质检</th></thead>
        <tr v-for="(item,key,index) in records">
            <td>{{item.visit_date}}</td>
            <td>{{item.visit_result_cn}}</td>
            <td>{{item.remark}}</td>
            <td>{{item.validity}}</td>
            <td>{{item.qc_name}}</td>
        </tr>
        </table>-->
    </div>
</template>
<style>
/**
 * 默认尺寸为 600px×400px，如果想让图表响应尺寸变化，可以像下面这样
 * 把尺寸设为百分比值（同时请记得为容器设置尺寸）。
 */
.echarts {
  width: 1100px;
  height: 600px;
}
</style>
<script>
    import 'echarts/lib/chart/pie';
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
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    title:{text:"钉钉日志质检结果",subtext:"不包含much外访日志\n\
\n\A合格; B合理解释; C不合格; D有日志无签到"},
                    series: [
                        {
                            name: '质检结果',
                            type: 'pie',
                            //roseType: 'angel',
                            radius: '45%',
                            center:['25%','50%'],
                            data: this.data
                        }
                    ]
                };
            }
        },      
        mounted() {  
                //this.showRecords(this.id, this);
                this.$refs.qualityChart.showLoading();
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
                    this.$refs.qualityChart.hideLoading();
                });
            },350)
        }
    }
</script>
