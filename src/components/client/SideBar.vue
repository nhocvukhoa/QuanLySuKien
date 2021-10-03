<template>
  <div class="main-sidebar">
    <ul class="p-0 m-0 d-flex align-items-center flex-lg-column justify-content-between">
      <li>
        <router-link to="/"><font-awesome-icon icon="home" /></router-link>
        <span class="note_sidebar">Trang chủ</span>
      </li>
      <li>
        <router-link to="/user"><font-awesome-icon icon="user" /></router-link>
        <span class="note_sidebar">Trang cá nhân</span>
      </li>
      <li>
        <router-link to="/listregisterevent"><font-awesome-icon icon="list-ol" /></router-link>
        <span class="note_sidebar">Danh sách đăng ký</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "SideBar",
  data() {
    return {
      checklogin: false,
    };
  },
  methods: {
    
  },
};
</script>

<style scoped>
.router-link-exact-active {
  color: #888888 !important;
}
.main-sidebar {
  padding: 5px 10px;
  background-color: #f8f9fa;
  bottom: 0;
  position: fixed;
  width: 100%;
  z-index: 988;
}
.main-sidebar ul {
  list-style: none;
  padding: 0;
}
.main-sidebar ul li {
  padding: 2px;
  position: relative;
}
.main-sidebar ul li a {
  font-size: 18pt;
  font-weight: 500;
  color: #d1d3d4;
  transition: 0.5s;
}
.main-sidebar ul li:hover a {
  color: #888888;
  transition: 0.5s;
}
.main-sidebar ul li:hover .note_sidebar {
  display: block;
  transition: 0.8s;
}
.main-sidebar .note_sidebar {
  position: absolute;
  background-color: #1e1e1e;
  border-radius: 5px;
  padding: 3px 7px;
  color: #ffffff;
  top: 50%;
  display: none;
  left: 170%;
  transform: translateY(-50%);
  font-size: 11pt;
  border: 0.5px solid #888888;
  z-index: 99999;
  transition: 0.8s;
  width: auto;
  white-space: nowrap;
}
.main-sidebar .note_sidebar::before {
  content: "";
  width: 0px;
  position: absolute;
  top: 50%;
  left: -15%;
  transform: translateY(-50%);
  height: 0px;
  top: 1;
  border-bottom: 7px solid transparent;
  border-top: 7px solid transparent;
  border-right: 7px solid #1e1e1e;
}
.iconprofile svg {
  width: 24px;
  height: 24px;
  cursor: pointer;
}
@media screen and (min-width: 992px) {
  .main-sidebar {
    left: 0;
    height: calc(100vh - 75px);
    width: auto;
    padding: 15px;
  }
  .main-sidebar ul li {
    margin-bottom: 10px;
  }
}
</style>
