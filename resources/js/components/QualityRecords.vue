<template>
    <div>           
                        <camera-records :id="id"></camera-records>
                        <visit-records :id="id"></visit-records>
                        <callback :id="id"></callback>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
            return {
            };
        },
        mounted() {
        },
        methods: {
        }
    }
</script>