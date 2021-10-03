<template>
  <a-layout id="components-layout-demo-side" style="min-height: 100vh">
    <SideBarAdmin/>
    <a-layout>
      <HeaderAdmin/>
      <a-layout-content style="margin: 0 16px">
        <slot></slot>
      </a-layout-content>
      <FooterAdmin/>
    </a-layout>
  </a-layout>
</template>
<script>
import SideBarAdmin from "../../components/admin/SideBarAdmin"
import HeaderAdmin from "../../components/admin/HeaderAdmin"
import FooterAdmin from "../../components/admin/FooterAdmin"
export default {
components:{
    SideBarAdmin,HeaderAdmin,FooterAdmin
},
  data() {
    return {
     
    };
  },
};
</script>

<style>
</style>