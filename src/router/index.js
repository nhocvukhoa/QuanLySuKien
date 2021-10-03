import axios from 'axios'
import Vue from 'vue'
import VueRouter from 'vue-router'
import guards from '@/guards'
// import Home from '../views/Home.vue'

Vue.use(VueRouter)
axios.defaults.baseURL='http://localhost/dapm1/src/Api/'
const router = new VueRouter({
  mode: 'history',
  routes : [
    // {
    //   path:'/:pathMatch(.*)*',
    //   name:'Error',
    //   meta:{layout:'black'},
    //   component:()=>import('@/views/Error.vue')
    // },
    {
      path:'/',
      name:'Home',
      meta:{layout:'defaultclient'},
      component:()=>import('@/views/client/Home.vue')
    },
    {
      path:'/event/:id',
      name:'Event',
      meta:{layout:'defaultclientsite'},
      component:()=>import('@/views/client/Event.vue')
    },
    {
      path:'/listregisterevent/',
      name:'List Register',
      meta:{layout:'defaultclient'},
      component:()=>import('@/views/client/ListEventRegister'),
      beforeEnter:guards.authenticate
    },
    {
      path:'/admin/login',
      name:'Login',
      meta:{layout:'black'},
      component:()=>import('../views/admin/Login.vue')
    },
    {
      path:'/admin/home',
      name:'homeAdmin',
      meta:{
        layout:'defaultadmin',
      },
      component:()=>import('../views/admin/Home.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/category',
      name:'Category',
      meta:{layout:'defaultadmin'},
      component:()=>import('../views/admin/Category/Category.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/event',
      name:'EventAdmin',
      meta:{layout:'defaultadmin'},
      component:()=>import('../views/admin/Event/Event.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/checkevent',
      name:'CheckEventAdmin',
      meta:{layout:'defaultadmin'},
      component:()=>import('../views/admin/Event/CheckEvent.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/event/attendance/:id',
      name:'Event Attendance',
      meta:{layout:'defaultadmin'},
      component:()=>import('../views/admin/Event/Attendance.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/report/event',
      name:'ReportEvent',
      meta:{layout:'defaultadmin'},
      component:()=>import('@/views/admin/Report/Report_event.vue'),
      beforeEnter: guards.accessApp
    },
    {
      path:'/admin/report/user',
      name:'ReportEvent',
      meta:{layout:'defaultadmin'},
      component:()=>import('@/views/admin/Report/Report_user.vue'),
      beforeEnter: guards.accessApp
    },
  
  ]
});
export default router
