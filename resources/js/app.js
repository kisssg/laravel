/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import "babel-polyfill";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Vue from 'vue';
//import ECharts from 'vue-echarts';

require('./bootstrap');
window.Vue = require('vue');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('v-select', vSelect);
//Vue.component('v-chart', ECharts);
//Vue.component('search-box', require('./components/SearchBox.vue').default);
//Vue.component('issues', issues);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    name: 'app',
    data: {
        options: ['输入关键字'],
        collectors: ['输入催收员英文姓名', 'input english name'],
        name_en: '催收员的英文名',
        selectedCollector: '',
        selectedIssue: '',
        channel: '',
        statusValue: '',
        collector: '',
        contract_no: '',
        range_start: '',
        range_end: '',
        combine: '',
        data_to_score: null,
        score: null,
        audit:null,
        scoreCardKey:10
    },
    methods: {
        setData(value) {
            this.data_to_score = value;
        },
        setScore(value) {
            this.score = value;
        },
        setAudit(value){
          this.audit=value;  
        },
        searchViolation() {
            if (this.channel !== '') {
                this.combine += "[channel:" + this.channel + "]";
            }
            if (this.selectedIssue) {
                this.combine += "[issue:" + this.selectedIssue + "]";
            }
            if (this.statusValue !== '') {
                this.combine += "[status:" + this.statusValue + "]";
            }
            if (this.collector !== '') {
                this.combine += "[collector:" + this.collector + "]";
            }
            if (this.contract_no !== '') {
                this.combine += "[contract_no:" + this.contract_no + "]";
            }
            if (this.range_start !== '' && this.range_end !== '') {
                this.combine += "[range:" + this.range_start + " " + this.range_end + "]";
            }
            console.log(this.combine);
            window.location = '/violation/search?s=' + encodeURIComponent(this.combine);
        },
        fetchCollectors(search, loading) {
            loading(true);
            this.searchCollectors(loading, search, this);
        },
        searchCollectors: _.debounce((loading, search, vm) => {
            if (search.length < 3) {
                loading(false);
                return;
            }
            axios.get('/collector/search?s=' + search).then(res => {
                vm.collectors = res.data;
                console.log(res.data);
                loading(false);
            });
        }, 350),
        fetchOptions(search, loading) {
            loading(true);
            this.search(loading, search, this);
        },
        search: _.debounce((loading, search, vm) => {
            axios.get(
                    `/issue/issues`
                    ).then(res => {
                //res.json().then(json => (vm.options = json.items));
                console.log(res.data);
                vm.options = res.data;
                loading(false);
            });
        }, 350),
        queryString: function (item) {
            var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)", "i"));
            return svalue ? svalue[1] : svalue;
        }
    },
    mounted(combine, issuep, issuem, collectorp, collectorm, rangem, rangep, channelp, channelm, statusp, statusm, contract_nop, contract_nom) {
        combine = (decodeURIComponent(this.queryString('s')));
        issuep = /\[issue:(.+?)\]/g;
        issuem = issuep.exec(combine);
        this.selectedIssue = issuem ? (issuem[1]) : '';
        collectorp = /\[collector:(.+?)\]/g;
        collectorm = collectorp.exec(combine);
        this.collector = collectorm ? collectorm[1] : '';
        rangep = /\[range\:(\d{4}\-\d{2}\-\d{2})\s(\d{4}\-\d{2}\-\d{2})\]/g;
        rangem = rangep.exec(combine);
        this.range_start = rangem ? rangem[1] : '';
        this.range_end = rangem ? rangem[2] : '';
        statusp = /\[status:(.+?)\]/g;
        channelp = /\[channel:(.+?)\]/g;
        statusm = statusp.exec(combine);
        channelm = channelp.exec(combine);
        this.statusValue = statusm ? statusm[1] : '';
        this.channel = channelm ? channelm[1] : '';
        contract_nop = /\[contract_no:(.+?)\]/g;
        contract_nom = contract_nop.exec(combine);
        this.contract_no = contract_nom ? contract_nom[1] : '';
    }
});
