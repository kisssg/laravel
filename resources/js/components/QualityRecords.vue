<template>
    <div>           
        <button v-on:click="showCamera">Camera records</button>
        <camera-records :id="id" v-if="cameraShow"></camera-records>
        <button v-on:click="showDing">Dingtalk records</button>
        <visit-records :id="id" v-if="dingShow"></visit-records>
        <button v-on:click="showCallback">Callback records</button>
        <callback :id="id" v-if="callbackShow"></callback>
    </div>
</template>
<script>
    export default {
        props: ['id'],
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