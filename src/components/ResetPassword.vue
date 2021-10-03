<template>
  <div>
    <a-alert :message="message" :type="error" v-show="showAlert"  show-icon class="mb-3" />
    <a-input ref="passWordInput" v-model="password_old" placeholder="Nhập mật khẩu cũ..." class="my-2" type="password">
      <a-icon slot="prefix" type="lock" />
    </a-input>
    <a-input ref="passWordInput" v-model="password_new" placeholder="Nhập mật khẩu mới..." class="my-2" type="password">
      <a-icon slot="prefix" type="lock" />
    </a-input>
    <a-input ref="passWordInput" v-model="password_checknew" placeholder="Xác nhận mật khẩu mới..." class="my-2" type="password">
     <a-icon slot="prefix" type="lock" />
    </a-input>
  <div class="text-center pt-2">
    <a-button type="primary"  @click="resetPassword()">
      Đổi mật khẩu
    </a-button>
  </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapMutations } from 'vuex'
export default {
    props: {
    idUser: {
      type: Number,
      required: true,
    },
    },
    data(){
        return {
            password_old:'',
            password_new:'',
            password_checknew:'',
            showAlert:false,
            message:"",
            error:"error"
        }
    },
    computed:{
      
    },
    methods:{
        ...mapMutations(['']),
        resetPassword(){
            if(this.password_old=="" || this.password_new=="" || this.password_checknew==""){
                this.showAlert=true
                this.message="Dữ liệu trống !!"
                this.error="error"
            }
            else if(this.password_old==this.password_new) {
                 this.showAlert=true
                this.message="Mật khẩu cũ và mới phải khác nhau !!"
                 this.error="error"
            }
            else if(this.password_new!=this.password_checknew){
                this.showAlert=true
                this.message="Mật khẩu xác nhận chưa khớp!!"
                 this.error="error"
            }
            else {
                axios.patch('User/user.php?id='+this.idUser, 
                    { 
                        "pass_old":this.password_old,
                        "pass_new":this.password_new
                    }, 
                )
                .then(res => {
                    if (!res.data.error) {
                        this.showAlert=true
                        this.message="Đổi mật khẩu thành công !!"
                        this.error="success"
                        this.password_new=""
                        this.password_old=""
                        this.password_checknew=""
                    }else {
                        this.showAlert=true
                        this.message="Mật khẩu cũ không đúng !!"
                        this.error="error"
                    }
                })
                .catch(err => {
                    console.log("Erorr", err);
                });
            }
        }
    }
}
</script>

<style>

</style>