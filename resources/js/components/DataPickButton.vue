<template>
    <div>
        <button :class='"btn btn-sm " +btnClass' v-on:click='execute'>{{pickOrScore}}</button>
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
                score:null,
                dataFetched: false,
            };
        },
        methods: {
            execute() {
                if (this.pickOrScore === "Pick") {
                    console.log('pick');
                    this.owner = 'Roug.Zhang';
                } else {
                    this.$parent.scoreCardKey++;
                    $(".bs-score-card").modal('show');
                    if (!this.dataFetched) {                        
                        this.$emit("set-data", null);//send null data in case ajax fethch nothing and score card show the previous
                        this.$emit("set-score",null);
                        this.getData(this.id, this.project, this);
                        this.getScore(this.id,this.project,this);
                        return;
                    }
                    this.$emit("set-data", this.data);
                    this.$emit("set-score", this.score);
                }
            },
            getData: _.debounce(function (id, project, vm) {
                axios.get('data/' + id + '?project=' + project).then(res => {
                    vm.data = res.data;
                    this.dataFetched = true;
                    this.$emit("set-data", vm.data);
                    console.log(id);
                }, error => {
                    if (error.response.status !== 200) {
                        vm.issues = "error";
                    }
                    return error;
                });
            }, 50),
            getScore:_.debounce(function(data_id,project,vm){
                axios.get('score/'+data_id+'?project='+project).then(res=>{
                    vm.score=res.data;
                    this.scoreFetched=true;
                    this.$emit("set-score",vm.score);
                    console.log(data_id);
                },error=>{
                    if(error.response.status!==200){
                        console.log('error triggered');
                    }
                    return false;
                });
            },50)
        }
    }
</script>
