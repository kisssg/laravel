<template>
    <div>        
                <traing-test :id="id"></traing-test>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data() {  
            return {
                abs:null,
            };
        },
        mounted() {
        },
        methods: {
        }
    }
</script>