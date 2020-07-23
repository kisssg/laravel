<template>
    <div>        
                <traing-test :id="id"></traing-test>
                <online-test :id="id"></online-test>
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