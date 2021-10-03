<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
    </a-breadcrumb>
     <div :style="{ padding: '24px', background: '#fff', minHeight: '560px' }">
      <em><h5>Chào mừng {{nameUser}} đến với trang {{PowerUser}} !!</h5></em>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      PowerUser:"",
      nameUser:"",
    }
  },
  mounted() {
    this.checkUser()
  },
  created(){
  
  },
  methods: {
   checkUser(){
     let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
      this.PowerUser=user['Power']==1?"Admin":"Giáo viên"
      this.nameUser=user['Name']
   }
  },
};
</script>

<style scoped>

</style>