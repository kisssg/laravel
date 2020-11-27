<template>
    <div>
        Date range:<input type='date' v-model='start'/>-<input v-model='end' type='date'/>
        <button v-on:click='retry'>Search</button><br/>
        <img src="picture/loading.gif" v-if="issues===null" alt="Loading...">
        <span v-else-if="issues==='error'">Failed fetching data. If you see this notice again try refresh the page.<button v-on:click='retry'>Retry</button></span>
        <span v-else-if="issues.length===0">No relevant data</span>
        <table class="table" v-else>
            <thead><th>Type</th><th>Count</th><th>Action</th></thead>
        <tr v-for="(item,index) in issues" :key="index">
            <td>{{item.issue}}</td>
            <td>{{item.count}}</td>
            <td><a :href="'issue/search?s=[issue:'+item.issue+'][result:有效][employeeid:'+id+']'" target="_blank">Detail</a></td>
        </tr>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
                    return {
                issues: null,
                start:"",
                 end:""        
                    }  
        },  
        mounted() {  
                this.showIssues(this.id, this,this.start,this.end);  
        },
        methods: {
            showIssues: _.debounce( function (id, vm,start,end) {
                    axios.get('/issue/get-by-eid?eid=' + id + '&start='+start+ '&end='+end ).then( res => {
                    vm.issues = res.data;
                },error=>{
                    if(error.response.status!==200){
                        vm.issues ="error";
                    }
                    return error;
                });
            },350),
            retry(){
                this.issues=null;
                this.showIssues(this.id, this,this.start,this.end);                
            }
        }
    }
</script>
