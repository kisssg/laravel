<template>
    <div>
        <img src="picture/loading.gif" v-if="results===null" alt="Loading...">
        <span v-else-if="results.length===0">No onboard training records found</span>
        <table class="table" v-else>
            <thead><th>Training type</th><th>Location</th><th>Oral score</th><th>Paper score</th><th>COC score</th><th>Month</th><th>Trainer</th><th>Rent training room?</th></thead>
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