<template>
    <div>
        <img src="picture/loading.gif" v-if="results===null" alt="Loading...">
        <span v-else-if="results.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>考试类型</th><th>月度</th><th>结果</th><th>考试日期</th></thead>
        <tr v-for="item in results"><td>{{item.type}}</td>
            <td>{{item.month}}</td>
            <td>{{item.result}}</td>
            <td>{{item.date}}</td>
        </tr>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
            return {
                results: null  
            };
        },
        mounted() {
            this.showTest(this.id, this);
        },
        methods: {
            showTest: _.debounce(function (id, vm) {
                axios.get('/online-test?employee_id=' + id).then(res => {
                    console.log(res.data);
                    vm.results = res.data;
                });
                } , 1000)
        }
    }
</script>