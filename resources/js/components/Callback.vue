<template>
    <div>
        <v-chart ref="callChart" :options="options" width="1000px" height="800"/>
<!--        <img src="picture/loading.gif" v-if="callRecords===null" alt="Loading...">
        <span v-else-if="callRecords.length===0">-----</span>
        <table class="table" v-else>
            <thead><th>类别</th><th>接通情况</th><th>详情</th><th>骚扰情况</th><th>回访时间</th><th>ＱＣ</th></thead>
            <tr v-for="item in callRecords"><td>{{item.type}}</td>
                <td>{{item.is_connected}}</td>
                <td>{{item.remark}}</td>
                <td>{{item.is_harassed}}</td>
                <td>{{item.check_time}}</td>
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
        height: 400px;
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
                callRecords: null,
                data: null,
                harassData: null
            };  
        },
        computed: {
            options() {
                return{
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    title: [{
                            text: "接通情况",
                            subtext:"针对该催收员回访电话的接通情况",
                            x:"0%",
                            textAlign:"left"
                        },
                        {
                            text: "骚扰情况",
                            subtext:"接电方是否反馈受到骚扰，空或‘-’表示未获得回应",
                            x:"50%",
                            textAlign:"left"
                        }],
                    series: [
                        {
                            name: '接通情况',
                            type: 'pie',
                            roseType: 'angel',
                            radius: '45%',
                            center: ['25%', '50%'],
                            data: this.data
                        },
                        {
                            name: '骚扰情况',
                            type: 'pie',
                            roseType: 'angel',
                            radius: '45%',
                            center: ['75%', '50%'],
                            data: this.harassData
                        }
                    ]
                };
            }
        },
        mounted() {
            this.$refs.callChart.showLoading(); 
            //this.showRecords(this.id, this);
            this.getConnectInfo(this.id, this);
            this.getHarassInfo(this.id, this);
        },
        methods: {
            showRecords: _.debounce(function (id, vm) {
                axios.get('/call-records?hmid=' + id).then(res => {
                    vm.callRecords = res.data;
                });
            }, 350),
            getConnectInfo: _.debounce(function (id, vm) {
                axios.get('callback/connect-info?hmid=' + id).then(res => {
                    vm.data = res.data.sort(function (a, b) {
                        return a.value - b.value;
                    });
                });
            }, 700),
            getHarassInfo: _.debounce(function (id, vm) {
                axios.get('callback/harass-info?hmid=' + id).then(res => {
                    vm.harassData = res.data.sort(function (a, b) {
                        return a.value - b.value;
                    });
                    vm.$refs.callChart.hideLoading();
                });
            }, 1000)
        }
    }
</script>
