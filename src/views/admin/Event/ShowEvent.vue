<template>
  <div>
      <div class="banner">
          <img :src="Evt.Image" />
      </div>
       <div class="content">
          <div class="title_event">
              <h4>{{Evt.NameSK}}</h4>
          </div>
          <div class="frame_bot"></div>
          <div class="info_event d-flex">
              <p class="icon_el mr-3"><font-awesome-icon icon="clock" /><span>{{Evt.TimeStart}}</span></p>
              <p class="icon_el mr-3"><font-awesome-icon icon="history" /><span>{{Evt.TimeEnd}}</span></p>
              <p class="icon_el mr-3"><font-awesome-icon icon="user-graduate" /><span>{{Evt.NameGV}}</span></p>
              <p class="icon_el"><font-awesome-icon icon="users" /><span>{{Evt.Quantity}}</span></p>
          </div>
          <div class="content_event" v-html="Evt.Content">
          </div>
      </div>

  </div>
</template>

<script>
export default {
    props: {
    Evt: {
      type: Object,
      required: true,
    },
    },
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