<template>
  <!-- :rules="rules" -->
  <a-form-model :model="form" :label-col="labelCol" :wrapper-col="wrapperCol" ref="ruleForm"  @keydown="form.errors.clear($event.target.name)"
            @change="form.errors.clear($event.target.name)">

    <a-form-model-item 
        label="Sự kiện: "
        prop="form.name">
      <a-input v-model="Evt.NameSK" />
    </a-form-model-item>

     <a-form-model-item 
        label="Hình ảnh: "
        prop="image">
     <a-upload
        name="image"
        list-type="picture-card"
        class="avatar-uploader"
        :show-upload-list="false"
        @change="handleChange"
      >
        <img v-if="Evt.Image" :src="Evt.Image" alt="avatar" />
        <div v-else>
          <a-icon :type="loading ? 'loading' : 'plus'" />
          <div class="ant-upload-text">
            Tải ảnh
          </div>
        </div>
    </a-upload>

    </a-form-model-item>
       <vue-editor v-model="Evt.Content" />
     <a-form-model-item 
        label="Số lượng: "
        prop="form.quatity">
      <a-input v-model="Evt.Quantity" />
    </a-form-model-item>

    <a-form-model-item 
        label="Địa điểm: "
        prop="form.place">
      <a-input v-model="Evt.Place" />
    </a-form-model-item>

    <a-form-model-item 
        label="Thời gian BĐ: "
        prop="form.timeStart">
      <a-date-picker  v-model="Evt.TimeStart"/>
    </a-form-model-item>

    <a-form-model-item 
        label="Thời gian KT: "
        prop="form.timeEnd">
      <a-date-picker  v-model="Evt.TimeEnd"/>
    </a-form-model-item>

    <a-form-model-item 
        label="Thể loại: "
        prop="name">
      <a-select default-value="lucy" style="width: 120px" v-model="Evt.IdLSK">
      <a-select-option v-for="(cat,index) in categorys" :key="index" :value="cat.IdLoaiSK">
        {{cat.NameLoaiSK}}
      </a-select-option>
    </a-select>
    </a-form-model-item>
    
    <a-form-model-item 
        label="Ghi chú: "
        prop="form.note">
      <a-textarea placeholder="textarea with clear icon" allow-clear v-model="Evt.Note" />
    </a-form-model-item>
    
  </a-form-model>
</template>

<script>
import { mapActions, mapGetters,mapMutations } from "vuex";
import { VueEditor } from "vue2-editor";
import Form from '@/views/admin/utils/Form'
function getBase64(img, callback) {
  const reader = new FileReader();
  reader.addEventListener('load', () => callback(reader.result));
  reader.readAsDataURL(img);
}
export default {
   components:{
       VueEditor
    },
    props: {
    idEvt: {
      type: Number,
      required: true,
    },
    Evt: {
      type: Object,
      required: true,
    },
    },
    mounted(){
      this.getCategory()
    },
    data(){
        return {
            labelCol: { span: 5 },
            wrapperCol: { span: 19 },
            form: new Form({
                name: '',
                image:'',
                content:'',
                quatity:0,
                place:'',
                timeStart:'',
                timeEnd:'',
                idCat:'1',
                idTK:1,
                status:0,
                note:''
            }),
          
        }
    },
    computed:{
      ...mapGetters(["categorys"]),
    },
    methods:{
      ...mapMutations(["UPDATE_CATEGORYS"]),
      ...mapActions(["getCategory"]),
    submit() {
        this.form.name=this.Evt.NameSK
        this.form.image=this.Evt.Image
        this.form.content=this.Evt.Content
        this.form.quatity=this.Evt.Quantity
        this.form.place=this.Evt.Place
        this.form.timeStart=this.Evt.TimeStart
        this.form.timeEnd=this.Evt.TimeEnd
        this.form.idCat=this.Evt.IdLSK
        this.form.idTK=this.Evt.IdGV
        this.form.status=this.Evt.Status
        this.form.note=this.Evt.Note
        return this.form.patch('Event/event.php?id=' + this.idEvt)
      },
      handleChange(info) {
        getBase64(info.file.originFileObj, imageUrl => {
          console.log(imageUrl)
          this.Evt.Image = imageUrl;
          this.loading = false;
        });
    },
    }
}
</script>

<style scoped>
/* tile uploaded pictures */
img {
  max-width: 200px;
}
</style>