<template>
  <div
    class="position-fixed side-content col-lg-3 d-none d-lg-block right-position"
  >
    <div class="p-3 mb-3 bg-white rounded frame_listgroup">
      <div class="title">
        <span>SỰ KIỆN</span>
      </div>
      <hr />
      <div class="listgroup_flow">
        <ul class="pl-0 m-0">
          <li v-for="(event, index) in events" :key="index">
            <div
              class="py-2 overflow-hidden bg-white d-flex group-item align-items-center"
            >
                <div class="flex-shrink-0 avatar">
                  <img
                    alt=""
                    src="@/assets/logo.png"
                    class="border shadow-sm intrinsic-item img-fluid border-light"
                  />
                </div>
              <div class="ml-2 inf_group">
                <span class="name_group">{{ event.NameSK }}</span>
                <button
                  type="button"
                  class="text-white border border-white fz-12 bg-main btn btn-secondary d-block"
                  @click="nextPage(event.IdSK)"
                >
                  Chi tiết
                </button>
              </div>
            </div>
          </li>         
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name:'SideContentRight',
    computed: {
      ...mapGetters(['events']),
    },
    methods: {
      ...mapActions(['getEvent','getEventID']),
      nextPage(id){
        this.getEventID(id);
        setTimeout(() => {
          this.$router.push("/event/"+id);
        }, 100);
      }
    },
    mounted() {
    this.getEvent();
    },
};
</script>

<style>
</style>