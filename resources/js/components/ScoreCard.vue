<template>
    <div class="modal-content">
        <div class='modal-header'>Score Card            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class='modal-body'>
            <table class="table-bordered table-condensed">             
                <span v-for="(item,key,index) in data_to_score" style="padding:5px 5px 5px 5px;font-family: sans-serif;font-size: 16px;">
                    <span class='badge badge-success'>{{key}}: {{item}}</span>             
                </span>
                <tr v-for="(item,key,index) in items">
                    <td v-if="item.option_type==='text'">
                <text-score-item :item="item" :savedAnswer="score?score[item.score_field]:null" :ref="item.score_field"></text-score-item>
                </td>    
                <td v-else-if="item.option_type==='remark'">

                </td>
                <td v-else>
                <single-select-score-item :item="item" :savedAnswer="score?score[item.score_field]:null" :ref="item.score_field"></single-select-score-item>
                </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-family: Verdana;font-size: 18px; font-weight: bold;">Total Score:</span>
                        <span class="float-right">{{totalScore}}</span>
                    </td>
                </tr>
            </table>
        </div>     
        <div class="modal-footer text-center">        
            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal" aria-label="Close">
                取消
            </button>
            <input type="button" class="btn btn-primary" v-on:click="submitResult" value="确定"/>
        </div>
    </div>
</template>
<script>
    export default{
        props: ['project_id'],
        mounted() {
            console.log('score card mounted');
            this.getItems(this.project_id, this);
        },
        data() {
            return {
                "items": null,
                "totalScore": 0
            };
        },
        methods: {
            getItems: _.debounce(function (id, vm) {
                axios.get('item?json=1&project=' + id).then(res => {
                    vm.items = res.data;
                }, error => {
                    if (error.response.status !== 200) {
                        console.log('error triggered');
                    }
                    return false;
                });
            }, 50),
            submitResult() {
                let score = {};
                let scoreData=this.$refs;
                for (let item in scoreData) {
                    score[item]=scoreData[item][0].answer;
                }
                score.data_id= this.data_to_score.id;
                let url = "score/?project=" + this.project_id, args = score;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log(score);
                $.post(url, args, function (data) {
                    console.log("data is"+data);
                }, 'json');
            },
            setItemScore(index, score) {
                $("#score" + index).val(score);
                let items = $(".scoreToAdd");
                let totalScore = 0;
                for (let i = 0; i < items.length; i++) {
                    totalScore += Number(items[i].value);
                }
                totalScore = totalScore > 100 ? 100 : totalScore;//总分大于100分就是100分
                totalScore = totalScore < 0 ? 0 : totalScore;//总分小于0分就是0分
                this.totalScore = totalScore;
            },
            selectedScore(scoreItem) {
                console.log($('.' + scoreItem + ' '));
                //已评分项的得分
            }
        },
        computed: {
            data_to_score() {
                return this.$parent.data_to_score;
            },
            score() {
                return this.$parent.score;
            }
        }
    }
</script>