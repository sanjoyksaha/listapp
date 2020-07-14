require('./bootstrap');

window.Vue = require('vue');

//Default Components
Vue.component('master', require('./components/Master.vue').default);
Vue.component('not-found', require('./components/error/NotFound.vue').default);

//Dfine vue router
import router from './router/router'

//Define vForm
import { Form, HasError, AlertError } from 'vform'

window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Define vue filter
Vue.filter('capitalize', function(text){
    //return text.toUpperCase();
    if (!text) return ''
    text = text.toString()
    return text.charAt(0).toUpperCase() + text.slice(1)
  })

//Define moment.js with vue filter
import moment from 'moment';

Vue.filter('date', function(created_at){
    return moment(created_at).format('MMMM Do YYYY');
})

//vue progessbar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px',
})

//Define sweetalert2
import Toast from './sweetalert2/sweetalert2.js'
window.Toast = Toast;

//Define toastr.js
import toastr from './toastr/Toastr.js'
window.toastr = toastr

//Define pagination
Vue.component('pagination', require('laravel-vue-pagination'));

window.EventBus = new Vue();

//Define Gate Class
import Gate from './gate/gate.js'
Vue.prototype.$gate = new Gate(window.user); 

//Define Vuex

import Vuex from 'vuex'
import storeData from './store/index'

Vue.use(Vuex)

const store = new Vuex.Store(
  storeData,
)

const app = new Vue({
    el: '#app',
    router,
    store
});
