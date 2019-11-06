<template>
    <div>
        <form action="" method="get">
            <input class='form-group' type='text' placeholder='输入关键字...' name='s' v-model='wtfValue'>
            <input class='btn btn-default btn-sm' type="submit" value="Search"/>
        </form>
        <tabs :onSelect="onSelect">
            <tab title="Collector's info" >
                <img src="picture/loading.gif" v-if="collector===null" alt="Loading...">
                <span v-else-if="collector===undefined">未找到相关数据</span>
                <table class="table" v-else>
                    <tr v-for="(item, key, index) in collector" class="row">                        
                        <td class="col-3">{{ key }} </td><td class="col-6">{{ item }} </td>
                    </tr>
                </table>
            </tab>
            <tab title="Test Results">
                <tabs>
                    <tab title='Training'>
                        <traing-test :id="employee_id"></traing-test>
                    </tab>
                    <tab title='Monthly'>
                        <online-test :id="employee_id"></online-test>
                    </tab>
                </tabs>
            </tab>
            <tab id="oh-hi-mark" title="QC Records">
                <tabs :onSelect="onSelect">
                    <tab title='Callback'>
                        <callback :id="hm_id"></callback>
                    </tab>
                    <tab title='Dingtalk'>
                        <visit-records :id="hm_id"></visit-records>
                    </tab>
                    <tab title='Camera'></tab>
                </tabs>
            </tab>
            <tab title-slot="issues">
                <issues :id="employee_id"></issues>
            </tab>
            <template slot="issues">
                Issues
            </template>
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
                    console.log(res.data);
                    vm.collector = res.data[0];
                    if (vm.collector) {
                        vm.collector_name = res.data[0].name_cn;
                        vm.employee_id = res.data[0].employee_id;
                        vm.hm_id = res.data[0].cfc_hm_id;
                    }
                });
            }, 1000),
            onSelect(e, index) {
                // e: click event
                // index: index of selected tab
                console.log(e);
            }
        }
    }
</script>
<style src="vue-slim-tabs/themes/default.css"></style>