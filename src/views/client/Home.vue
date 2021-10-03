<template>
  <main class="pb-5 main-wrapper">
        <div class="filter d-flex align-items-center justify-content-around">
            <div class="filter_item d-flex align-items-center mr-3 ">
                <span class="mr-2">Thể loại:</span>
                <a-select
                :default-value="filter_cat"
                style="width: 180px"
                @change="handleChange"
                v-model="filter_cat"
                >
                <a-select-option  value="0">Tất cả</a-select-option>
                <a-select-option v-for="item in categorys" :key="item.IdLoaiSK" :value="item.IdLoaiSK"> {{item.NameLoaiSK}}</a-select-option>
                </a-select>
            </div>
            <div class="filter_item d-flex align-items-center">
                <span class="mr-2">Tình trạng:</span>
                <a-select
                :default-value="filter_status"
                style="width: 150px"
                @change="handleChange"
                v-model="filter_status"
                >
                <a-select-option value="-1"> Tất cả </a-select-option>
                <a-select-option value="0"> Chưa duyệt </a-select-option>
                <a-select-option value="1"> Đang tổ chức </a-select-option>
                <a-select-option value="2"> Đã tổ chức </a-select-option>
                </a-select>
            </div>
          </div>
      <div style="padding: 20px;">
        <div class="row">
          <div class="col-lg-3 mt-2" v-for="(event,index) in eventsUser" :key="index">
            <a-card hoverable class="item_card">
            <img
            slot="cover"
            alt="example"
            :src="event.Image"
            />
            <template slot="actions" class="ant-card-actions" v-if="isLoginUser">
            <span v-if="event.Status_DS==null" class="d-flex align-items-center justify-content-center" @click="Register(event.IdSK)">
              <a-icon type="file-add" class="mr-1" />
                Đăng Ký
            </span>
            <a-popconfirm v-if="event.Status_DS==0" placement="topRight" ok-text="Đồng ý" cancel-text="Không" @confirm="CancelRegisterEvt(event.IdDS)" title="Bạn có chắc chắn hủy tham gia sự kiện này?">
               <span class="d-flex align-items-center justify-content-center">
              <a-icon type="close-square" class="mr-1"/>
                Hủy đăng ký
            </span>
            </a-popconfirm>
            <span class="d-flex align-items-center justify-content-center" @click="Detail(event.IdSK)">
              <a-icon type="profile" class="mr-1" />
                Chi tiết
            </span>
            </template>
            <template v-else slot="actions" class="ant-card-actions">
            <span class="d-flex align-items-center justify-content-center" @click="Detail(event.IdSK)">
              <a-icon type="profile" class="mr-1" />
                Chi tiết
            </span>
            </template>
            <a-card-meta :title="event.NameSK" :description="event.Note">
            </a-card-meta>
        </a-card>
          </div>
        </div>
  </div>
  </main>
</template>

<script>
import { mapActions, mapGetters, mapMutations} from "vuex";
import axios from 'axios'
export default {
  data(){
    return {
      filter_cat:'0',
      filter_status:'-1',
    }
  },
  mounted() {
    this.getDataEvent();
    this.getCategory()
  },
  created(){
    
  },
  computed:{
     ...mapGetters(["eventsUser","isLoginUser","categorys"]),
  },
  methods:{
    ...mapActions(["getEventUser","getCategory"]),
    ...mapMutations(["SET_FILTER_EVENTS_USER"]),
    getDataEvent(){
      let user=JSON.parse(sessionStorage.getItem("tokenloginUser"));
      if(user==null) {
        this.getEventUser(0)
      }
      else {
        this.getEventUser(user['Id'])
      }
    },
    Detail(id){
      this.$router.push("/event/"+id);
    },
    Register(id){
      let user = JSON.parse(sessionStorage.getItem("tokenloginUser"));
      if(user['Active']==1){
        this.$notification.open({
          message: "Thông báo",
          description: "Bạn đã bị vô hiệu hóa !!",
          icon: <a-icon type="sound" style="color:red" />,
          });
      }
      else {
           axios.post("/Event/attendance.php", 
      { 
          "idSV":user['Id'],
          "idSK":id,
          "status":0,
          "note":''
      }, 
      )
      .then(res => {
          if (!res.data.error) {
             this.getEventUser(user['Id'])
            setTimeout(() => {
              this.$notification.open({
              message: "Thông báo",
              description: "Đăng ký sự kiện thành công",
              icon: <a-icon type="sound" style="color:green" />,
              });
          }, 300);
          }
      })
      .catch(err => {
          console.log("Erorr", err);
      });
      }
    },
    CancelRegisterEvt(idDS) {
      let user = JSON.parse(sessionStorage.getItem("tokenloginUser"));
      axios.delete("Event/attendance.php?id=" + idDS)
        .then(res => {
          if (!res.data.error) {
              this.getEventUser(user['Id'])
             setTimeout(() => {
            this.$notification.open({
            message: "Thông báo",
            description: "Hủy đăng ký sự kiện thành công",
            icon: <a-icon type="sound" style="color:green" />,
            });
        }, 300);
          }
        })
        .catch(err => {
            console.log("Erorr", err);
        });
    },
    handleChange(){
      this.SET_FILTER_EVENTS_USER({IdLSK:this.filter_cat,
      Status:this.filter_status})
    }
  }
}
</script>

<style scoped>
.item_card {
  width: 100%;
}
.item_card img {
  width: 100%;
}
</style>