
export default {
  authenticate: (to, from, next) => {
    let user = JSON.parse(sessionStorage.getItem("tokenloginUser"));
    if(user==null){
      return next({ path: '/' })
    }
    else {
      return next()
    }    
  },
  accessApp: (to, from, next) => {
    let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
    if(user==null){
      return next({ path: '/admin/login' })
    }
    else {
      return next()
    }    
  },
}