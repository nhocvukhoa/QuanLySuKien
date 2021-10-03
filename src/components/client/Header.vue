<template>
  <div class="bg-main header-nav">
    <nav class="header_navbar">
      <div class="d-flex justify-content-start">
        <div id="logo" class="">
          <router-link to="/"
            ><img src="@/assets/logo.png" alt="logo"
          /></router-link>
        </div>

        <div id="header-search-wrapper" class="my-2">
          <div>
            <input
              type="text"
              value=""
              placeholder="Tìm tất cả ..."
              v-model="key_search"
            />
            <button @click="onSearch()"><font-awesome-icon icon="search" /></button>
          </div>
        </div>
        <div
          class="p-0 px-3 ml-auto border-0 btnmenu_navbar d-flex align-items-center d-lg-none"
        >
          <font-awesome-icon
            icon="bars"
            style="font-size: 25pt"
            id="btnmenu"
            class="text-white"
          />
        </div>
        <div class="navbar-collapse" id="listmenu">
          <ul class="mr-auto navbar-menu d-block d-lg-flex">
            <!-- <li><router-link to="/">Trang chủ</router-link></li> -->
          </ul>
          <div class="login-wrapper d-flex justify-content-end align-items-center">
            <div class="mr-2 icon-notifi" v-if="isLoginUser">
              <font-awesome-icon icon="bell" style="font-size: 18pt" class="text-white" />
            </div>
            <button  v-if="!isLoginUser" @click="showModal()">
              <font-awesome-icon icon="user-circle" />Đăng nhập
            </button>
            <div class="btnLogin_hover">
              <button v-if="isLoginUser">
                <font-awesome-icon icon="user-circle" />{{nameUserLogin}}
              </button>
              <div class="px-3 py-2 hover_btnlogin">
                <ul class="p-0">
                  <li class="my-1">
                    <router-link to="/user">Thông tin cá nhân</router-link>
                  </li>
                  <li class="my-1">
                    <router-link to="/listregisterevent/">Sự kiện đăng ký</router-link>
                  </li>
                  <li class="my-1" @click="resetPass()">
                    <a href="#">Đổi mật khẩu</a>
                  </li>
                  <li class="my-1" @click="logout()"><a href="#">Đăng xuất</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
     <a-modal
      title="Đăng nhập"
      :visible="visible"
      :confirm-loading="confirmLoading"
      :footer="null"
      @ok="handleOk"
      @cancel="handleCancel"
    >
      <Login/>
    </a-modal>
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
  </div>
</template>

<script>
import Login from '@/components/client/Login.vue'
import ResetPassword from '@/components/ResetPassword.vue'
import { mapGetters,mapMutations } from 'vuex'
export default {
  name: "Header",
  components: {
    Login,ResetPassword
  },
  
 data() {
    return {
      nameUserLogin: "",
      visible: false,
      visiblePass:false,
      confirmLoading: false,
      key_search:"",
      idUser:""
    };
  },
   methods: {
     ...mapMutations(['SET_LOGIN_USER','SET_SEARCH_EVENTS_USER']),
    getNameUser(){
      let user = JSON.parse(sessionStorage.getItem("tokenloginUser"));
      if(user!=null){
        this.SET_LOGIN_USER(true)
        this.nameUserLogin=user['Name']
      }
      
    },
    showModal() {
      this.visible = true;
    },
    handleOk() {
      this.ModalText = 'The modal will be closed after two seconds';
      this.confirmLoading = true;
      setTimeout(() => {
        this.visible = false;
        this.confirmLoading = false;
      }, 2000);
    },
    handleOkPass(){
      this.visiblePass=false
    },
    handleCancel() {
      this.visible = false;
    },
    handleCancelPass(){
      this.visiblePass=false
    },
    onSearch(){
       this.$router.push("/");
       setTimeout(() => {
         this.SET_SEARCH_EVENTS_USER(this.key_search)
       }, 150);
    },
    logout() {
      sessionStorage.removeItem("tokenloginUser");
      this.SET_LOGIN_USER(false)
      this.$router.push("/");
      window.location.reload();
    },
    resetPass(){
      let user = JSON.parse(sessionStorage.getItem("tokenloginUser"));
      this.idUser=user['Id']
      this.visiblePass=true
    }
  },
  computed: {
      ...mapGetters(['isLoginUser'])
  },
  created() {
    this.getNameUser()
  },
};
</script>

<style>
#listmenu .router-link-exact-active {
  color: #ffffff !important;
}
.bg-main {
  background: #0b46ae;
}
ul {
  list-style: none;
  padding: 0;
}
a:hover {
  text-decoration: none;
}
.main-wrapper {
  padding: 0 0.9375rem;
  padding-top: 6.25rem;
  min-height: 100%;
  background: #eef3f7;
}
.header-nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
}
.header_navbar {
  padding: 0.5rem 1rem;
  align-items: center;
}
.header_navbar > div {
  flex-wrap: wrap;
}
#logo {
  display: inline-block;
  padding-top: 0.3125rem;
  padding-bottom: 0.3125rem;
  margin-right: 1rem;
}
#logo img {
  width: 55px;
  height: 55px;
  margin: auto;
}
#header-search-wrapper {
  width: calc(100% - 150px);
  display: flex;
}
#header-search-wrapper > div {
  width: 100%;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
#header-search-wrapper input {
  width: 100%;
  border-radius: 5px;
  border: none;
  padding: 7px 5px;
  font-size: 11pt;
  padding-right: 35px;
}
#header-search-wrapper button {
  position: absolute;
  right: 5px;
  background-color: transparent;
  border: none;
  top: 50%;
  transform: translateY(-50%);
}
#header-search-wrapper button:focus,
#header-search-wrapper input:focus {
  outline: none;
}
.navbar-collapse {
  align-items: center;
  justify-content: space-between;
  display: block;
}
.navbar-menu {
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
}
.navbar-menu li {
  padding: 10px;
  margin-right: 25px;
}
.navbar-menu li:last-child {
  margin-right: 0;
}
.navbar-menu li a {
  color: #d1d3d4;
  font-size: 11pt;
  font-weight: 500;
  transition: 0.8s;
}
.navbar-menu li a:hover {
  color: #ffffff;
  transition: 0.8s;
}
.login-wrapper {
  position: relative !important;
}
.btnLogin_hover:hover .hover_btnlogin {
  display: block;
}
#listmenu button {
  background-color: transparent;
  padding: 10px 15px;
  border: none;
  box-shadow: none;
  display: flex;
  align-items: center;
  color: #ffffff;
  font-size: 11pt;
  font-weight: 500;
  border-radius: 10px;
  transition: 0.5s;
}
#listmenu button:focus {
  outline: none;
}
#listmenu button:hover {
  background-color: #ffffff2c;
  transition: 0.5s;
}
#listmenu button svg {
  font-size: 25pt;
  color: #ffffff;
  margin-right: 15px;
}
.hover_btnlogin {
  display: none;
  margin-right: 10px !important;
  background-color: #ffffff;
  position: absolute;
  top: 100%;
  max-width: 200px;
  width: 120%;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  border-radius: 0 0 10px 10px;
  right: -20px;
}
.hover_btnlogin::before {
  content: "";
  width: 0px;
  position: absolute;
  top: -8%;
  left: 50%;
  height: 0px;
  top: 1;
  border-left: 15px solid transparent;
  border-right: 15px solid transparent;
  border-bottom: 10px solid #ffffff;
}
.hover_btnlogin ul li a {
  font-size: 14px;
}
@media screen and (min-width: 992px) {
  #header-search-wrapper {
    width: 50%;
    max-width: 33.75rem;
  }
  .header_navbar > div {
    flex-wrap: nowrap !important;
  }
  .navbar-collapse {
    display: flex !important;
    margin-left: 2rem;
  }
}
</style>
