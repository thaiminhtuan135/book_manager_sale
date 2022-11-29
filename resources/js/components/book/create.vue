<template>
  <div class="container-fluid">
    <div class="fade-in">
      <CCard>
        <VeeForm
          as="div"
          v-slot="{ handleSubmit }"
          @invalid-submit="onInvalidSubmit"
        >
          <form
            method="POST"
            @submit="handleSubmit($event, onSubmit)"
            :action="data.urlStore"
            ref="formData"
            enctype="multipart/form-data"
          >
            <Field type="hidden" :value="csrfToken" name="_token" />
            <CCardHeader class="mb-3 addBook bo">
              {{ data.title }}
            </CCardHeader>
            <hr />
            <CCardBody>
              <div class="row mb-3">
                <div class="col-sm-6">
                  <div class="col-sm-12 d-flex justify-content-between">
                    <div class="col-sm-5">
                      <label class="bold-char" for="">{{ this.data.title1 }}</label>
                      <div>
                        <Field
                          :placeholder="this.data.title1"
                          rules="required|max:255|unique_book"
                          class="form-control"
                          name="title"
                          v-model="model.title"
                        />
                        <ErrorMessage class="error" name="title" />
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <label class="bold-char" for="">{{this.data.Author}}</label>
                      <div>
                        <Field
                          class="form-control"
                          rules="required|max:255"
                          :placeholder="this.data.Author"
                          name="author"
                          v-model="model.author"
                        />
                        <ErrorMessage class="error" name="author" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 justify-content-center d-flex">
                  <button
                    class="bor rounded-4 mt-5"
                    type="button"
                    style="
                      height: 50px;
                      background-color: seagreen;
                      color: white;
                    "
                    @click="chooseImage"
                  >
                    <span
                      class="fa fa-upload"
                      style="color: white; margin-right: 3px"
                    ></span
                    >{{this.data.Upload}}
                  </button>
<!--                    <button-->
<!--                        class="bor rounded-4 mt-5"-->
<!--                        type="button"-->
<!--                        style="-->
<!--                      height: 50px;-->
<!--                      background-color: red;-->
<!--                      color: white;-->
<!--                    "-->
<!--                        @click="DeleteImage"-->
<!--                    >-->
<!--                    Xóa ảnh-->
<!--                    </button>-->
<!--                    <div @click="DeleteImage" class="">xóa ảnh</div>-->
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <label class="mb-1 bold-char" for="">{{ this.data.Description }}</label>
                  <div>
<!--                    <textarea placeholder="Mô tả sách" id="description" name="description" v-model="model.description" class="form-control" cols="87" rows="6"></textarea>-->
                      <Field as="textarea" name="description" rules="required" v-model="model.description" :placeholder="this.data.Description" class="form-control" cols="70" rows="6"/>
                      <ErrorMessage class="error" name="description" />
                  </div>
                  <div class="row d-flex justify-content-between">
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char">{{ this.data.Release_date }}</label>
                      <div>
                        <Field as="div"
                               rules="required"
                               name="release_date"
                               v-model="model.release_date"/>
                          <datepicker
                              v-model="model.release_date"
                              :closeOnAutoApply="false"
                              :enableTimePicker="false"
                              :maxDate="new Date()"
                              :monthChangeOnScroll="false"
                              autoApply
                              border="6"
                              cancelText="Đóng"
                              format="yyyy-MM-dd"
                              keepActionRow
                              locale="vn"
                              name="release_date"
                              placeholder="1990 - 01 - 01"
                              selectText="Chọn"
                          />
                        <ErrorMessage class="error" name="release_date" />
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char">{{ this.data.Number_page }}</label>
                      <div>
                        <Field
                          class="form-control"
                          rules="required"
                          :placeholder="this.data.Number_page"
                          name="number_page"
                          v-model="model.number_page"
                        />
                        <ErrorMessage class="error" name="number_page" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">{{ this.data.Category }}</label>
                      <CFormSelect
                        class="form-control"
                        aria-label="支払完了"
                        name="category"
                        rules="required"
                        @change="status = false"
                        require
                        v-model="model.category"
                        :options="[
                          { label: this.data.chooseCategory, value: null, selected: true, disabled: true, },
                          { label: 'Tình Tảm', value: 'Tình cảm', },
                          { label: 'Khoa học viễn tưởng', value: 'Khoa học viễn tưởng', },
                          { label: 'Dạy làm giàu', value: 'Dạy làm giàu', },
                          { label: 'Quản trị', value: 'Quản trị', },
                          { label: 'Kinh tế', value: 'Kinh tế', },
                          { label: 'Kỹ năng sống', value: 'Kỹ năng sống', },
                          { label: 'Chính trị - pháp luật', value: 'Chính trị - pháp luật', },
                          { label: 'Khoa học công nghệ', value: 'Khoa học công nghệ', },
                          { label: 'Tâm linh', value: 'Tâm linh', },
                          { label: 'Truyền cảm hứng', value: 'Truyền cảm hứng', },
                        ]"
                      >
                      </CFormSelect>
                      <!--                                            <ErrorMessage class="error" name="category"/>-->
                      <p v-if="status" class="error">
                        {{this.data.requiredCategory}}
                      </p>
                    </div>
                  </div>
                </div>
                <!--image-->
                <div class="justify-content-center mr">
                  <div class="searchFrom d-flex align-items-center" style="justify-content: center">
                    <div class="img-display" id="img" @click="chooseImage()" role="button" style="justify-content: center">
                      <div style="display: none">
                        <input :type="typeFile" @change="onChangeWeb" ref="fileInput" accept="image/*" name="image"/>
                      </div>
                      <img class=" align-items-center justify-content-center mb-1 mt-1"
                        v-if="filePreviewWeb" :src="filePreviewWeb" style="max-width: 500px; max-height: 280px"/><span @click="DeleteImage" v-if="filePreviewWeb" style="font-size: 20px;" class="fa fa-trash"></span>
                    </div>
                  </div>
                        <span style="display: block" class="error" v-if="hasErrImg == true">{{
                                errMsgImage
                            }}</span>
                </div>
              </div>
            </CCardBody>
            <CCardFooter>
              <div class="pull-right">
                <button @click="checkStatus" type="submit" class="mb-2 btn btn-primary w-120">{{this.data.Add}}</button>
              </div>
            </CCardFooter>
          </form>
        </VeeForm>
      </CCard>
    </div>
  </div>
</template>

<script>
import Loader from "../common/loader";
import UploadImages from "vue-upload-drop-images";
import {
  Form as VeeForm,
  Field,
  ErrorMessage,
  defineRule,
  configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
import Toggle from "@vueform/toggle";
import Datepicker from "@vuepic/vue-datepicker";
import axios from "axios";
export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  created() {
    let messError = {
      en: {
        fields: {
          title: {
            required: this.data.requiredTitle,
            max: this.data.max255,
            unique_book : "Sách không được trùng tên",
          },
          author: {
            required: this.data.requiredAuthor,
            max: this.data.max255,
          },
            description: {
                required: this.data.requiredBookDescription,
            },
          release_date: {
            required: this.data.requiredRelease_date,
            dob: this.data.formatReleaseDate,
          },
          number_page: {
            required: this.data.requiredNumberPage,
          },
          category: {
            required: "Thể loại không được để trống",
            choose: "Thể loại không được để trống",
          },
            image:{
                required: "Ảnh không được để trống",
            }
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
      let that = this;
      defineRule('unique_book', (value) => {
          return axios
              .post(that.data.urlCheckNameBook, {
                  _token: Laravel.csrfToken,
                  value: value
              })
              .then(function (response) {
                  console.log(response.data.valid);
                  return response.data.valid
              })
              .catch((error) => {
              })
      })
  },

  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
    Toggle,
    Datepicker,
    UploadImages,

  },
  computed: {},
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: {
        category: null,
      },
      status: false,
      filePreviewWeb: "",
      errMsgImage: "",
      hasErrImg: false,
        typeFile : 'file',
      options: [
        {
          label: "khoa học",
          value: "khoa học",
        },
        {
          label: "tuan",
          value: "tuan",
        },
        {
          label: "minh",
          value: "minh",
        },
      ],
    };
  },
  methods: {
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.$el.querySelector("input[name=" + firstInputError + "]").focus();
      $("html, body").animate(
        {
          scrollTop:
            $("input[name=" + firstInputError + "]").offset().top - 150,
        },
        500
      );
    },
    onSubmit() {
        if (this.hasErrImg == false) {
            this.flagShowLoader = true;
            this.$refs.formData.submit();
        }
    },
    checkStatus() {
      if (this.model.category == null) {
        this.status = true;
      }
    },
    onChangeWeb(e) {
        let Image = e.target.files[0];
        if (
            Image.type.includes("image/jpeg") ||
            Image.type.includes("image/png") ||
            Image.type.includes("image/jpg")
        ) {
            this.errMsgImage = "";
            this.hasErrImg = false;
        } else {
            this.errMsgImage = "Bạn cần chọn ảnh đúng định dạng";
            this.hasErrImg = true;
            return;
        }
        if (Image.size >= 20971520) {
            this.errMsgImage = "Kích thước ảnh quá lớn";
            this.hasErrImg = true;
        } else {
            this.hasErrImg = false;
        }

      let fileInput = this.$refs.fileInput;
      let imgFile = fileInput.files;

      if (imgFile && imgFile[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.filePreviewWeb = e.target.result;
        };
        reader.readAsDataURL(imgFile[0]);
      }
    },
    chooseImage() {
        if (this.typeFile == "hidden") {
            this.typeFile = "file";
        }
      this.$refs["fileInput"].click();
    },
      DeleteImage() {
          this.typeFile = "hidden";
          this.filePreviewWeb = "";
          this.hasErrImg = false;
      },
  },
};
</script>

<style scoped>
.addBook {
  font-size: 40px;
}

.bold-char {
  font-weight: 700;
  font-size: 20px;
}

.bo {
  font-weight: 700;
}

.img-display {
  max-width: 550px;
  width: 550px;
  height: 300px;
  border: solid 2px;
  display: inline-flex;
  border-radius: 4px;
}

.mr {
  margin-right: 50px;
}

.bor {
  border-radius: 10px;
}
.delete_image{
    height: 30px;
    width: 40px;
}
</style>
