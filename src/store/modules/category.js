import axios from 'axios'
const categoryModules={
    state:{
        categorys:[],
        category:{},
        categoryLast:{}
    },
    getters:{
        categorys:state=>state.categorys,
        categoryID:state=>state.category,
        categoryLast:state=>state.categoryLast
    },
    actions:{
        async deleteCategory(context,id){ //context=>{commit} thì bỏ context ở dưới
            try {
                await axios.delete(`Category/category.php?id=${id}`)
                context.commit('DELETE_CATEGORY',id)
            } catch (error) {
                console.log(error)
            }
                
            },
            async addTodo({commit},newTodo){
                try {
                    await axios.post(`https://jsonplaceholder.typicode.com/todos`,newTodo)
                    commit('ADD_TODO',newTodo)
                } catch (error) {
                    console.log(error)
                }
                
            },
            async getCategory({commit}){
                try {
                    const res=await axios.get(`Category/category.php`)
                    commit('SET_CATEGORYS',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            //TODO: Lấy id
            async getCategoryID({commit},idCat){
                try {
                    const res=await axios.get(`Category/category.php?idCat=${idCat}`)
                    commit('SET_CATEGORYID',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            },
            async setCategoryLast({commit}){
                try {
                    const res=await axios.get(`Category/category.php?idCat_Create=0`)
                    commit('ADD_CATEGORY',res.data.data)
                } catch (error) {
                    console.log(error)
                }
            }
    },
    mutations:{
        DELETE_CATEGORY(state,id){
            state.categorys = state.categorys.filter(cat => cat.IdLoaiSK !== id)
        },
        ADD_CATEGORY(state,category){
            state.categorys.push(category)
        },
        SET_CATEGORYS(state,categotys){
            state.categorys=categotys
        },
        UPDATE_CATEGORYS(state,categoty){
            state.categorys.map(cat=> {
                if(cat.IdLoaiSK==categoty.IdLoaiSK){
                    cat.NameLoaiSK=categoty.NameLoaiSK
                }
            })
        },
        SET_CATEGORYID(state,categoty){
            state.category=categoty
        },
        SET_CATEGORYLAST(state,categoty){
            state.categoryLast=categoty
        },
    },
    
}
export default categoryModules