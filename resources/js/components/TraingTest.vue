<template>
    <div>
        <img src="picture/loading.gif" v-if="results===null" alt="Loading...">
        <span v-else-if="results.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>考试类型</th><th>考试地点</th><th>话术成绩</th><th>笔试成绩</th><th>ＣＯＣ成绩</th><th>月份</th><th>培训师</th><th>是否租用培训场地</th></thead>
        <tr v-for="item in results"><td>{{item.training_type}}</td>
            <td>{{item.training_location}}</td>
            <td>{{item.script_score}}</td>
            <td>{{item.paper_score}}</td>
            <td>{{item.coc_score}}</td>
            <td>{{item.month}}</td>
            <td>{{item.trainer}}</td>
            <td>{{item.mr_rent}}</td>
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
                axios.get('/training-test?employee_id=' + id).then(res => {
                    vm.results = res.data;
                });
                } , 1000)
        }
    }
</script>