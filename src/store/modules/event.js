import axios from 'axios'
const eventModules={
    state:{
        events:[],
        events_not:[],
        eventsUser:[],
        eventsUser_clone:[],
        listEventRegisterUser:[],
        event:{},
        name_event:'',
    },
    getters:{
        events:state=>state.events,
        events_not:state=>state.events_not,
        eventsUser:state=>state.eventsUser,
        eventID:state=>state.event,
        name_event:state=>state.name_event,
        listEventRegisterUser:state=>state.listEventRegisterUser
    },
    actions:{
        //TODO: Xóa
        async deleteEvent(context,id){ //context=>{commit} thì bỏ context ở dưới
            try {
                await axios.delete(`Event/event.php?id=${id}`)
                context.commit('DELETE_EVENT',id)
            } catch (error) {
                console.log(error)
            }      
        },
            async getEvent({commit}){
                try {
                    const res=await axios.get(`http://localhost/dapm1/src/Api/Event/event.php`)
                    commit('SET_EVENTS',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            async getEventUser({commit},idUser){
                try {
                    const res=await axios.get(`Event/eventUser.php?idUser=${idUser}`)
                    commit('SET_EVENTSUSER',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            async getListEventRegisterUser({commit},idUser){
                try {
                    const res=await axios.get(`Event/eventUser.php?idUserDS=${idUser}`)
                    commit('SET_LISTEVENTS_REGISTER_USER',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            //TODO: Lấy id sự kiện
            async getEventID({commit},idEvt){
                try {
                    const res=await axios.get(`http://localhost/dapm1/src/Api/Event/event.php?idEvt=${idEvt}`)
                    commit('SET_EVENTID',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            async setEventLast({commit}){
                try {
                    const res=await axios.get(`http://localhost/dapm1/src/Api/Event/event.php?idEvt_Create=0`)
                    commit('ADD_EVENT',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            }
    },
    mutations:{
        DELETE_EVENT(state,id){
            state.events = state.events.filter(evt => evt.IdSK !== id)
        },
        ADD_EVENT(state,event){
            state.events.push(event)
        },
        SET_EVENTS(state,events){
            state.events=events.filter(item=>item.Status!=0)
            state.events_not=events.filter(item=>item.Status==0)
        },
        SET_EVENTSUSER(state,events){
            state.eventsUser=events
            state.eventsUser_clone=events
        },
        SET_FILTER_EVENTS_USER(state,filter){
            if(filter.IdLSK==0 && filter.Status==-1){
                state.eventsUser=state.eventsUser_clone
            }
            else if(filter.IdLSK==0 && filter.Status!=-1){
                state.eventsUser=state.eventsUser_clone.filter(item=>item.Status==filter.Status)
            }
            else if(filter.IdLSK!=0 && filter.Status==-1){
                state.eventsUser=state.eventsUser_clone.filter(item=>item.IdLSK==filter.IdLSK)
            }
            else {
                state.eventsUser=state.eventsUser_clone.filter(item=>item.IdLSK==filter.IdLSK && item.Status==filter.Status)
            }
        },
        SET_SEARCH_EVENTS_USER(state,key_search){
            state.eventsUser=state.eventsUser_clone.filter(item=>item.NameSK.search(key_search)!=-1)
        },
        SET_LISTEVENTS_REGISTER_USER(state,events){
            state.listEventRegisterUser=events
        },
        UPDATE_EVENTS(state,event){
            state.events.map(evt=> {
                if(evt.IdSK==event.IdSK){
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                    evt.NameLoaiSK=event.NameLoaiSK
                }
            })
        },
        SET_EVENTID(state,event){
            state.event=event
        },
        SET_NAMEEVENT(state,name_event){
            state.name_event=name_event
        },
    },
    
}
export default eventModules