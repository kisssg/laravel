<template>
    <div>
        <img src="picture/loading.gif" v-if="results===null" alt="Loading...">
        <span v-else-if="results.length===0">无相关数据</span>
        <table class="table" v-else>
            <thead><th>Device</th><th>Status</th><th>Remark</th><th>Updated at</th></thead>
        <tr v-for="item in results"><td>{{item.device}}</td>
            <td>{{item.status}}</td>
            <td>{{item.remark}}</td>
            <td>{{item.updated_at}}</td>
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
            this.showDeviceStatus(this.id, this);
        },
        methods: {
            showDeviceStatus: _.debounce(function (id, vm) {
                axios.get('/device/' + id).then(res => {
                    vm.results = res.data;
                });
                } , 1000)
        }
    }
</script>