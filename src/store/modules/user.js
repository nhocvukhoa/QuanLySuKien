import axios from 'axios'
const userModules={
    state:{
        users:[],
        isLoginAdmin:false,
        isLoginUser:false,
    },
    getters:{
        users:state=>state.users,
        isLoginAdmin:state=>state.isLoginAdmin,
        isLoginUser:state=>state.isLoginUser
    },
    actions:{ 
        async getUsers({commit}){
            try {
                const res=await axios.get(`http://localhost/dapm1/src/Api/User/user.php`)
                commit('SET_USERS',res.data.data)
            } catch (error) {
                console.log(error)
            }
        },
    
        async setCategoryLast({commit}){
            try {
                const res=await axios.get(`http://localhost/dapm1/src/Api/Category/category.php?idCat_Create=0`)
                commit('ADD_CATEGORY',res.data.data)
            } catch (error) {
                console.log(error)
            }
        }
    },
    mutations:{
        ADD_USER(state,user){
            state.users.push(user)
        },
        SET_USERS(state,users){
            state.users=users
        },
        SET_LOGIN_ADMIN(state,isLogin){
            state.isLoginAdmin=isLogin
        },
        SET_LOGIN_USER(state,isLogin){
            state.isLoginUser=isLogin
        }
    },
    
}
export default userModules