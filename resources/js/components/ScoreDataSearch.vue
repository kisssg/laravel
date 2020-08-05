<template>
    <div>        
        {{owner?'owner:'+owner:''}}        
        {{range_start?'range:'+range_start+' '+range_end:''}}        
        {{checked?'checked?:'+checked:''}}
        {{diySearchValue?diySearchItem+':'+diySearchValue:''}}
        {{diySearchValue1?diySearchItem1+':'+diySearchValue1:''}}
        {{diySearchValue2?diySearchItem2+':'+diySearchValue2:''}}
        
        <form onsubmit="event.preventDefault();">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary" type="button" data-toggle="modal" data-target=".bs-search-modal">+</button>
            </div>
            <input type="text" name="s" class="form-control" v-model="contract_number" placeholder="Contract Number"/>
            <span class="input-group-append">
                <input type="submit" class="btn btn-primary"  value="Search" v-on:click="submit"/>
            </span>
        </div>
        </form>
        <div class="modal fade bs-search-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class='modal-header'>
                        <h4 class=modal-title>Advanced search</h4>         
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form onsubmit="event.preventDefault();">
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <select v-model="diySearchItem"  class="custom-select">
                                <option v-for="item in diySearchItems" class="form-control">{{item}}</option>
                            </select>
                            </div>
                                <input type="text"  class="form-control input-group-append" v-model="diySearchValue"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <select v-model="diySearchItem1"  class="custom-select">
                                <option v-for="item in diySearchItems" class="form-control">{{item}}</option>
                            </select>
                            </div>
                                <input type="text"  class="form-control input-group-append" v-model="diySearchValue1"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <select v-model="diySearchItem2"  class="custom-select">
                                <option v-for="item in diySearchItems" class="form-control">{{item}}</option>
                            </select>
                            </div>
                                <input type="text"  class="form-control input-group-append" v-model="diySearchValue2"/>
                        </div>
                    </div>     
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary"  v-on:click="submit" value="Search"/></div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
</template>
<script>
    export default {
        props: ['project_id', 'query_string'],
        computed: {
            needRestrict(){
                if(this.contract_number && this.contract_number.trim() !=="") {return false}
                if(this.diySearchItem && this.diySearchValue && this.diySearchValue.trim() !=="" ){ return false}
                if(this.diySearchItem1 && this.diySearchValue1 && this.diySearchValue1.trim() !==""){ return false}
                if(this.diySearchItem2 && this.diySearchValue2 && this.diySearchValue2.trim() !==""){ return false}
                if(this.owner && this.owner.trim() !==""){ return false}
                return true;
            },
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
                    this.diySearchItem = /\[diy:(.+?):(.+?)\]/g.exec(val) ? /\[diy:(.+?):(.+?)\]/g.exec(val)[1] : null;
                    this.diySearchValue = /\[diy:(.+?):(.+?)\]/g.exec(val) ? /\[diy:(.+?):(.+?)\]/g.exec(val)[2] : null;

                    this.diySearchItem1 = [... val.matchAll(/\[diy:(.+?):(.+?)\]/g)].length>1?[... val.matchAll(/\[diy:(.+?):(.+?)\]/g)][1][1]:null;
                    this.diySearchValue1 = [... val.matchAll(/\[diy:(.+?):(.+?)\]/g)].length>1?[... val.matchAll(/\[diy:(.+?):(.+?)\]/g)][1][2]:null;
                    this.diySearchItem2 = [... val.matchAll(/\[diy:(.+?):(.+?)\]/g)].length>2?[... val.matchAll(/\[diy:(.+?):(.+?)\]/g)][2][1]:null;
                    this.diySearchValue2 = [... val.matchAll(/\[diy:(.+?):(.+?)\]/g)].length>2?[... val.matchAll(/\[diy:(.+?):(.+?)\]/g)][2][2]:null;
                },
                get() {
                    let combine = '';
                    if (this.owner) {
                        combine += "[owner:" + this.owner + "]";
                    }
                    if (this.range_start && this.range_end) {
                        combine += "[range:" + this.range_start + " " + this.range_end + "]";
                    }else if(this.needRestrict) {
                        combine += "[range:" + this.monthFirst + " " + this.today + "]";                    
                    }
                    if (this.contract_number) {
                        combine += "[contract_no:" + this.contract_number + "]";
                    }
                    if (this.checked) {
                        combine += "[checked:" + this.checked + "]";
                    }
                    if(this.diySearchValue){
                        combine += "[diy:"+this.diySearchItem+":"+this.diySearchValue+"]";
                    }
                    if(this.diySearchValue1){
                        combine += "[diy:"+this.diySearchItem1+":"+this.diySearchValue1+"]";
                    }
                    if(this.diySearchValue2){
                        combine += "[diy:"+this.diySearchItem2+":"+this.diySearchValue2+"]";
                    }
                    return combine;
                }
            }
        },
        mounted() {
            this.keyword = this.query_string;
            this.getDiySearchItems(this.project_id);
            let date=new Date();
            let year=date.getFullYear();
            let month=(date.getMonth()+1)>9?(date.getMonth()+1):0+""+(date.getMonth()+1)// getMonth() (0 ~ 11)
            let day = (date.getDate())>9?(date.getDate()):0+""+(date.getDate());// getDate() (1 ~ 31)
            this.today =(year+"-"+month+"-"+day);
            this.monthFirst=(year+"-"+month+"-01");
            console.log(this.needRestrict);
        },
        data() {
            return{
                range_start: null,
                range_end: null,
                defaultKeyword: null,
                owner: null,
                checked: null,
                contract_number: null,
                diySearchItems:null,
                diySearchItem:null,
                diySearchValue:null,
                diySearchItem1:null,
                diySearchValue1:null,
                diySearchItem2:null,
                diySearchValue2:null,
                today:null,
                monthFirst:null,
            };
        },
        methods: {
            submit: function () {
                window.location = '?s=' + encodeURIComponent(this.keyword);
            },
            getDiySearchItems:function(project_id){
                axios.get('/project/search_columns/'+project_id).then(res=>{
                    this.diySearchItems=res.data;
                    console.log(res.data);
                });
            }
        }
    }
</script>