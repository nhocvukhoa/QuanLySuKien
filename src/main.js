import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Antd from 'ant-design-vue';
import Vue2Editor from "vue2-editor";

//import BootstrapVue from 'bootstrap-vue'
import 'ant-design-vue/dist/antd.css';
// import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css'
import 'jszip'
import 'pdfmake'
import 'datatables.net-buttons-bs4'
import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
import 'datatables.net-buttons/js/buttons.colVis'
import 'datatables.net-buttons/js/buttons.flash'
import 'datatables.net-buttons/js/buttons.html5'
import 'datatables.net-buttons/js/buttons.print'
//require('@/assets/css/datatable.css')
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//import Datatable from './views/admin/utils/Datatable/Datatable.vue'
import Defaultadmin from './layouts/admin/Defaultadmin'
import Defaultclient from './layouts/client/Defaultclient'
import DefaultclientSite from './layouts/client/DefaultclientSite'
import Black from './layouts/Black.vue'
library.add(fab, fas, far);
window.axios = require('axios')
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('defaultadmin-layout',Defaultadmin)
Vue.component('black-layout',Black)
Vue.component('defaultclient-layout',Defaultclient)
Vue.component('defaultclientsite-layout',DefaultclientSite)
//Vue.component('datatable', Datatable)
//Vue.use(BootstrapVue)
Vue.use(Antd);
Vue.use(Vue2Editor);
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
