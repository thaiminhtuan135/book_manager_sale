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
            :action="data.urlUpdate"
            ref="formData"
            enctype="multipart/form-data"
          >
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
                    <div class="col-sm-5">
                      <label class="bold-char" for="">Tiêu đề</label>
                      <div>
                        <Field
                          id="title"
                          placeholder="Tiêu đề"
                          class="form-control"
                          name="title"
                          v-model="model.title"
                          readonly
                        />
                        <ErrorMessage class="error" name="title" />
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <label class="bold-char" for="">Tác giả</label>
                      <div>
                        <Field
                          class="form-control"
                          id="author"
                          placeholder="Tác giả"
                          name="author"
                          v-model="model.author"
                          readonly
                        />
                        <ErrorMessage class="error" name="author" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 justify-content-center d-flex">
                  <button
                    disabled
                    id="btnUpload"
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
                    >Upload
                  </button>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <label class="mb-1 bold-char" for="">Mô tả về sách</label>
                  <div>
                    <textarea
                      placeholder="Mô tả sách"
                      name="description"
                      id="description"
                      cols="87"
                      rows="6"
                      disabled
                    ></textarea>
                  </div>
                  <div class="row d-flex justify-content-between">
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for=""
                        >Ngày phát hành
                      </label>
                      <div>
                        <Field
                          id="release_date"
                          placeholder="XXXX-XX-XX"
                          class="form-control"
                          name="release_date"
                          v-model="model.release_date"
                          readonly
                        />
                        <ErrorMessage class="error" name="release_date" />
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">Số trang</label>
                      <div>
                        <Field
                          class="form-control"
                          id="number_page"
                          placeholder="Số trang"
                          name="number_page"
                          v-model="model.number_page"
                          readonly
                        />
                        <ErrorMessage class="error" name="number_page" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-5">
                      <label class="mt-3 mb-2 bold-char" for="">Thể loại</label>
                      <CFormSelect
                        id="category"
                        class="form-control"
                        aria-label="支払完了"
                        name="category"
                        require
                        v-model="model.category"
                        readonly
                        :options="options"
                      >
                      </CFormSelect>
                      <!--                                            <p v-if="status" class="error">Thể loại bắt buộc phải chọn</p>-->
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div
                    class="searchFrom d-flex align-items-center"
                    style="justify-content: center"
                  >
                    <div
                      class="img-display"
                      id="img"
                      @click="chooseImage()"
                      role="button"
                      style="justify-content: center"
                      :class="status ? '' : 'not-active'"
                    >
                      <div style="display: none">
                        <input
                          type="file"
                          @change="onChangeWeb"
                          ref="fileInput"
                          accept="image/*"
                          name="image"
                        />
                      </div>
                      <img
                        id="anh"
                        class="
                          align-items-center
                          justify-content-center
                          mb-1
                          mt-1
                        "
                        v-if="filePreviewWeb"
                        :src="status ? filePreviewWeb : getLogo(filePreviewWeb)"
                        style="max-width: 500px; max-height: 280px"
                      />
                      <img
                        id="anh1"
                        v-if="check"
                        :src="getLogo(file)"
                        class="
                          align-items-center
                          justify-content-center
                          mb-1
                          mt-1
                        "
                        style="max-width: 500px; max-height: 280px"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </CCardBody>
            <CCardFooter>
              <div class="pull-right mb-2">
                <!--                                <button class="btn btn-primary w-100">Edit</button>-->
                <div
                  @click="changeStatus"
                  class="btn btn-primary w-100"
                  id="btnEdit"
                >
                  Edit
                </div>
                <button
                  type="submit"
                  id="btnSave"
                  class="btn btn-primary w-100 hidden"
                >
                  Save
                </button>
              </div>
            </CCardFooter>
          </form>
        </VeeForm>
      </CCard>
      <img
        src="http://localhost/storage/image-media/03ae90ba4d544e27b4dec91b272b09ab1a3f0891.jpg"
        alt=""
      />
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
    let messError = {
      en: {
        fields: {
          title: {
            required: "Thể loại không được để trống",
            max: "Nhập tối đa 255 ký tự",
          },
          author: {
            required: "Tác giả không được để trống",
            max: "Nhập tối đa 255 ký tự",
          },
          release_date: {
            required: "Ngày phát hành không được để trống",
            dob: "Ngày phát hành chưa đúng định dạng",
          },
          number_page: {
            required: "Số trang không được để trống",
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
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.book,
      filePreviewWeb: this.data.book.image,
      file: this.data.book.image,
      check: false,
      status: false,

      options: [
        {
          label: "Chọn thể loại",
          value: null,
          disabled: true,
        },
        {
          label: "Tình cảm",
          value: "Tình cảm",
          disabled: true,
        },
        {
          label: "Khoa học viễn tưởng",
          value: "Khoa học viễn tưởng",
          disabled: true,
        },
        {
          label: "Dạy làm giàu",
          value: "Dạy làm giàu",
          disabled: true,
        },
        {
          label: "Quản trị",
          value: "Quản trị",
          disabled: true,
        },
        {
          label: "Kinh tế",
          value: "Kinh tế",
          disabled: true,
        },
        {
          label: "Kỹ năng sống",
          value: "Kỹ năng sống",
          disabled: true,
        },
        {
          label: "Chính trị - pháp luật",
          value: "Chính trị - pháp luật",
          disabled: true,
        },
        {
          label: "Khoa học công nghệ",
          value: "Khoa học công nghệ",
          disabled: true,
        },
        {
          label: "Tâm linh",
          value: "Tâm linh",
          disabled: true,
        },
        {
          label: "Truyền cảm hứng",
          value: "Truyền cảm hứng",
          disabled: true,
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
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
    getLogo(logo) {
      return "/imgBook/" + logo;
    },
    changeStatus() {
      $("#btnEdit").addClass("hidden");
      $("#btnSave").removeClass("hidden");
      $("#title").attr("readonly", false);
      $("#author").attr("readonly", false);
      $("#release_date").attr("readonly", false);
      $("#number_page").attr("readonly", false);
      $("#btnUpload").attr("disabled", false);
      $("#category").attr("readonly", false);
      $("#description").attr("disabled", false);
      $("#anh").addClass("hidden", true);
      for (var key in this.options) {
        this.options[key]["disabled"] = false;
      }
      this.options[0]["disabled"] = true;
      this.status = true;
      this.check = true;
      console.log(this.filePreviewWeb);
    },
    onChangeWeb(e) {
      // let fileInput = this.$refs.fileInput;
      let imgFile = e.target.files;
      // console.log(imgFile[0]);
      // console.log(e.target.files);
      if (imgFile && imgFile[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.filePreviewWeb = e.target.result;
        };
        reader.readAsDataURL(imgFile[0]);
      }
      $("#anh").removeClass("hidden");
      $("#anh1").addClass("hidden");
    },
    chooseImage() {
      this.$refs["fileInput"].click();
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
