<template>
    <div class="modal-content" style="background-color:#cce8cf">
        <div class='modal-header'>Score Card            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class='modal-body'>
            <table class="table table-bordered table-hover">
                <tbody>
                <div v-for="(item,key,index) in data_to_score" class="d-inline-block" style="padding:0 20px 3px 0;font-family: sans-serif;font-size: 16px;">
                    <span style="border: 1px solid #515151;"><span style="background-color:#515151;color: white;align-content: center">
                            <span style="font-size: 12px;padding:2px;">{{key}}</span>
                        </span>
                        <span class="user-select-all" style="font-size: 12px;padding:2px;">{{item}}</span>
                    </span>        
                </div>
                <tr v-for="(item,key,index) in items">
                    <td v-if="item.option_type==='text'">
                <text-score-item :item="item" :savedAnswer="score?score[item.score_field]:null" :ref="item.score_field"></text-score-item>
                </td>    
                <td v-else-if="item.option_type==='single'">
                <single-select-score-item :item="item" :savedAnswer="score?score[item.score_field]:null" :ref="item.score_field"></single-select-score-item>
                </td>
                <td v-else>
                Option type <b>{{item.option_type}}</b> not supported, please verify. 
                </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-family: Verdana;font-size: 18px; font-weight: bold;">Total Score:</span>
                        <span class="float-right">{{totalScore}}</span>
                    </td>
                </tr>
                <tr v-if="score">
                    <td>
                    <span>{{score.created_by+" created at "+score.created_at+". "}}</span>
                    <span class="float-right" v-if="score.updated_by">{{score.updated_by+" updated at " + score.updated_at}}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>     
        <div class="modal-footer text-center">
            <span v-model="msg" class="float-right">{{msg}}</span>
            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal" aria-label="Close">
                关闭
            </button>
            <input type="button" class="btn btn-primary" v-on:click="submitResult" value="保存"/>
        </div>
    </div>
</template>
<script>
    export default{
        props: ['project_id'],
        mounted() {
            console.log('score card mounted');
            console.log('data:');
            console.log(this.data_to_score);
            this.getItems(this.project_id, this);
            this.totalScore=this.$parent.score?this.$parent.score.score:null;
        },
        data() {
            return {
                "items": null,
                "totalScore": 0,
                'msg': ''
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
                let scoreData = this.$refs,
                        totalScore = 0,scoredCount=0,scoreNumerator=0,scoreDenominator=0;
                for (let item in scoreData) {
                    score[item] = scoreData[item][0].answer;
                    if(score[item]!=='-' && scoreData[item][0].type==='single'){
                        scoredCount++;
                    }                    
                    if(score[item] !=="-" && scoreData[item][0].needScore){
                        scoreDenominator++;
                        if(score[item] ==="1")
                            scoreNumerator++;
                    }
                    totalScore += scoreData[item][0].answer===null?0:Number(scoreData[item][0].score);
                }
                console.log('Denominator:'+scoreDenominator);
                console.log('Numerator:'+scoreNumerator);
                if(scoredCount<1){
                    this.msg='At least 1 item must be scored.';
                    return;
                }
                totalScore = totalScore > 100 ? 100 : totalScore;//总分大于100分就是100分
                totalScore = totalScore < 0 ? 0 : totalScore;//总分小于0分就是0分
                totalScore= scoreNumerator / scoreDenominator * 100; // denominator is count of items need to be scored and scorable, numerator is score goal.
                this.totalScore=isNaN(totalScore)?null:totalScore.toFixed(2);// if no items can be scored, score is null.
                score.score=isNaN(totalScore)?null:totalScore.toFixed(2);
                score.data_id = this.data_to_score.id;
                score.project_id = this.project_id;
                let url = "/project/score", args = score;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let parent = this.$parent, pickScoreBtn = 'pickScoreBtn' + score.data_id;
                let vm = this;
                vm.msg='Result submitting...';
                $.post(url, args, function (data) {
                    vm.msg = (data.msg);
                    if (data.result === "success") {
                        //@TODO:show the new score when changed.    
                        parent.$refs[pickScoreBtn].score = data.score;
                        $(".bs-score-card").modal('hide');
                    }
                }, 'json');
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