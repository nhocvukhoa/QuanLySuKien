<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
      <a-breadcrumb-item>Thống kê sự kiện</a-breadcrumb-item>
    </a-breadcrumb>
    <div :style="{ padding: '24px', background: '#fff', minHeight: '460px' }">
      <div class="card mb-2">
        <div
          class="card-header d-flex align-items-center justify-content-between"
        >
          <div>
            <i class="fas fa-table mr-1"></i>
            Thống kê sự kiện
          </div>
          <div class="filter d-flex align-items-center">
            <div class="filter_item d-flex align-items-center mr-3">
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
                  <th scope="col" style="white-space: nowrap">Tên sự kiện</th>
                  <th scope="col">Thời gian BĐ</th>
                  <th scope="col">Thời gian kết thúc</th>
                  <th scope="col">Thể loại</th>
                  <th scope="col">Người tổ chức</th>
                  <th scope="col">Tình trạng</th>
                  <th scope="col">Số lượng dự kiến</th>
                  <th scope="col">Số lượng đăng ký</th>
                  <th scope="col">Số lượng tham gia</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(item,index) in reports" :key="index">
                      <td>{{index+1}}</td>
                      <td>{{item.NameSK}}</td>
                      <td>{{item.TimeStart}}</td>
                      <td>{{item.TimeEnd}}</td>
                      <td>{{item.NameLSK}}</td>
                      <td>{{item.NameGV}}</td>
                      <td>{{item.Status==0?'Chưa được duyệt':(item.Status==1?'Đang tổ chức':'Đã tổ chức')}}</td>
                      <td>{{item.Quantity}}</td>
                      <td>{{item.Quantity_register}}</td>
                      <td>{{item.Quantity_join}}</td>
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
import { mapActions, mapGetters, mapMutations } from 'vuex';
import $ from "jquery";
export default {
    data(){
        return {
            filter_cat:'0',
            filter_status:'-1',
        }
    },
    computed:{
        ...mapGetters(['reports','categorys'])
    },
    methods:{
        ...mapActions(['getReport','getCategory']),
        ...mapMutations(['SET_FILTER_REPORT']),
        handleChange(){
            this.SET_FILTER_REPORT({IdLSK:this.filter_cat,
            Status:this.filter_status})
        },
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
    },
    mounted(){
        this.getReport(),
        this.getCategory()
    },
    created(){
      this.dataTable()
    }
};
</script>

<style>
</style>