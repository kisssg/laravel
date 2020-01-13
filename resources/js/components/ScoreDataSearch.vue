<template>
    <div>        
        {{owner?'owner:'+owner:''}}        
        {{range_start?'range:'+range_start+' '+range_end:''}}        
        {{checked?'check or not:'+checked:''}}
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary" type="button" data-toggle="modal" data-target=".bs-search-modal">+</button>
            </div>
            <input type="text" name="s" class="form-control" v-model="contract_number" placeholder="Contract Number"/>
            <span class="input-group-append">
                <input type="button" class="btn btn-primary"  value="Search" v-on:click="submit"/>
            </span>
        </div>
        <div class="modal fade bs-search-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class='modal-header'>
                        <h4 class=modal-title>多项搜索</h4>         
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class="form-group">
                            Range
                            <div class="form-group form-inline">
                                <input type="date" class="form-control form-group" v-model='range_start'/>-<input type="date" class="form-control form-group" v-model='range_end'/>
                            </div>
                        </div>
                        <div class="form-group">
                            Owner
                            <input type="text"v-model="owner"/>
                        </div>
                        <div class="form-group">
                            Status
                            checked<input type="checkbox" value="0" v-model="check"/>
                            uncheck<input type="checkbox" value="0" v-model="uncheck"/>
                        </div>
                        <div class="form-group">
                            Contract No.
                            <input type="text" v-model="contract_number"/>
                        </div>
                    </div>     
                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary"  v-on:click="submit" value="Search"/></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['project_id', 'query_string'],
        computed: {
            uncheck: {
                set(val) {
                    if (val) {
                        this.checked = "0";
                        return;
                    }
                    if(!this.check){
                        this.checked=null;
                    }
                    
                },
                get() {
                    if (this.checked === "0") {
                        return true;
                    }
                    return false;
                }
            },
            check: {
                set(val) {
                    if (val) {
                        this.checked = "1";
                        return;
                    }
                    if(!this.uncheck){
                        this.checked=null;
                    }
                },
                get() {
                    if (this.checked === "1") {
                        return true;
                    }
                    return false;
                }
            },
            keyword: {
                set(val) {
                    let regResult = /\[.+?\]/g.exec(val);
                    if (!regResult) {
                        this.contract_number = val;
                        return;
                    }
                    this.contract_number = /\[contract_no:(.+?)\]/g.exec(val) ? /\[contract_no:(.+?)\]/g.exec(val)[1] : null;
                    this.checked = /\[checked:(.+?)\]/g.exec(val) ? /\[checked:(.+?)\]/g.exec(val)[1] : null;
                    let regRange = /\[range\:(\d{4}\-\d{2}\-\d{2})\s(\d{4}\-\d{2}\-\d{2})\]/g;
                    let rangeResult = regRange.exec(val);
                    this.range_start = rangeResult ? rangeResult[1] : null;
                    this.range_end = rangeResult ? rangeResult[2] : null;
                    this.owner = /\[owner:(.+?)\]/g.exec(val) ? /\[owner:(.+?)\]/g.exec(val)[1] : null;
                },
                get() {
                    let combine = '';
                    if (this.owner) {
                        combine += "[owner:" + this.owner + "]";
                    }
                    if (this.range_start && this.range_end) {
                        combine += "[range:" + this.range_start + " " + this.range_end + "]";
                    }
                    if (this.contract_number) {
                        combine += "[contract_no:" + this.contract_number + "]";
                    }
                    if (this.checked) {
                        combine += "[checked:" + this.checked + "]";
                    }
                    return combine;
                }
            }
        },
        mounted() {
            this.keyword = this.query_string;
        },
        data() {
            return{
                range_start: null,
                range_end: null,
                defaultKeyword: null,
                owner: null,
                checked: null,
                contract_number: null
            };
        },
        methods: {
            submit: function () {
                window.location = '?s=' + encodeURIComponent(this.keyword);
            }
        }
    }
</script>