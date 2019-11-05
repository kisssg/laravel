<template>
    <div>
        <img src="picture/loading.gif" v-if="callRecords===null" alt="Loading...">
        <span v-else-if="callRecords.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>类别</th><th>接通情况</th><th>详情</th><th>骚扰情况</th><th>回访时间</th><th>ＱＣ</th></thead>
            <tr v-for="item in callRecords"><td>{{item.type}}</td>
                <td>{{item.is_connected}}</td>
                <td>{{item.remark}}</td>
                <td>{{item.is_harassed}}</td>
                <td>{{item.check_time}}</td>
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
                callRecords: null        
                    }  
        },  
        mounted() {  
            this.showRecords(this.id, this);
        },
        methods: {
            showRecords: _.debounce(function (id, vm) {
                axios.get('/call-records?hmid=' + id).then(res => {
                    console.log("call" + res.data.length);
                    vm.callRecords = res.data;
                });
            }, 350),
        }
    }
</script>
