import Vue from 'vue'
import Vuex from 'vuex'
import category from './modules/category'
import event from './modules/event'
import attendance from './modules/attendance'
import user from './modules/user'
import report from './modules/report'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    category,event,attendance,user,report
  }
})
