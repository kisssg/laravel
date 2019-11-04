<template>
    <div>
       <table class="table">
            <thead><th>外访日期</th><th>外访结果</th><th>外访备注</th><th>质检结果</th><th>核查质检</th></thead>
        <tr v-for="(item,key,index) in records">
            <td>{{item.visit_date}}</td>
            <td>{{item.visit_result_cn}}</td>
            <td>{{item.remark}}</td>
            <td>{{item.validity}}</td>
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
                records: null        
                    }  
        },  
        mounted() {  
                this.showRecords(this.id, this);
        },
        methods: {
            showRecords: _.debounce( function (id, vm) {
                axios.get('/visit-records?id=' + id).then( res => {
                    console.log(res.data);
                    vm.records = res.data;
                });
            },350),
        }
    }
</script>
