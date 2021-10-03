<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
      <a-breadcrumb-item>Sự kiện</a-breadcrumb-item>
    </a-breadcrumb>
    <div :style="{ padding: '24px', background: '#fff', minHeight: '460px' }">
      <div class="card mb-2">
        <div
          class="card-header d-flex align-items-center justify-content-between"
        >
          <div>
            <i class="fas fa-table mr-1"></i>
            Quản lí sự kiện
          </div>
         
          <button class="btn btn-primary" @click="add">Thêm mới</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table
              class="table table-bordered"
              id="myTable"
              width="100%"
              cellspacing="0"
            >
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col" style="white-space:nowrap">Tên sự kiện</th>
                  <th scope="col">Hình ảnh</th>
                  <th scope="col">Nội dung</th>
                  <th scope="col">Số lượng</th>
                  <th scope="col">Địa điểm</th>
                  <th scope="col">Thời gian BĐ</th>
                  <th scope="col">Thời gian kết thúc</th>
                  <th scope="col">Thể loại</th>
                  <th scope="col">Người tổ chức</th>
                  <th scope="col">Tình trạng</th>
                  <th scope="col">Chú ý</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in events" :key="index">
                  <th>{{ index+1 }}</th>
                  <td>{{ item.NameSK }}</td>
                  <td><img :src="item.Image" alt="ảnh"/></td>
                  <td>Ấn chi tiết...</td>
                  <td>{{ item.Quantity }}</td>
                  <td>{{ item.Place }}</td>
                  <td>{{ item.TimeStart }}</td>
                  <td>{{ item.TimeEnd }}</td>
                  <td>{{ item.NameLSK }}</td>
                  <td>{{ item.NameGV }}</td>
                  <td v-if="item.Status==2">Đã tổ chức</td>
                  <td v-else>Đang chuẩn bị</td>
                  <td>{{ item.Note }}</td>
                  <td>
                    <button class="btn btn-primary mr-3 btn-sm mb-1" @click="detail(item.IdSK)" style="white-space:nowrap">Chi tiết</button>
                    <button class="btn btn-primary mr-3 btn-sm mb-1"  style="white-space:nowrap" @click="attendance(item.IdSK,item.NameSK)">Điểm danh</button>
                    <button class="btn btn-info mr-3 btn-sm mb-1" @click="edit(item.IdSK)">Sửa</button>
                    <a-popconfirm placement="topRight" ok-text="Đồng ý" cancel-text="Không" @confirm="destroy(item.IdSK)" title="Bạn có chắc chắn xóa dữ liệu này?">
                      <a-button type="danger">Xóa</a-button>
                    </a-popconfirm>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <a-modal
      title="Thêm mới sự kiện"
      :visible="visibleAdd"
      :confirm-loading="confirmLoading"
      :centered="true"
      cancelText="Bỏ qua"
      @ok="store"
      @cancel="handleCancelAdd"
    >
      <CreateEvent ref="createEvent"/>
    </a-modal>
    <a-modal
      title="Chỉnh sửa sự kiện"
      :visible="visibleEdit"
      :confirm-loading="confirmLoading"
      :centered="true"
      cancelText="Bỏ qua"
      @ok="update"
      @cancel="handleCancelEdit"
    >
      <EditEvent ref="editEvent" :idEvt="idEvt" :Evt="eventID" />
    </a-modal>
     <a-modal v-model="visibleShow" title="Thông tin sự kiện" :footer="null"  :centered="true">
      <ShowEvent ref="showEvent"  :Evt="eventID"/>
    </a-modal>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import $ from "jquery";
import CreateEvent from '@/views/admin/Event/CreateEvent.vue'
import EditEvent from '@/views/admin/Event/EditEvent.vue'
import ShowEvent from '@/views/admin/Event/ShowEvent.vue'
export default {
    components:{
        CreateEvent,EditEvent,ShowEvent
    },
  data() {
    return {
      visibleAdd: false,
      visibleEdit:false,
      visibleShow:false,
      confirmLoading: false,
      idEvt:0,
    };
  },
  mounted() {
    this.getEvent();
  },
  created() {
    this.dataTable();
  },
  computed: {
    ...mapGetters(["events","eventID"]),
  },
  methods: {
    ...mapActions(["getEvent","deleteEvent","getEventID","setEventLast"]),
    ...mapMutations(["SET_NAMEEVENT"]),
    dataTable() {
      setTimeout(() => {
        this.$nextTick(() => {
        $("#myTable").DataTable({
          "lengthMenu": [ 5, 10, 20, 50, 100 ],
          language: {
            sLengthMenu: "Hiển thị _MENU_ dòng trên 1 trang",
            sZeroRecords: "Không tìm thấy dữ liệu",
            info: "Hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            sInfoEmpty: "Không có dữ liệu nào",
            sInfoFiltered: "(được lọc từ  _MAX_ dòng dữ liệu)",
            sSearch: "Tìm kiếm:",
            oPaginate: {
              sNext: "Sau",
              sPrevious: "Trước",
            },
          },
        });
      });
      }, 300);
    },
    add() {
      this.visibleAdd = true;
    },
    edit(id) {
      this.idEvt=Number(id)
      this.getEventID(id)
      this.visibleEdit = true;
    },
    detail(id){
      this.getEventID(id)
      this.visibleShow = true;
    },
    attendance(id,name){
      this.SET_NAMEEVENT(name)
      this.$router.push("/admin/event/attendance/" + id);
    },
    store() {
      let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
      this.$refs.createEvent
        .submit()
        .then((data) => {
          this.confirmLoading = true;
          this.getEvent();
          setTimeout(() => {
                this.visibleAdd = false;
                this.confirmLoading = false
                if(user['Id']==1)
                  this.$message.success(data.message);
                else
                  this.$message.success("Dữ liệu đang được chờ duyệt !!");
            }, 300);
        })
        .catch((data) => {
           this.$message.error(data.message);
        });
    },
    handleCancelAdd() {
      this.visibleAdd = false;
    },
    update(){
      this.confirmLoading = true;
      this.$refs.editEvent
        .submit()
        .then((data) => {
          setTimeout(() => {
                this.visibleEdit = false;
                this.confirmLoading = false
                this.$message.success(data.message);
                this.getEvent();
            }, 200);
        })
        .catch((data) => {
           this.$message.error(data.message);
        });
    },
    handleCancelEdit() {
      this.visibleEdit = false; 
    },
    destroy(id) {
      this.deleteEvent(id)
      this.$message.success('Xóa thành công !!');
    },
  },
};
</script>

<style scoped>
th,td {
  font-size: 14px;
}
img {
  max-width: 100px;
}
</style>