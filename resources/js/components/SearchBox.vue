<template>
    <div>
        <form action="" method="get">
            <input class='form-group' type='text' placeholder='英文名、工号、Homer ID' name='s' v-model='wtfValue'>
            <input class='btn btn-default btn-sm' type="submit" value="Search"/>
        </form>
        <tabs>
            <tab title="Collector's info" >
                <keep-alive>
                <img src="picture/loading.gif" v-if="collector===null" alt="Loading...">
                <span v-else-if="collector===undefined">未找到相关数据</span>
                <table class="table" v-else>
                    <tr v-for="(item, key, index) in collector" class="row">                        
                        <td class="col-3" v-if="item">{{ key }} </td><td class="col-6"  v-if="item">{{ item }} </td>
                    </tr>
                </table>
                </keep-alive>
            </tab>
            <tab title="Equipment status" v-if="ready">
                <keep-alive><device :id="employee_id"></device></keep-alive>
            </tab>
            <tab title="Training and test" v-if="ready">
                <keep-alive>
                    <training-records :id="employee_id"></training-records>
                </keep-alive>
            </tab>
            <tab title="Biz performance" v-if="ready">
                Click on legend to hide/show data.
                <keep-alive><payment-chart :id="employee_id"></payment-chart></keep-alive>
            </tab>
            <tab id="oh-hi-mark" title="Quality status:QC checking result" v-if="ready">
                <keep-alive>
                    <quality-records :id="hm_id" :eid="employee_id"></quality-records>
                </keep-alive>
            </tab>
            <tab title="Misbehavior list" v-if="ready">
                <keep-alive><issues :id="employee_id"></issues></keep-alive>
            </tab>
        </tabs>
    </div>
</template>
<script>
    import { Tabs, Tab } from 'vue-slim-tabs'
    export default {
        components: {
            Tabs, Tab
        },
        props: ['wtf'],
        computed: {
            wtfValue: {
                get() {
                    return this.wtfData;
                },
                set(value) {
                    this.wtfData = value;
                }
            }
        },
        mounted() {
            this.wtfData = this.wtf;
            this.searchLLI(this.wtf, this);
        },
        data() {
            return{
                "collector": null,
                "collector_name": '999999999',
                "wtfData": '',
                "employee_id": '999999999',
                "hm_id": "999999999",
                "ready": false,
            };
        },
        methods: {
            searchLLI: _.debounce(function (newVal, vm) {
                axios.get('/collector/get?id=' + newVal).then(res => {
                    vm.collector = res.data[0];
                    if (vm.collector) {
                        vm.collector_name = res.data[0].name_cn;
                        vm.employee_id = res.data[0].employee_id;
                        vm.hm_id = res.data[0].cfc_hm_id;
                        vm.ready=true;
                        vm.encryptID();
                    }
                });
            }, 1000),
            encryptID(){
                if(this.collector){
                    this.collector.person_id="***";
                }
            }
        }
    }
</script>
<style src="vue-slim-tabs/themes/default.css"></style>