<template>
    <div>
        <form action="" method="get">
            <input class='form-group' type='text' placeholder='英文名、工号、Homer ID' name='s' v-model='wtfValue'>
            <input class='btn btn-default btn-sm' type="submit" value="Search"/>
        </form>
        <tabs>
            <tab title="Collector's info" >
                <img src="picture/loading.gif" v-if="collector===null" alt="Loading...">
                <span v-else-if="collector===undefined">未找到相关数据</span>
                <table class="table" v-else>
                    <tr v-for="(item, key, index) in collector" class="row">                        
                        <td class="col-3">{{ key }} </td><td class="col-6">{{ item }} </td>
                    </tr>
                </table>
            </tab>
            <tab title="Equipment status">
                Camera device & Tablet status
            </tab>
            <tab title="Training and test">
                <tabs>
                    <tab title='Training'>
                        <keep-alive><traing-test :id="employee_id"></traing-test></keep-alive>
                    </tab>
                    <tab title='Monthly'>
                        <keep-alive><online-test :id="employee_id"></online-test></keep-alive>
                    </tab>
                </tabs>
            </tab>
            <tab title="Biz performance">
                Recovery rate & Recovery amount
            </tab>
            <tab id="oh-hi-mark" title="Quality status:QC checking result">
                <tabs>
                    <tab title='Camera checking'>
                        <keep-alive><camera-records :id="hm_id"></camera-records></keep-alive>
                    </tab>
                    <tab title='Visit validation'>
                        Visit validation
                        <keep-alive><visit-records :id="hm_id"></visit-records></keep-alive>                        
                    </tab>
                    <tab title='Callback'>
                        <keep-alive><callback :id="hm_id"></callback></keep-alive>
                    </tab>
                    <tab title='Mystery checking'>
                        count checked, average score
                    </tab>
                </tabs>
            </tab>
            <tab title="Misbehavior list">
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
                "hm_id": "999999999"
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
                    }
                });
            }, 1000)
        }
    }
</script>
<style src="vue-slim-tabs/themes/default.css"></style>