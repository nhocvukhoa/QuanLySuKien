<template>
  <!-- :rules="rules" -->
  <a-form-model :model="form" :label-col="labelCol" :wrapper-col="wrapperCol" ref="ruleForm"  @keydown="form.errors.clear($event.target.name)"
            @change="form.errors.clear($event.target.name)">
            <a-alert type="error" v-show="isEmpty" message="Dữ liệu trống !!" banner />

    <a-form-model-item 
        label="Sự kiện: "
        prop="form.name">
      <a-input v-model="form.name" />
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
        <img v-if="form.image" :src="form.image" alt="avatar" />
        <div v-else>
          <a-icon :type="loading ? 'loading' : 'plus'" />
          <div class="ant-upload-text">
            Tải ảnh
          </div>
        </div>
    </a-upload>

    </a-form-model-item>
       <vue-editor v-model="form.content" />
     <a-form-model-item 
        label="Số lượng: "
        prop="form.quatity">
      <a-input v-model="form.quatity" />
    </a-form-model-item>

    <a-form-model-item 
        label="Địa điểm: "
        prop="form.place">
      <a-input v-model="form.place" />
    </a-form-model-item>

    <a-form-model-item 
        label="Thời gian BĐ: "
        prop="form.timeStart">
      <a-date-picker  
        show-time placeholder="Chọn thời gian"
        @ok="onOk"
        v-model="form.timeStart"/>
    </a-form-model-item>

    <a-form-model-item 
        label="Thời gian KT: "
        prop="form.timeEnd">
      <a-date-picker  
        show-time placeholder="Chọn thời gian"
        @ok="onOk"
        v-model="form.timeEnd"/>
    </a-form-model-item>
    
    <a-form-model-item 
        label="Thể loại: "
        prop="name">
      <a-select default-value="lucy" style="width: 120px" v-model="form.idCat">
      <a-select-option v-for="(cat,index) in categorys" :key="index" :value="cat.IdLoaiSK">
        {{cat.NameLoaiSK}}
      </a-select-option>
    </a-select>
    </a-form-model-item>
    
    <a-form-model-item 
        label="Ghi chú: "
        prop="form.note">
      <a-textarea placeholder="Nhập ghi chú..." allow-clear v-model="form.note" />
    </a-form-model-item>
  </a-form-model>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
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
            loading: false,
            isEmpty:false
        }
    },
    computed:{
      ...mapGetters(["categorys"]),
    },
    methods:{
      ...mapActions(["getCategory"]),
    submit() {
        let user = JSON.parse(sessionStorage.getItem("tokenloginAdmin"));
        this.form.idTK=user['Id']
        if(user['Power']==1) this.form.status=1
        if(this.form.name=="" || this.form.content=="" || this.form.place=="" || this.form.timeStart==""){
          this.isEmpty=true
          return;
        }
        return this.form.post('Event/event.php')
    },
    handleChange(info) {
        getBase64(info.file.originFileObj, imageUrl => {
          this.form.image = imageUrl;
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