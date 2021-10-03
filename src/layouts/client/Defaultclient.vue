<template>
    <div>
        <Header />
        <SideBar/>
        <transition name="router-anim">
            <slot> 
            </slot>
        </transition>
    </div>
</template>

<script>
import Header from "@/components/client/Header.vue"
import SideBar from "@/components/client/SideBar.vue"
export default {
    name: "layoutbase",
    components: {
        Header,SideBar
    }
};
</script>

<style>
.main-wrapper {
  min-height: 100vh;
}
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
