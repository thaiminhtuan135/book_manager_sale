<template>
  <div class="container-fluid">
    <div class="fade-in">
      <CCard>
        <VeeForm as="div">
          <form method="POST" :action="data.urlUpdate" ref="formData" enctype="multipart/form-data">
            <Field type="hidden" :value="csrfToken" name="_token" />
            <Field type="hidden" value="PUT" name="_method" />
            <CCardHeader class="mb-3 addBook bo">
              {{ data.title }}
            </CCardHeader>
            <hr />
            <CCardBody>
              <div class="row mb-3">
                <div class="col-sm-6">
                  <div class="col-sm-12 d-flex justify-content-between">
<!--                      tittle-->
                    <div class="col-sm-5">
                      <label class="bold-char" for="">{{ this.data.title1 }}</label>
                      <div>
                        <Field id="title" :placeholder="this.data.title1" rules="required|max:255" class="form-control" name="title" v-model="model.title" readonly/>
                        <ErrorMessage class="error" name="title" />
                      </div>
                    </div>
<!--                      author-->
                    <div class="col-sm-5">
                      <label class="bold-char" for="">{{this.data.Author}}</label>
                      <div>
                        <Field class="form-control" id="author" rules="required|max:255" :placeholder="this.data.Author" name="author" v-model="model.author" readonly/>
                        <ErrorMessage class="error" name="author" />
                      </div>
                    </div>
                  </div>
                </div>
<!--                  upload-->
                <div class="col-sm-6 justify-content-center d-flex">
                  <button disabled id="btnUpload" class="bor rounded-4 mt-5" type="button"
                          style=" height: 50px; background-color: seagreen; color: white;" @click="chooseImage">
                        <span class="fa fa-upload" style="color: white; margin-right: 3px"></span>{{ this.data.Upload }}
                  </button>
                </div>
              </div>
              <div class="d-flex justify-content-between">
<!--                  description-->
                <div>
                  <label class="mb-1 bold-char" for="">{{ this.data.Description }}</label>
                  <div>
                      <Field as="textarea" name="description" rules="required" id="description" v-model="model.description" :placeholder="this.data.Description" class="form-control" cols="70" rows="6" readonly/>
                      <ErrorMessage class="error" name="description" />
                  </div>
                  <div class="row d-flex justify-content-between">
<!--                      release_date-->
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">{{this.data.Release_date}}
                      </label>
                      <div>
                        <Field id="release_date" rules="required|dob" placeholder="XXXX-XX-XX" class="form-control" name="release_date" v-model="model.release_date" readonly/>
                        <ErrorMessage class="error" name="release_date" />
                      </div>
                    </div>
<!--                      number_page-->
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">{{ this.data.Number_page }}</label>
                      <div>
                        <Field class="form-control" rules="required" id="number_page" :placeholder="this.data.Number_page" name="number_page" v-model="model.number_page" readonly/>
                        <ErrorMessage class="error" name="number_page" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
<!--                      category-->
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">{{this.data.Category}}</label>
                      <CFormSelect id="category" class="form-control" aria-label="支払完了" name="category"
                                   require v-model="model.category" readonly :options="options">
                      </CFormSelect>
                      <!--                                            <p v-if="status" class="error">Thể loại bắt buộc phải chọn</p>-->
                    </div>
                  </div>
                </div>
<!--                  image-->
                <div class="justify-content-center">
                  <div class="searchFrom d-flex align-items-center" style="justify-content: center">
                    <div class="img-display" id="img" @click="chooseImage()" role="button" style="justify-content: center" :class="status ? '' : 'not-active'">
                      <div style="display: none">
                        <input :type="typeFile" @change="onChangeWeb" ref="fileInput" accept="image/*" name="image"/>
                      </div>
                      <img id="anh" class=" align-items-center justify-content-center mb-1 mt-1"
                        v-if="filePreviewWeb" :src="filePreviewWeb" style="max-width: 500px; max-height: 280px"/>
                        <span @click="DeleteImage" v-if="filePreviewWeb" style="font-size: 20px;" class="fa fa-trash"></span>
<!--                        <Field class="hidden" v-model="linkImage" name="linkImage"/>-->

                    </div>
                  </div>
                    <span style="display: block" class="error" v-if="hasErrImg == true">{{
                            errMsgImage
                        }}</span>
                </div>
              </div>
            </CCardBody>
            <CCardFooter>
              <div class="pull-right mb-2">
                <div @click="changeStatus" class="btn btn-primary w-100" id="btnEdit">{{this.data.Edit1}}</div>
                <button type="submit" id="btnSave" class="btn btn-primary w-100 hidden">{{this.data.Save}}</button>
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

export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  created() {
      this.filePreviewWeb = this.data.book.image ? this.data.book.image : "";
    let messError = {
      en: {
        fields: {
          title: {
            required: this.data.requiredTitle,
            max: this.data.max255,
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
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
  },
  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
    Toggle,
    Datepicker,
  },
  computed: {},
  props: ["data"],
  data: function () {
      // let ac = this.data.book.image.split("/");
      // let linkImage = ac[2];
      // console.log(linkImage);
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.book,
      filePreviewWeb: this.data.book.image,
      check: false,
      status: false,
      statusImage: true,
        errMsgImage: "",
        hasErrImg: false,
        typeFile : 'file',
      // linkImage : linkImage,
      options: [
        {label: this.data.chooseCategory, value: null, disabled: true,},
        {label: "Tình cảm", value: "Tình cảm", disabled: true,},
        {label: "Khoa học viễn tưởng", value: "Khoa học viễn tưởng", disabled: true,},
        {label: "Dạy làm giàu", value: "Dạy làm giàu", disabled: true,},
        {label: "Quản trị", value: "Quản trị", disabled: true,},
        {label: "Kinh tế", value: "Kinh tế", disabled: true,},
        {label: "Kỹ năng sống", value: "Kỹ năng sống", disabled: true,},
        {label: "Chính trị - pháp luật", value: "Chính trị - pháp luật", disabled: true,},
        {label: "Khoa học công nghệ", value: "Khoa học công nghệ", disabled: true,},
        {label: "Tâm linh", value: "Tâm linh", disabled: true,},
        {label: "Truyền cảm hứng", value: "Truyền cảm hứng", disabled: true,},
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
    changeStatus() {
      $("#btnEdit").addClass("hidden");
      $("#btnSave").removeClass("hidden");
      $("#title").attr("readonly", false);
      $("#author").attr("readonly", false);
      $("#release_date").attr("readonly", false);
      $("#number_page").attr("readonly", false);
      $("#btnUpload").attr("disabled", false);
      $("#deteleImage").attr("disabled", false);
      $("#category").attr("readonly", false);
      $("#description").attr("readonly", false);

      for (var key in this.options) {
        this.options[key]["disabled"] = false;
      }
      this.options[0]["disabled"] = true;
      this.status = true;
      this.check = true;

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
            console.log(this.hasErrImg)
        } else {
            this.hasErrImg = false;
        }

      let imgFile = e.target.files;
      if (imgFile && imgFile[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.filePreviewWeb = e.target.result;
        };
        reader.readAsDataURL(imgFile[0]);
      }
        this.hasErrImg = true;
    },
    chooseImage() {
        if (this.typeFile == "hidden") {
            this.typeFile = "file";
        }
      this.$refs["fileInput"].click();
    },
      DeleteImage() {
          // this.linkImage = "";
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

.not-active {
  pointer-events: none;
  cursor: default;
  text-decoration: none;
  color: black;
}
</style>
