<template>
    <div>
        <img src="picture/loading.gif" v-if="issues===null" alt="Loading...">
        <span v-else-if="issues.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>异常类别</th><th>详情</th><th>调查反馈</th><th>确认时间</th><th>登记ＱＣ</th></thead>
        <tr v-for="item in issues"><td>{{item.issue}}</td>
            <td>{{item.remark}}</td>
            <td>{{item.feedback}}</td>
            <td>{{item.close_time}}</td>
            <td>{{item.qc_name}}</td>
        </tr>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
                    return {
                issues: null        
                    }  
        },  
        mounted() {  
                this.showIssues(this.id, this);
        },
        methods: {
            showIssues: _.debounce( function (id, vm) {
                axios.get('/issue/get-by-eid?eid=' + id).then( res => {
                    console.log(res.data);
                    console.log("issuedd"+id);
                    vm.issues = res.data;
                });
            },350),
        }
    }
</script>
