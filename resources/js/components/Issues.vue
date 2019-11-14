<template>
    <div>
        <img src="picture/loading.gif" v-if="issues===null" alt="Loading...">
        <span v-else-if="issues==='error'">获取数据失败，可能是登陆已过期。<button v-on:click='retry'>重试</button></span>
        <span v-else-if="issues.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>异常类别</th><th>详情</th><th>调查反馈</th><th>确认时间</th><th>登记ＱＣ</th><th>操作</th></thead>
        <tr v-for="item in issues">
            <td>{{item.issue}}</td>
            <td>{{item.remark}}</td>
            <td>{{item.feedback}}</td>
            <td>{{item.close_time}}</td>
            <td>{{item.qc_name}}</td>
            <td><a target="_blank" :href='"issue/"+item.id'>详情</a></td>
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
                    vm.issues = res.data;
                },error=>{
                    if(error.response.status!==200){
                        vm.issues ="error";
                    }
                    return error;
                });
            },350),
            retry(){
                this.showIssues(this.id, this);                
            }
        }
    }
</script>
