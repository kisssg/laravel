<template>
    <div>
        <span v-if="!ready">Camera checking records coming soon...</span>
        <v-chart :options="polar" v-if="ready" autosize="true"/>
    </div>
</template>
<script>
    import 'echarts/lib/chart/pie';
// 引入提示框和标题组件
    require('echarts/lib/component/tooltip');
    require('echarts/lib/component/title');
    export default {
        props: ['id'],
        data() {
            return {
                ready:false,
                records: null,
                polar: {
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    series: [
                        {
                            name: 'ｄ',
                            type: 'pie',
                            roseType: 'angel',
                            radius: '50%',
                            center:['50%','50%'],
                            data: [
                                {value: 235, name: 'Ａ'},
                                {value: 274, name: 'Ｂ'},
                                {value: 310, name: 'Ｃ'},
                                {value: 335, name: 'Ｄ'},
                                {value: 400, name: 'Ｅ'}
                            ]
                        }
                    ]
                }   
            };
        },
        mounted() {  
            //this.showRecords(this.id, this);
        },
        methods: {
            showRecords: _.debounce(function (id, vm) {
                axios.get('/visit-records?id=' + id).then(res => {
                    vm.records = res.data;
                });
            }, 350)
        }
    }
</script>
