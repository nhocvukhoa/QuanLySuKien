<template>
  <div class="new-feed-wrapper col-12 px-2 px-lg-2 border border-info rounded">
      <div class="banner mt-1">
          <img :src="eventID.Image" />
      </div>
       <div class="content">
          <div class="title_event">
              <h4>{{eventID.NameSK}}</h4>
          </div>
          <div class="frame_bot"></div>
          <div class="info_event d-flex">
              <p class="icon_el mr-3"><font-awesome-icon icon="clock" /><span>{{eventID.TimeStart}}</span></p>
              <p class="icon_el mr-3"><font-awesome-icon icon="history" /><span>{{eventID.TimeEnd}}</span></p>
              <p class="icon_el mr-3"><font-awesome-icon icon="user-graduate" /><span>{{eventID.NameGV}}</span></p>
              <p class="icon_el mr-3"><font-awesome-icon icon="map-marker" /><span>{{eventID.Place}}</span></p>
              <p class="icon_el"><font-awesome-icon icon="users" /><span>{{eventID.Quantity}}</span></p>
          </div>
          <div class="content_event" v-html="eventID.Content">
          </div>
      </div>

  </div>
</template>

<script>
import { mapActions, mapGetters} from "vuex";
export default {
   data(){
    return {

    }
  },
  mounted() {
    this.getEventID(this.$route.params.id);
  },
  computed:{
     ...mapGetters(["eventID"]),
  },
  methods:{
    ...mapActions(["getEventID"]),
  } 
}
</script>

<style scoped>
.banner {
    width: 100%;
    text-align: center;
}
.banner img {
    max-width: 450px;
}
.title_event {
    margin: 10px 0;
    text-align: center;
}
.title_event h4 {
     font-family: Arial, Helvetica, sans-serif;
    font-weight: 600;
    color: rgba(0, 0, 0, 0.692);
    font-size: 16pt;
}
.frame_bot {
    width: 40px;
    margin: 5px 0 10px;
    height: 5px;
    background: rgb(195, 204, 185);
}
.icon_el {
    display: flex;
    align-items: center;
}
.icon_el>svg {
    margin-right: 5px;
    font-size: 10pt;
}
.info_event {
   
    align-items: center;
    justify-content: start;
}
.info_event p span {
    font-size: 9pt;
}
.content_event {
    text-align: justify;
    width: 100%;
}
.content_event img {
    width: 100%;
    max-width: 300px;
}
</style>