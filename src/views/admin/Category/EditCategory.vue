<template>
  <a-form-model
    :model="form"
    :label-col="labelCol"
    :wrapper-col="wrapperCol"
    ref="ruleForm"
    @keydown="form.errors.clear($event.target.name)"
    @change="form.errors.clear($event.target.name)"
  >
    
    <a-form-model-item label="Tên loại sự kiện: " prop="name">
      <a-input v-model="Cat.NameLoaiSK" />
    </a-form-model-item>

  </a-form-model>
</template>

<script>
import { mapMutations } from "vuex";
import Form from "@/views/admin/utils/Form";
export default {
  props: {
    idCat: {
      type: Number,
      required: true,
    },
    Cat: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      labelCol: { span: 6 },
      wrapperCol: { span: 18 },
      form: new Form({
        name: this.idCat,
      }),
    };
  },
  methods: {
    ...mapMutations(["UPDATE_CATEGORYS"]),
    submit() {
      this.form.name = this.Cat.NameLoaiSK;
      this.UPDATE_CATEGORYS({
        IdLoaiSK: this.idCat,
        NameLoaiSK: this.Cat.NameLoaiSK,
      });
      return this.form.patch(
        "Category/category.php?id=" + this.idCat
      );
    },
  },
};
</script>