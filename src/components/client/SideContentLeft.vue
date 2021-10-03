<template>
  <div class="pb-3 position-fixed side-content col-lg-3 d-none d-lg-block" id="sidecontent_left">
    <div class="p-3 mb-3 bg-white rounded frame_listgroup">
      <div class="title">
        <span>THỂ LOẠI SỰ KIỆN</span>
      </div>
      <hr />
      <ul class="pl-0 m-0">
        <li v-for="(cat, index) in categorys" :key="index">
          <!-- @click.native="getclubid(clubs.id)" -->
           <div>
           <a class="py-2 d-flex align-items-center" href="#">
            <div class="flex-shrink-0 mr-2 icon-group">
              <img 
                alt=""
                src="@/assets/logo.png"
                class="intrinsic-item img-fluid undefined"
              />
            </div>
            <p class="mb-0 name_group">{{cat.NameLoaiSK}}</p>
          </a>
           </div>
          
        </li>       
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name:'SideContentLeft',
    computed: {
      ...mapGetters(["categorys"]),
      
    },
    methods: {
     ...mapActions(['getCategory']),       
    },
    mounted(){
      this.getCategory()         
    }
    
};
</script>

<style scoped>
   .name_group{
     transition: .9s;
   }
   .name_group:hover{
     color:blue;
     transition: .9s;
   }
</style>