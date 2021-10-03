<template>
  <div>
    <Header />
    <SideBar />
    <main class="pb-5 main-wrapper">
      <div class="container">
        <div class="row">
          <SideContentLeft />
          <transition name="router-anim">
            <slot></slot>
          </transition>
          <SideContentRight />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import Header from "@/components/client/Header.vue";
import SideBar from "@/components/client/SideBar.vue";
import SideContentLeft from "@/components/client/SideContentLeft";
import SideContentRight from "@/components/client/SideContentRight"
export default {
  name: "layoutbase",
  components: {
    Header,
    SideBar,
    SideContentLeft,
    SideContentRight
  },
};
</script>

<style>
.main-wrapper {
  min-height: 100vh;
}
.main-wrapper .side-content {
  width: 21%;
  max-width: 300px;
  left: 100px;
  overflow-y: scroll;
  -ms-overflow-style: none;
  scrollbar-width: none;
  max-height: calc(100% - 80px);
}
.main-wrapper .side-content::-webkit-scrollbar {
  display: none;
}
.main-wrapper .right-position {
  right: 100px;
  left: auto;
}
.main-wrapper .new-feed-wrapper {
  margin: 0 auto;
  max-width: 600px;
}
.frame_listgroup > hr {
  margin-top: 10px;
  margin-bottom: 7px;
}
.frame_listgroup .title > span {
  font-size: 11pt;
  font-weight: 600;
}
.frame_listgroup ul .icon-group {
  width: 1.875rem;
  height: 1.875rem;
}
.frame_listgroup ul .icon-group img {
  width: inherit;
  height: inherit;
  border-radius: 50%;
}
.name_group {
  font-size: 0.875rem;
  color: #333333;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
.frame_listgroup .listgroup_flow .inf_group button {
  font-size: 0.75rem !important;
}
.frame_listgroup .listgroup_flow .group-item .avatar {
  width: 3.125rem;
  height: 3.125rem;
}
.group-item .avatar img {
  width: inherit;
  height: inherit;
  border-radius: 50%;
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
  .main-wrapper .new-feed-wrapper {
    max-width: 40vmax;
  }
  .main-wrapper {
    padding-left: 8%;
    padding-right: 8%;
  }
}
/* animation */
.router-anim-enter-active{
    animation: coming .5s;    
    opacity: 0.5;
  }
  .router-anim-leave-active{
    animation: going .5s;
  }
  @keyframes going{
    from{
      transform: translateX(0);
    }
    to{
      transform: translateX(-50px);
      opacity: 0;
    }
    
  }
  @keyframes coming{
    from{
      transform: translateX(-50px);
      opacity: 0;
    }
    to{
      transform: translateX(0px);
      opacity: 1;
    }
  }
</style>
