<template>
  <main class="pb-5 main-wrapper" id="main-active-on">
    <a-spin :spinning="isSpinner" tip="Đang tải..." size="large">
      <div class="container-fluid">
        <div class="row">
          <div class="pt-4 border col-lg-9 col-md-12 border-info">
            <div class="wrapper-active-use">
              <div class="list-active">
                <div class="title-list">
                  <h4>DANH SÁCH HOẠT ĐỘNG ĐÃ ĐĂNG KÝ</h4>
                </div>
                <div v-if="listEventRegisterUser.length == 0">
                  <b-alert variant="success" show
                    >Bạn chưa đăng ký tham gia hoạt động nào cả !!</b-alert
                  >
                </div>
                <div v-else>
                  <div class="list-active table-responsive">
                    <table class="table table-bordered" style="min-width: 600px">
                      <thead>
                        <tr style="text-align: center">
                          <th scope="col">#</th>
                          <th scope="col">Sự kiện</th>
                          <th scope="col">Thể loại</th>
                          <th scope="col">Người duyệt</th>
                          <th scope="col">Thời gian đăng ký</th>
                          <th scope="col">Trạng thái</th>
                          <th scope="col">Rút đăng ký</th>
                          <th scope="col">Ghi chú</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in listEventRegisterUser" :key="index">
                          <th scope="row">{{ index + 1 }}</th>
                          <td>{{ item.NameSK }}</td>
                          <td>{{ item.NameLSK }}</td>
                          <td>{{ item.NameGV }}</td>
                          <td>{{ item.TimeResgister }}</td>
                          <td style="text-align: center; color: green">
                            <button class="icon_table" v-if="item.Status_DS == 1">
                              <font-awesome-icon icon="check-circle" />
                            </button>
                            <button class="icon_table" v-else>
                              <font-awesome-icon icon="question-circle" />
                            </button>
                          </td>
                          <td style="text-align: center; color: red">
                            <a-popconfirm placement="topRight" ok-text="Đồng ý" cancel-text="Không" @confirm="CancelRegisterEvt(item.IdDS)" title="Bạn có chắc chắn hủy tham gia sự kiện này?">
                              <button
                                class="icon_table close_dk"
                                v-if="item.Status_DS == 0"
                              >
                                <font-awesome-icon icon="times-circle" />
                              </button>
                            </a-popconfirm>
                          </td>
                          <td>
                              {{item.Note_DS}}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 d-none d-lg-block">
            <div class="p-3 mb-3 bg-white rounded frame_listgroup">
              <div class="title">
                <span>THỂ LOẠI SỰ KIỆN</span>
              </div>
              <hr />
              <ul class="pl-0 m-0">
                <li v-for="item in categorys" :key="item.IdLoaiSK">
                  <a class="py-2 d-flex align-items-center" href="#">
                    <div class="flex-shrink-0 mr-2 icon-group">
                      <img
                        alt=""
                        src="@/assets/logo.png"
                        class="intrinsic-item img-fluid undefined"
                      />
                    </div>
                    <p class="mb-0 name_group">{{ item.NameLoaiSK }}</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </a-spin>
  </main>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      isLogin: false,
      idUser: "",
      isSpinner: false,
    };
  },
  computed: {
    ...mapGetters(["listEventRegisterUser", "categorys"]),
  },
  methods: {
    ...mapActions(["getListEventRegisterUser", "getCategory"]),
    CancelRegisterEvt(idDS) {
        this.isSpinner = true;
      axios.delete("Event/attendance.php?id=" + idDS)
        .then(res => {
          if (!res.data.error) {
             this.getListEventRegisterUser(JSON.parse(sessionStorage.getItem("tokenloginUser"))['Id'])
             setTimeout(() => {
            this.isSpinner = false;
            this.$notification.open({
            message: "Thông báo",
            description: "Hủy đăng ký sự kiện thành công",
            icon: <a-icon type="sound" style="color:green" />,
            });
        }, 1000);
          }
        })
        .catch(err => {
            console.log("Erorr", err);
        });
    },
  },
  mounted(){
      this.getCategory()
  },
  created() {
    this.getListEventRegisterUser(JSON.parse(sessionStorage.getItem("tokenloginUser"))['Id'])
  },
};
</script>

<style scoped>
.wrapper-active-use .list-active .list-active th {
  vertical-align: middle;
}
.title-list h4 {
  color: blue;
  font-weight: 600;
}
.icon_table {
  font-size: 14pt;
  background: transparent;
  border: none;
}
.close_dk {
  cursor: pointer;
  transition: 0.6s;
}
.close_dk:hover {
  transition: 0.6s;
  opacity: 0.8;
  transform: scale(1.2);
}
</style>
