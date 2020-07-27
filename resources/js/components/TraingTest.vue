<template>
    <div>
        <img src="picture/loading.gif" v-if="results===null" alt="Loading...">
        <span v-else-if="results.length===0">No onboard training records found</span>
        <table class="table" v-else>
            <thead><th>Training type</th><th>Training date</th><th>Location</th><th>Business</th><th>Much</th><th>VRD</th><th>Phone collection</th><th>Oral score</th><th>General score</th><th>COC score</th><th>Trainer</th><th>Rent training room?</th></thead>
        <tr v-for="item in results">
            <td>{{item.training_type}}</td>
            <td>{{item.training_date}}</td>
            <td>{{item.training_location}}</td>
            <td>{{item.business_score}}</td>
            <td>{{item.much_score}}</td>
            <td>{{item.vrd_score}}</td>
            <td>{{item.phone_score}}</td>
            <td>{{item.oral_score}}</td>
            <td>{{item.general_score}}</td>
            <td>{{item.coc_score}}</td>
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