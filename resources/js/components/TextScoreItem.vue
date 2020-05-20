<template>
    <div>
        <span style="font-family: Verdana;font-size: 18px; font-weight: normal;">{{item.order+'.'+item.title}}</span><br>
        <span style="font-family: Verdana;font-size: 9px;" class="text-muted">{{item.sub_title}}</span>
        <span class="float-right" style="width:100%">
            <textarea class="form-control " v-model="answer">
                {{answer}}
            </textarea>                  
        </span>
    </div>
</template>
<script>
    export default{
        props: ['item','savedAnswer'],
        mounted() {
            this.answer=this.savedAnswer;
        },
        data() {
            return {
                "score": null,
                "answer":null
            };
        },
        methods: {
        },
        computed: {
        }
    }
</script>