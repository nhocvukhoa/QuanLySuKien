<template>
    <a-layout-sider v-model="collapsed" collapsible >
      <div class="logo">
        <span  v-if="power==1">ADMIN</span>
        <span v-else>GIÁO VIÊN </span>
      </div>
      <a-menu theme="dark" :default-selected-keys="['1']" mode="inline" v-if="power==1">
        <a-menu-item key="1">
          <a-icon type="home" />
          <span><router-link to="/admin/home">Trang chủ</router-link></span>
        </a-menu-item>
        <a-menu-item key="2">
          <a-icon type="database" />
          <span><router-link to="/admin/category">Quản lý loại sự kiện</router-link></span>
        </a-menu-item>
        <a-sub-menu key="sub1">
          <span slot="title"><a-icon type="code-sandbox" /><span>Sự kiện</span></span>
          <a-menu-item key="3">
             <span><router-link to="/admin/checkevent">Duyệt sự kiện</router-link></span>
          </a-menu-item>
          <a-menu-item key="4">
             <span><router-link to="/admin/event">Quản lý sự kiện</router-link></span>
          </a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub2">
          <span slot="title"><a-icon type="line-chart" /><span>Thống kê</span></span>
          <a-menu-item key="5">
             <span><router-link to="/admin/report/event">Thống kê sự kiện</router-link></span>
          </a-menu-item>
          <a-menu-item key="6">
             <span><router-link to="/admin/report/user">Thống kê sinh viên</router-link></span>
          </a-menu-item>
        </a-sub-menu>
      </a-menu>
      <a-menu theme="dark" :default-selected-keys="['1']" mode="inline" v-else>
        <a-menu-item key="1">
          <a-icon type="home" />
          <span><router-link to="/admin/home">Trang chủ</router-link></span>
        </a-menu-item>
        <a-menu-item key="3">
          <a-icon type="code-sandbox" />
          <span><router-link to="/admin/event">Quản lý sự kiện</router-link></span>
        </a-menu-item>
      </a-menu>
    </a-layout-sider>
</template>
<script>
export default {
  data() {
    return {
      collapsed: false,
      power:1
    };
  },
  mounted(){
    this.checkPower()
  },
  methods:{
    checkPower(){
      let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
      this.power=user['Power']
    }
  }
};
</script>

<style scoped>
.logo {
  text-align: center;
  height: auto !important;
  margin: 16px 0 !important;
  background: transparent !important;
}
.logo span {
  font-weight: bold;
  color: #fff;
  font-size: 14pt;
  margin-top: 5px;
}
a{
  color: #fff;
}
</style>