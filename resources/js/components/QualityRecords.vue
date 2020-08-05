<template>
    <div>           
        <button v-on:click="showCamera">Camera checking score</button>
        <camera-records :id="eid" v-if="cameraShow"></camera-records>
        <button v-on:click="showDing">Dingtalk checking results</button>
        <visit-records :id="id" v-if="dingShow"></visit-records>
        <button v-on:click="showCallback">Call survey records</button>
        <callback :id="id" v-if="callbackShow"></callback>
    </div>
</template>
<script>
    export default {
        props: ['id','eid'],
        data() {  
            return {
                cameraShow:false,
                dingShow:false,
                callbackShow:false
            };
        },
        mounted() {
        },
        methods: {
            showCamera(){ this.cameraShow=true; },
            showDing(){ this.dingShow=true; },
            showCallback(){ this.callbackShow=true; }
        }
    }
</script>