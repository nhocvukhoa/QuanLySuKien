<template>
  <div>
    <a-breadcrumb style="margin: 16px 0">
      <a-breadcrumb-item>Trang chủ</a-breadcrumb-item>
      <a-breadcrumb-item>Thể loại sự kiện</a-breadcrumb-item>
    </a-breadcrumb>
    <div :style="{ padding: '24px', background: '#fff', minHeight: '460px' }">
      <div class="card mb-2">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <i class="fas fa-table mr-1"></i>
            Quản lí thể loại sự kiện
          </div>
          <button class="btn btn-primary" @click="add">Thêm mới</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">Mã loại sự kiện</th>
                  <th scope="col">Tên loại sự kiện</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in categorys" :key="index">
                  <th>{{ index+1 }}</th>
                  <td>{{ item.NameLoaiSK }}</td>
                  <td>
                    <button class="btn btn-info mr-3 btn-sm" @click="edit(item.IdLoaiSK)">Sửa</button>
                    <a-popconfirm placement="topRight" ok-text="Đồng ý" cancel-text="Không" @confirm="destroy(item.IdLoaiSK)" title="Bạn có chắc chắn xóa dữ liệu này?">
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
      title="Thêm mới thể loại sự kiện"
      :visible="visibleAdd"
      :confirm-loading="confirmLoading"
      cancelText="Bỏ qua"
      @ok="store"
      @cancel="handleCancelAdd"
    >
      <CreateCategory ref="createCategory"/>
    </a-modal>
    <a-modal
      title="Chỉnh sửa thể loại sự kiện"
      :visible="visibleEdit"
      :confirm-loading="confirmLoading"
      cancelText="Bỏ qua"
      @ok="update"
      @cancel="handleCancelEdit"
    >
      <EditCategory ref="editCategory" :idCat="idCat" :Cat="categoryID"/>
    </a-modal>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import $ from "jquery";
import CreateCategory from '@/views/admin/Category/CreateCategory.vue'
import EditCategory from '@/views/admin/Category/EditCategory.vue'
export default {
    components:{
        CreateCategory,EditCategory
    },
  data() {
    return {
      visibleAdd: false,
      visibleEdit:false,
      confirmLoading: false,
      idCat:0,
    };
  },
  mounted() {
    this.getCategory();
  },
  created() {
    this.dataTable();
  },
  computed: {
    ...mapGetters(["categorys","categoryID"]),
  },
  methods: {
    ...mapActions(["getCategory","deleteCategory","getCategoryID","setCategoryLast"]),
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
      this.idCat=Number(id)
      this.getCategoryID(id)
      this.visibleEdit = true;
    },
    store() {
      this.$refs.createCategory
        .submit()
        .then((data) => {
          this.confirmLoading = true;
          setTimeout(() => {
                this.getCategory();
                this.visibleAdd = false;
                this.confirmLoading = false
                this.$message.success(data.message);
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
      this.$refs.editCategory
        .submit()
        .then((data) => {
          setTimeout(() => {
                this.visibleEdit = false;
                this.confirmLoading = false
                this.$message.success(data.message);
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
      this.deleteCategory(id)
      this.$message.success('Xóa thành công !!');
    },
  },
};
</script>

<style>
</style>