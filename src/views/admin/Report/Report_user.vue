<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
      <a-breadcrumb-item>Thống kê</a-breadcrumb-item>
    </a-breadcrumb>
    <div :style="{ padding: '24px', background: '#fff', minHeight: '460px' }">
      <div class="card mb-2">
        <div
          class="card-header d-flex align-items-center justify-content-between"
        >
          <div>
            <i class="fas fa-table mr-1"></i>
            Thống kê sinh viên
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
                  <th scope="col" style="white-space: nowrap">Họ tên</th>
                  <th scope="col">Giới tính</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Khoa</th>
                  <th scope="col">Số ĐT</th>
                  <th scope="col">Email</th>
                  <th scope="col">Số lượng đăng ký</th>
                  <th scope="col">Số lượng tham gia</th>
                  <th scope="col">Hoạt động</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(item,index) in reports_user" :key="index">
                      <td>{{index+1}}</td>
                      <td>{{item.NameSV}}</td>
                      <td>{{item.GenderSV}}</td>
                      <td>{{item.ClassSV}}</td>
                      <td>{{item.FacultySV}}</td>
                      <td>{{item.Phone}}</td>
                      <td>{{item.EmailSV}}</td>
                      <td>{{item.Quantity_register}}</td>
                      <td>{{item.Quantity_join}}</td>
                      <td v-if="item.Active==0">
                        <a-switch :default-checked="true" @change="onChange(item.Active,item.Id)">
                            <a-icon slot="checkedChildren" type="check" />
                            <a-icon slot="unCheckedChildren" type="close" />
                        </a-switch>
                      </td>
                      <td v-else>
                          <a-switch :default-checked="false" @change="onChange(item.Active,item.Id)">
                            <a-icon slot="checkedChildren" type="check" />
                            <a-icon slot="unCheckedChildren" type="close" />
                        </a-switch>
                      </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import $ from "jquery";
import axios from 'axios'
export default {
    data(){
        return {
          
        }
    },
    computed:{
        ...mapGetters(['reports_user'])
    },
    methods:{
        ...mapActions(['getReport_User']),
        dataTable() {
      setTimeout(() => {
        this.$nextTick(() => {
        $("#myTable").DataTable({
          "lengthMenu": [ 10, 20, 50, 100 ],
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
    onChange(status,id) {
      axios.patch('Report/report_user.php?id='+id, 
        { 
            "status":status==1 ? 0 : 1
        }, 
        )
        .then(res => {
        if (!res.data.error) {
            this.getReport_User()
        }
        })
        .catch(err => {
        console.log("Erorr", err);
        });
    },
    },
    mounted(){
        this.getReport_User()
    },
    created(){
        this.dataTable()
    }
};
</script>

<style>
</style>