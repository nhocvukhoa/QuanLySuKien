<template>
  <div>
    <a-alert :message="message" type="error" v-show="showAlert"  show-icon class="mb-3" />
    <a-input ref="userNameInput"  v-model="username" placeholder="Nhập tài khoản..." class="mt-0 mb-2">
      <a-icon slot="prefix" type="user" />
    </a-input>
    <a-input ref="passWordInput" v-model="password" placeholder="Nhập mật khẩu..." class="my-2" type="password">
      <a-icon slot="prefix" type="lock" />
    </a-input>
  <div class="text-center pt-2">
    <a-button type="primary"  @click="login">
      Đăng nhập
    </a-button>
  </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapMutations } from 'vuex'
export default {
    data(){
        return {
            username:'',
            password:'',
            showAlert:false,
            message:""
        }
    },
    computed:{
      
    },
    methods:{
        ...mapMutations(['SET_LOGIN_USER']),
        login() {
            if(this.username==""||this.password==""){
                this.showAlert=true
                this.message="Không được đế trống thông tin!"
            }
            else {
                axios.post("apiGetActions/Login.php?action=loginUser", 
                { 
                    "username":this.username,
                    "password":this.password
                }, 
                )
                .then(res => {
                    if (!res.data.error) {
                        sessionStorage.setItem('tokenloginUser',JSON.stringify(res.data.data))
                        this.SET_LOGIN_USER(true)
                        this.$router.push("/");
                        window.location.reload();
                    }
                    else {
                        this.showAlert=true
                        this.message="Tài khoản hoặc mật khẩu sai !!"
                    }
                })
                .catch(err => {
                    console.log("Erorr", err);
                });
            }
        },
    }
}
</script>

<style>

</style>