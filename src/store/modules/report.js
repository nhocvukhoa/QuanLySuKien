import axios from 'axios'
const reportModules={
    state:{
        reports:[],
        reports_clone:[],
        reports_user:[],
    },
    getters:{
       reports:state=>state.reports,
       reports_clone:state=>state.reports_clone,
       reports_user:state=>state.reports_user
    },
    actions:{ 
        async getReport({commit}){
            try {
                const res=await axios.get(`Report/report_event.php`)
                commit('SET_REPORTS',res.data.data)
            } catch (error) {
                console.log(error)
            }
        },
        async getReport_User({commit}){
            try {
                const res=await axios.get(`Report/report_user.php`)
                commit('SET_REPORTS_USER',res.data.data)
            } catch (error) {
                console.log(error)
            }
        },
    },
    mutations:{
        SET_REPORTS(state,reports){
            state.reports=reports
            state.reports_clone=reports
        },
        SET_REPORTS_USER(state,reports){
            state.reports_user=reports
        },
        SET_FILTER_REPORT(state,filter){
            if(filter.IdLSK==0 && filter.Status==-1){
                state.reports=state.reports_clone
            }
            else if(filter.IdLSK==0 && filter.Status!=-1){
                state.reports=state.reports_clone.filter(item=>item.Status==filter.Status)
            }
            else if(filter.IdLSK!=0 && filter.Status==-1){
                state.reports=state.reports_clone.filter(item=>item.IdLSK==filter.IdLSK)
            }
            else {
                state.reports=state.reports_clone.filter(item=>item.IdLSK==filter.IdLSK && item.Status==filter.Status)
            }
        }
    }
    
}
export default reportModules