<template>
  <div class="bg-primary">
    <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Đăng nhập</h3></div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Tài khoản</label>
                                                <input class="form-control py-4" id="inputEmailAddress" type="text" placeholder="Nhập tài khoản..." v-model="Admin.username"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Mật khẩu</label>
                                                <input class="form-control py-4" id="inputPassword" type="password" placeholder="Nhập mật khẩu..." v-model="Admin.password"/>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Nhớ mật khẩu</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Quên mật khẩu?</a>
                                                <button class="btn btn-primary" @click.prevent="onLogin()">
                                                    Đăng nhập
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
  </div>
</template>

<script>
const key = 'updatable';
import axios from "axios";
import { mapMutations } from 'vuex';
export default {
  name: "Login",
  data() {
    return {
      Admin: {
        username: null,
        password: null,
      },
    };
  },
  methods: {
    ...mapMutations(['SET_LOGIN_ADMIN']),
    onLogin() {
      var data = new FormData();
      data.append("username", this.Admin.username);
      data.append("password", this.Admin.password);
      axios
        .post("apiGetActions/Login.php?action=loginAdmin",
         data
        )
        .then(res => {
          if (!res.data.error) {
             this.$message.loading({ content: 'Đang kiểm tra...', key });
              setTimeout(() => {
                this.$message.success({ content: res.data.message, key, duration: 1 });
              }, 1000);
            sessionStorage.setItem('tokenloginAdmin',JSON.stringify(res.data.data))
            setTimeout(() => {
              this.$router.push("/admin/home");
            }, 2500);
           
          } else {
             this.$message.loading({ content: 'Đang kiểm tra...', key });
              setTimeout(() => {
                this.$message.error({ content: res.data.message, key, duration: 3 });
              }, 1000);
          }
        })
        .catch(err => {
          console.log("Erorr", err);
        });
    },
  },
};
</script>

<style scoped>
.bg-primary {
  background-color: #007bff !important;
}

#layoutAuthentication {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
#layoutAuthentication #layoutAuthentication_content {
  min-width: 0;
  flex-grow: 1;
}
#layoutAuthentication #layoutAuthentication_footer {
  min-width: 0;
}
</style>