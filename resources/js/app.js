/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import "babel-polyfill";
import issues from './components/Issues.vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
require('./bootstrap');
window.Vue = require('vue');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('v-select', vSelect);
Vue.component('search-box', require('./components/SearchBox.vue').default);
Vue.component('issues',issues);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        value: 'This is afasfasdfs',
        options: ['输入关键字'],
        selectedIssue: '',
        channel:'',
        statusValue:'',
        collector:'',
        contract_no:'',
        range_start:'',
        range_end:'',
        combine:''
    },
    methods: {
        searchViolation() {
            
            if (this.channel !== '') {
                this.combine += "[channel:" + this.channel + "]";
            }
            if (this.selectedIssue !== '') {
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
        fetchOptions(search, loading) {
            loading(true);
            this.search(loading, search, this);
        }, searchFunction(loading, search, vm) {
            axios.get(`/issue/issues`)
                    .then(response => {
                        vm.options = response.data;
                        loading(false);
                    })
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
        }, 350)
    }
});
