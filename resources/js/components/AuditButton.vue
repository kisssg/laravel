<template>
    <div>
        <button :class='"btn btn-sm " +btnClass' v-on:click='execute' :hidden=isAuditable>Audit</button>
    </div>
</template>
<script>
    export default{
        components: {},
        props: ['id', 'user', 'project'],
        computed: {
            isAuditable() {
                if (this.owner === '') {
                    return true;
                } else {
                    return false;
                }
            },
            btnClass() {                 
                    if(this.clicked){return "btn-warning"}
                    return 'btn-secondary';
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
                audit:null,
                dataFetched: false,
                auditFetched:false,
                pickResult: null,
                clicked:false
            };
        },
        methods: {
            execute() {
                this.clicked=true;
                    if (!this.dataFetched||!this.auditFetched) {
                        this.$emit("set-data", null);//send null data in case ajax fethch nothing and score card show the previous
                        this.$emit("set-score", null);
                        this.$emit("set-audit",null);
                        console.log('null data and score sent to app');
                        this.getData(this.id, this.project, this);
                        this.getScore(this.id, this.project, this);
                        return;
                    }
                    this.$emit("set-data", this.data);
                    this.$emit("set-score", this.score);
                    this.$emit("set-audit",this.audit);
                    this.$parent.scoreCardKey++;
                    console.log('card key++');
                    $(".bs-audit-card").modal('show');                
            },
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
                    this.getAudit(data_id, project, vm);
                }, error => {
                    if (error.response.status !== 200) {
                        console.log('error triggered');
                    }
                    return false;
                });
            }, 50),
            getAudit:_.debounce(function(data_id,project,vm){
                axios.get('audit/'+data_id+'?project='+project).then(res=>{
                    vm.audit=res.data;//fetch audit and set this.audit
                    this.auditFetched=true;//set flag
                    this.$emit('set-audit',vm.audit);//sent to parent app.js for auditCard to fetch,set audit card computed audit
                    console.log('audit got and sent to app');
                    console.log(vm.audit);
                    this.$parent.scoreCardKey++;
                    console.log('card key++');
                    console.log(this);
                    $(".bs-audit-card").modal('show');
                });
            },50)
        }
    }
</script>
