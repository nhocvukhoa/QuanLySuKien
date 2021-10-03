<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
      <a-breadcrumb-item>Duyệt sự kiện</a-breadcrumb-item>
    </a-breadcrumb>
    <div :style="{ padding: '24px', background: '#fff', minHeight: '460px' }">
      <div class="card mb-2">
        <div
          class="card-header d-flex align-items-center justify-content-between"
        >
          <div>
            <i class="fas fa-table mr-1"></i>
            Duyệt sự kiện
          </div>
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
                <tr v-for="(item, index) in events_not" :key="index">
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
                    <td><a-checkbox @change="changeStatus(item.IdSK)" :checked="false" /></td>
                  <td>{{ item.Note }}</td>
                  <td>
                    <button class="btn btn-primary mr-3 btn-sm mb-1" @click="detail(item.IdSK)" style="white-space:nowrap">Chi tiết</button>
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
     <a-modal v-model="visibleShow" title="Thông tin sự kiện" :footer="null"  :centered="true">
      <ShowEvent ref="showEvent"  :Evt="eventID"/>
    </a-modal>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import $ from "jquery";
import ShowEvent from '@/views/admin/Event/ShowEvent.vue'
import axios from 'axios'
export default {
    components:{
       ShowEvent
    },
  data() {
    return {
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
    ...mapGetters(["events_not","eventID"]),
  },
  methods: {
    ...mapActions(["getEvent","deleteEvent","getEventID"]),
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
    detail(id){
      this.getEventID(id)
      this.visibleShow = true;
    },
    destroy(id) {
      this.deleteEvent(id)
      this.$message.success('Xóa thành công !!');
    },
    changeStatus(id){
        axios.put('Event/event.php?id='+id, 
            { 
                "status":1
            }, 
          )
          .then(res => {
            if (!res.data.error) {
            this.getEvent();
            setTimeout(() => {
                this.$message.success("Duyệt thành công !!");
            }, 200);
            }
          })
          .catch(err => {
            console.log("Erorr", err);
          });
    }
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