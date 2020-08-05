<template>
    <div>
    <camera-chart :id="id"></camera-chart>
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
        }
    }
</script>