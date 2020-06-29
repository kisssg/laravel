<template>
    <div>
        <span class="alert-warning">{{pickResult}}</span>
        <button :class='"btn btn-sm " +btnClass' v-on:click='execute'>{{pickOrScore}}</button>
        <button :class='"btn btn-sm " +btnClass' v-if="pickOrScore==='Pick'" v-on:click="pickAll">BatchPick</button>
    </div>
</template>
<script>
    export default{
        components: {},
        props: ['id', 'user', 'project'],
        computed: {
            pickOrScore() {
                if (this.owner === '') {
                    return 'Pick';
                } else {
                    return 'Score';
                }
            },
            btnClass() {
                if (this.pickOrScore === 'Pick') {
                    return 'btn-secondary';
                } else {
                    if(this.clicked){return "btn-success"}
                    return 'btn-primary';
                }
            }
        },
        mounted() {
            this.owner = this.user;
        },
        data() {
            return {
                owner: '',
                data: null,
                score: null,
                dataFetched: false,
                pickResult: null,
                clicked:false
            };
        },
        methods: {
            execute() {
                if (this.pickOrScore === "Pick") {
                    this.pickData(this.project, this.id, this);
                } else {
                    this.clicked= true;
                    console.log(this.clicked);
                    if (!this.dataFetched) {
                        this.$emit("set-data", null);//send null data in case ajax fethch nothing and score card show the previous
                        this.$emit("set-score", null);
                        console.log('null data and score sent to app');
                        this.getData(this.id, this.project, this);
                        this.getScore(this.id, this.project, this);
                        return;
                    }
                    this.$emit("set-data", this.data);
                    this.$emit("set-score", this.score);
                    this.$parent.scoreCardKey++;
                    console.log('card key++');
                    $(".bs-score-card").modal('show');
                }
            },
            pickAll(){
                this.batchPick(this.project,this.id,this);
            },
            batchPick:_.debounce(function (project_id, data_id, vm) {
                axios.get('data/batchpick/' + data_id + '?project_id=' + project_id).then(
                        res => {                            
                            vm.pickResult = res.data.msg;
                            if (res.data.result === "failed") {
                                return;
                            }
                            vm.owner = res.data.owner;
                        }, error => {
                    return false;
                }
                );
            }, 50),
            getData: _.debounce(function (id, project, vm) {
                axios.get('data/' + id + '?project=' + project).then(res => {
                    vm.data = res.data;
                    this.dataFetched = true;
                    this.$emit("set-data", vm.data);
                    console.log('ajax got data and sent to app');
                }, error => {
                    if (error.response.status !== 200) {
                        vm.issues = "error";
                    }
                    return error;
                });
            }, 50),
            getScore: _.debounce(function (data_id, project, vm) {
                axios.get('score/' + data_id + '?project=' + project).then(res => {
                    vm.score = res.data;
                    this.scoreFetched = true;
                    this.$emit("set-score", vm.score);
                    console.log('ajax got score and sent to app');
                    this.$parent.scoreCardKey++;
                    console.log('card key++');
                    console.log(this);
                    $(".bs-score-card").modal('show');
                }, error => {
                    if (error.response.status !== 200) {
                        console.log('error triggered');
                    }
                    return false;
                });
            }, 50),
            pickData: _.debounce(function (project_id, data_id, vm) {
                axios.get('data/pick/' + data_id + '?project_id=' + project_id).then(
                        res => {
                            vm.pickResult =  res.data.msg;
                            if (res.data.result === "failed") {
                                return;
                            }
                            vm.owner = res.data.owner;
                        }, error => {
                    return false;
                }
                );
            }, 50)
        }
    }
</script>
