<template>
  <a-form-model :model="form" :label-col="labelCol" :wrapper-col="wrapperCol" ref="ruleForm"  @keydown="form.errors.clear($event.target.name)"
            @change="form.errors.clear($event.target.name)">
    <a-alert type="error" v-show="isEmpty" message="Dữ liệu trống !!" banner />

    <a-form-model-item 
        label="Tên loại sự kiện: "
        prop="name">
      <a-input v-model="form.name" required/>
    </a-form-model-item>
    
  </a-form-model>
</template>

<script>
import Form from '@/views/admin/utils/Form'
export default {
    data(){
        return {
            labelCol: { span: 6 },
            wrapperCol: { span: 18 },
            form: new Form({
                name: '',
            }),
            isEmpty:false
        }
    },
    methods:{
    submit() {
        if(this.form.name==""){
          this.isEmpty=true
          return;
        }
        return this.form.post('Category/category.php')
      },
    }
}
</script>

<style>

</style>