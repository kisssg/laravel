<template>
    <div>        
        <training-scatter v-if="abs"></training-scatter>
        <button v-on:click="showTable">Show detail data</button>
        <traing-test :id="id" v-if="tableShow"></traing-test>                
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
            return {
                abs:false,
                tableShow:false
            };
        },
        mounted() {
        },
        methods: {
            showTable(){
                this.tableShow= !this.tableShow;
            }
        }
    }
</script>