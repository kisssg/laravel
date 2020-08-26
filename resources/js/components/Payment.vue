<template>
    <div>
    <payment-chart :id="id"></payment-chart>
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
        },
        methods: {
            showTest: _.debounce(function (id, vm) {
                axios.get('/payment/' + id).then(res => {
                    vm.results = res.data;
                });
                } , 1000)
        }
    }
</script>