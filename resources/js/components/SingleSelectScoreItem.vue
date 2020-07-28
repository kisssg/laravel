<template>
    <div>
        <span style="font-family: Verdana;font-size: 18px; font-weight: normal;">{{item.order+'.'+item.title}}</span><br>
        <span style="font-family: Verdana;font-size: 9px;" class="text-muted">{{item.sub_title}}</span>
        <span class="float-right">
            <select v-model="answer">
                <option  v-for="(option,index) in item.options.split(',')" :selected="option===answer">{{option}}</option>
            </select>                   
        </span>
    </div>
</template>
<script>
    export default{
        props: ['item', 'savedAnswer'],
        mounted() {
            if (this.savedAnswer) {
                this.answer = this.savedAnswer;
                return;
            }
            this.answer='-';//default answer
        },
        data() {
            return{
                "answer": null,
                "type":"single"
            };
        },
        methods: {
        },
        computed: {
            score() {
                if(this.needScore===false)
                    return null;
                let options = this.item.options.split(',');
                for (let i = 0; i < options.length; i++) {
                    if (options[i] === this.answer) {
                        return this.item.scores.split(',')[i];
                    }
                }
                },
                needScore(){
                    return this.item.scores === "null" ? false:true;
                }
            }
        }    
</script>