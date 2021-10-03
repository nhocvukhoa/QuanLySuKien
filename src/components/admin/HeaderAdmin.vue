<template>
  <a-layout-header style="background: #fff; padding: 0">
    <div class="header">
        <div class="search_event">
            <a-input-search placeholder="Nhập từ khóa ...." style="width: 400px;" @search="onSearch" class="input_search"/>
        </div>
        <div class="d-flex align-items-center">
            <font-awesome-icon icon="bell" class="mr-3 mr-3" style="font-size:17pt"/>
            <a-dropdown-button>
                {{nameUser}}
                <a-menu slot="overlay">
                    <a-menu-item key="1"> <a-icon type="info-circle" class="icon_ant"/>Thông tin cá nhân</a-menu-item>
                    <a-menu-item key="2" @click="resetPass()"> <a-icon type="lock" class="icon_ant"/>Đổi mật khẩu </a-menu-item>
                    <a-menu-item key="3" @click="logout()"> <a-icon type="logout" class="icon_ant"/>Đăng xuất </a-menu-item>
                </a-menu>
                <a-icon slot="icon" type="user" style="padding-bottom:7px"/>
            </a-dropdown-button>
        </div>
    </div>
     <a-modal
      title="Đổi mật khẩu"
      :visible="visiblePass"
      :confirm-loading="confirmLoading"
      :footer="null"
      @ok="handleOkPass"
      @cancel="handleCancelPass"
    >
      <ResetPassword :idUser="idUser"/>
    </a-modal>
</a-layout-header>
</template>

<script>
import ResetPassword from '@/components/ResetPassword.vue'
export default {
    components: {
    ResetPassword
  },
    data(){
        return {
            nameUser:"",
            visiblePass:false,
            confirmLoading: false,
            idUser:""
        }
    },
    mounted(){
        this.checkUser()
    },
    created(){
       
    },
    methods:{
        onSearch(){},
        checkUser(){
            let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
            this.nameUser=user['Name']
        },
        logout(){
            sessionStorage.removeItem("tokenloginAdmin");
            this.$router.push("/admin/login");
            window.location.reload();
        },
         handleOkPass(){
        this.visiblePass=false
        },
         handleCancelPass(){
        this.visiblePass=false
        },
        resetPass(){
        let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
        this.idUser=user['Id']
        this.visiblePass=true
        }
    }
}
</script>

<style scoped>
.header {
    margin: 0 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.search_event span input{
  padding: 30px;
}
.icon_ant {
    padding-bottom: 7px !important;
}
</style>