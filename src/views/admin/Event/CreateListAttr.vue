<template>
  <!-- :rules="rules" -->
  <a-form-model :model="form" :label-col="labelCol" :wrapper-col="wrapperCol" ref="ruleForm"  @keydown="form.errors.clear($event.target.name)"
            @change="form.errors.clear($event.target.name)">
    <a-form-model-item 
        label="Sinh viên: "
        prop="name">
      <a-select default-value="lucy" style="width: 120px" v-model="form.idSV">
      <a-select-option v-for="(user,index) in users" :key="index" :value="user.Id">
        {{user.Name}}
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
import Form from '@/views/admin/utils/Form'
export default {
   components:{
      
    },
    mounted(){
      this.getUsers()
    },
    data(){
        return {
            labelCol: { span: 5 },
            wrapperCol: { span: 19 },
            form: new Form({
                idSV:'',
                idSK:this.$route.params.id,
                status:1,
                note:''
            }),
          
        }
    },
    computed:{
      ...mapGetters(["users"]),
    },
    methods:{
      ...mapActions(["getUsers"]),
      submit() {
        return this.form.post('Event/attendance.php')
      },
    }
}
</script>

<style scoped>
/* tile uploaded pictures */
.upload-list-inline .ant-upload-list-item {
  float: left;
  width: 200px;
  margin-right: 8px;
}
.upload-list-inline  .ant-upload-animate-enter {
  animation-name: uploadAnimateInlineIn;
}
.upload-list-inline  .ant-upload-animate-leave {
  animation-name: uploadAnimateInlineOut;
}
</style>