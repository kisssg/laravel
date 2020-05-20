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
                        <span style="font-size: 12px;padding:2px;">{{item}}</span>
                    </span>        
                </div>
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
                        totalScore = 0;
                for (let item in scoreData) {
                    score[item] = scoreData[item][0].answer;
                    totalScore += scoreData[item][0].answer===null?0:Number(scoreData[item][0].score);
                }
                totalScore = totalScore > 100 ? 100 : totalScore;//总分大于100分就是100分
                totalScore = totalScore < 0 ? 0 : totalScore;//总分小于0分就是0分
                this.totalScore=totalScore.toFixed(2);
                score.score=totalScore.toFixed(2);
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