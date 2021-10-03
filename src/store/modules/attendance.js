import axios from 'axios'
const attentdanceModules={
    state:{
        dsdk:[]
    },
    getters:{
        dsdk:state=>state.dsdk
    },
    actions:{
        //TODO: Xóa
        async deleteDSDK(context,id){
            try {
                await axios.delete(`Event/attendance.php?id=${id}`)
                context.commit('DELETE_DSDK',id)
            } catch (error) {
                console.log(error)
            }
        },
        async getDSDK({commit},idsk){
            try {
                const res=await axios.get(`Event/attendance.php?idSK=${idsk}`)
                commit('SET_DSDK',res.data.data)
            } catch (error) {
                console.log(error)
            }
        },
    },
    mutations:{
        SET_DSDK(state,dsdk){
            state.dsdk=dsdk
        },
        DELETE_DSDK(state,id){
            state.dsdk = state.dsdk.filter(ds => ds.IdDS !== id)
        },
    },
    
}
export default attentdanceModules