<template>
    <div class="modal-content">
        <div class='modal-header' style='color: white;background-color: lightblue'>Audit Card            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class='modal-body' style="background-color:#cce8cf">
            <table class="table-bordered table-condensed table-hover">  
                <tbody>
                <div v-for="(item,key,index) in data_to_score" :key="index" class="d-inline-block" style="padding:0 20px 3px 0;font-family: sans-serif;font-size: 16px;">
                    <span style="border: 1px solid #515151;"><span style="background-color:#515151;color: white;align-content: center">
                            <span style="font-size: 12px;padding:2px;">{{key}}</span>
                        </span>
                        <span style="font-size: 12px;padding:2px;">{{item}}</span>
                    </span>        
                </div>
                <tr v-for="(item,key,index) in items" :key="index">
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
                <tr v-if="score">
                    <td>
                    <span>{{score.created_by+" created at "+score.created_at+". "}}</span>
                    <span class="float-right" v-if="score.updated_by">{{score.updated_by+" updated at " + score.updated_at}}</span>
                    </td>
                </tr>
                <hr/>
                <tr style="background-color: lightblue;color:white">
                    <td>
                        Audit Result: 
                        <select v-model="result">
                            <option>Y</option>    
                            <option>N</option>    
                            <option></option>
                        </select>
                    </td>
                </tr>
                <tr style="background-color: lightblue;color:white">
                    <td>
                        <div>
                            <span>Remark:</span>
                            <textarea class="form-group" style="width:100%" v-model="remark"></textarea>
                        </div>
                    </td>                    
                </tr>
                <tr v-if="audit" style="background-color: lightblue;color:white">
                    <td>
                    <span>{{audit.auditor+" audited at "+audit.created_at+". "}}</span>
                    <span class="float-right" v-if="audit.updated_at">{{" updated at " + audit.updated_at}}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>     
        <div class="modal-footer text-center"  style="background-color:#cce8cf">
            <span class="float-right">{{msg}}</span>
            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal" aria-label="Close">
                关闭
            </button>
            <input type="button" class="btn btn-primary" v-on:click="submitAudit" value="保存"/>
        </div>
    </div>
</template>
<script>
    export default{
        props: ['project_id'],
        mounted() {
            console.log('audit card mounted');
            this.getItems(this.project_id, this);
            this.totalScore = this.$parent.score ? this.$parent.score.score : null;
            if(this.audit){
                this.result=this.audit.result;
                this.remark=this.audit.remark;
            }
        },
        data() {
            return {
                "items": null,
                "totalScore": 0,
                'msg': '',
                'result':null,
                'remark':null
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
            submitAudit(){
                this.msg='Audit submiting...';
                let audit={};
                audit.result=this.result;
                audit.remark=this.remark;
                audit.data_id=this.data_to_score.id;
                audit.project_id=this.project_id;
                console.log(audit);
                let url = "/project/audit", args = audit;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let parent = this.$parent, auditBtn='auditBtn'+audit.data_id;//when audit saved OK, set local audit equals the saved one
                let vm = this;
                $.post(url, args, function (data) {
                    vm.msg = (data.msg);
                    if (data.result === "success") {
                        //@TODO:show the new score when changed.    
                        parent.$refs[auditBtn].audit = data.audit;
                    }
                }, 'json');
            },
            submitResult() {
                let score = {};
                let scoreData = this.$refs,
                        totalScore = 0;
                for (let item in scoreData) {
                    score[item] = scoreData[item][0].answer;
                    totalScore += scoreData[item][0].answer === null ? 0 : Number(scoreData[item][0].score);
                }
                totalScore = totalScore > 100 ? 100 : totalScore;//总分大于100分就是100分
                totalScore = totalScore < 0 ? 0 : totalScore;//总分小于0分就是0分
                this.totalScore = totalScore.toFixed(2);
                score.score = totalScore.toFixed(2);
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
            },
            audit(){
                return this.$parent.audit;
            }
        }
    }
</script>