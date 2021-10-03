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
            Danh sách sinh viên đăng ký tham gia sự kiện {{name_event}}
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
                  <th scope="col" style="white-space:nowrap">Sinh viên</th>
                  <th scope="col">Giới tính</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Khoa</th>
                  <th scope="col">Email</th>
                  <th scope="col">Thời gian DK</th>
                  <th scope="col">Tình trạng</th>
                  <th scope="col">Chú ý</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in dsdk" :key="index">
                  <th>{{ index+1 }}</th>
                  <td>{{ item.NameSV }}</td>
                  <td>{{ item.GenderSV }}</td>
                  <td>{{ item.ClassSV }}</td>
                  <td>{{ item.FacultySV }}</td>
                  <td>{{ item.EmailSV }}</td>
                  <td>{{ item.TimeDK }}</td>
                  <td v-if="item.Status==0"><a-checkbox @change="changeStatus(item.IdDS,item.Status)" :checked="false" /></td>
                  <td v-else><a-checkbox @change="changeStatus(item.IdDS,item.Status)" :checked="true" /></td>
                  <td>{{ item.Note }}</td>
                  <td>
                    <a-popconfirm placement="topRight" ok-text="Đồng ý" cancel-text="Không" @confirm="destroy(item.IdDS)" title="Bạn có chắc chắn xóa dữ liệu này?">
                      <a-button type="danger">Xóa</a-button>
                    </a-popconfirm>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <a-modal
            title="Thêm mới sinh viên trong danhh sách"
            :visible="visibleAdd"
            :confirm-loading="confirmLoading"
            :centered="true"
            @ok="store"
            cancelText="Bỏ qua"
            @cancel="handleCancelAdd"
          >
            <CreateListAttr ref="createListAttr"/>
          </a-modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import $ from "jquery";
import CreateListAttr from '@/views/admin/Event/CreateListAttr.vue'
import {  mapActions, mapGetters} from "vuex";
export default {
    components:{
       CreateListAttr
    },
    data(){
        return {
          visibleAdd: false,
          confirmLoading: false,
        }
    },
    mounted() {
    
    },
    created() {
        this.getDSDK(this.$route.params.id);
        this.dataTable();
    },
    computed:{
        ...mapGetters(["name_event","dsdk"]),
    },
    methods:{
        ...mapActions(["getDSDK","deleteDSDK"]),
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
        destroy(id) {
            this.deleteDSDK(id)
            this.$message.success('Xóa thành công !!');
        },
        changeStatus(id,status){
            axios.patch('http://localhost/dapm1/src/Api/Event/attendance.php?id='+id, 
            { 
                "status":status==1 ? 0 : 1
            }, 
          )
          .then(res => {
            if (!res.data.error) {
              this.getDSDK(1);
            }
          })
          .catch(err => {
            console.log("Erorr", err);
          });
        },
        add() {
          this.visibleAdd = true;
        },
        store() {
          this.confirmLoading = true;
          this.$refs.createListAttr
            .submit()
            .then((data) => {
              setTimeout(() => {
                    this.visibleAdd = false;
                    this.confirmLoading = false
                    this.$message.success(data.message);
                    this.getDSDK(this.$route.params.id);
                }, 300);
            })
            .catch((data) => {
              this.$message.error(data.message);
            });
        },
        handleCancelAdd() {
          this.visibleAdd = false;
        },
    }
}
</script>

<style>

</style>