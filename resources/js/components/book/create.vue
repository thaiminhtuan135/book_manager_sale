<template>
    <div class="container-fluid">
        <div class="fade-in">
            <CCard>
                <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
                    <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore"
                          ref="formData" enctype="multipart/form-data">
                        <Field type="hidden" :value="csrfToken" name="_token"/>
                        <CCardHeader class="mb-3 addBook bo">
                            {{ data.title }}
                        </CCardHeader>
                        <hr>
                        <CCardBody>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="col-sm-12 d-flex justify-content-between">
                                        <div class="col-sm-5">
                                            <label class="bold-char" for="">Tiêu đề</label>
                                            <div>
                                                <Field placeholder="Tiêu đề" rules="required|max:255" class="form-control" name="title" v-model="model.title"/>
                                                <ErrorMessage class="error" name="title"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="bold-char" for="">Tác giả</label>
                                            <div>
                                                <Field class="form-control" rules="required|max:255" placeholder="Tác giả" name="author" v-model="model.author"/>
                                                <ErrorMessage class="error" name="author"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 justify-content-center d-flex">
                                    <button class="bor rounded-4 mt-5" type="button" style="height: 50px;background-color: seagreen;color: white" @click="chooseImage">
                                        <span class="fa fa-upload" style="color: white ;margin-right: 3px;"></span>Upload</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label class="mb-1 bold-char" for="">Mô tả về sách</label>
                                    <div>
                                        <textarea placeholder="Mô tả sách" name="" id="" class="form-control" cols="87" rows="6"></textarea>
                                    </div>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-sm-5">
                                            <label class="mt-3 mb-2 bold-char" for="">Ngày phát hành </label>
                                            <div>
                                                <Field placeholder="XXXX-XX-XX" rules="required|dob" class="form-control" name="release_date" v-model="model.release_date"/>
                                                <ErrorMessage class="error" name="release_date"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="mt-3 mb-2 bold-char" for="">Số trang</label>
                                            <div>
                                                <Field class="form-control" rules="required" placeholder="Số trang" name="number_page" v-model="model.number_page"/>
                                                <ErrorMessage class="error" name="number_page"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="mt-3 mb-2 bold-char" for="">Thể loại</label>
                                            <CFormSelect
                                                class="form-control"
                                                aria-label="支払完了"
                                                name="category"
                                                rules="required"
                                                @change="status = false"
                                                require
                                                v-model="model.category"
                                                :options="[
                                                    {
                                                        label: 'Chọn thể loại',
                                                        value: null,
                                                        selected : true,
                                                        disabled: true,
                                                    },
                                                    {
                                                        label: 'Tình Tảm',
                                                        value: 'Tình cảm',
                                                    },
                                                    {
                                                        label: 'Khoa học viễn tưởng',
                                                        value: 'Khoa học viễn tưởng',
                                                    },
                                                    {
                                                        label: 'Dạy làm giàu',
                                                        value: 'Dạy làm giàu',
                                                    },
                                                    {
                                                        label: 'Quản trị',
                                                        value: 'Quản trị',
                                                    },

                                                ]"
                                            >
                                            </CFormSelect>
<!--                                            <ErrorMessage class="error" name="category"/>-->
                                            <p v-if="status" class="error">Thể loại bắt buộc phải chọn</p>
<!--                                            <select name="category" class="form-control" v-model="model.to">-->
<!--                                                <option selected>Choose Province</option>-->
<!--                                                <option v-for="option in options" v-bind:value="option.value" >{{ option.label }}</option>-->
<!--                                            </select>-->
                                        </div>
<!--                                        <div>{{model.category}}</div>-->
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center mr">
                                    <div class="searchFrom d-flex align-items-center" style="justify-content: center">
                                        <div class="img-display" id="img" @click="chooseImage()" role="button" style="justify-content: center">
                                            <div style=" display: none;">
                                                <input type="file" @change="onChangeWeb" ref="fileInput" accept="image/*" name="image"/>
                                            </div>
                                            <img class="align-items-center justify-content-center mb-1 mt-1"
                                                 v-if="filePreviewWeb" :src=" filePreviewWeb" style=" max-width: 500px; max-height: 280px"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CCardBody>
                        <CCardFooter>
                            <div class="pull-right">
                                <button @click="checkStatus" type="submit" class="btn btn-primary w-100">Add</button>
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
import {localize} from "@vee-validate/i18n";
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
                        required: "Thể loại không được để trống",
                        max : "Nhập tối đa 255 ký tự"
                    },
                    author: {
                        required: "Tác giả không được để trống",
                        max : "Nhập tối đa 255 ký tự"
                    },
                    release_date: {
                        required: "Ngày phát hành không được để trống",
                        dob : "Ngày phát hành chưa đúng định dạng"
                    },
                    number_page : {
                        required: "Số trang không được để trống",
                    },
                    category : {
                        required: "Thể loại không được để trống",
                        choose : "Thể loại không được để trống",
                    }
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
    computed: {
    },
    props: ["data"],
    data: function () {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: {
                category : null
            },
            status : false,
            filePreviewWeb: "",
            options: [
                {
                    label: "khoa học",
                    value : "khoa học"
                },
                {
                    label: "tuan",
                    value : "tuan"
                },
                {
                    label: "minh",
                    value : "minh"
                },
            ],
        };
    },
    methods: {
        onInvalidSubmit({values, errors, results}) {
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
        checkStatus() {
            if (this.model.category == null) {
                this.status = true;
            }
        },
        onChangeWeb(e) {
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
            this.$refs["fileInput"].click();
        },

    },
}
</script>

<style scoped>
.addBook{
    font-size: 40px;
}
.bold-char{
    font-weight: 700;
    font-size: 20px;
}
.bo{
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
.mr{
    margin-right: 50px;
}
.bor{
    border-radius: 10px;
}
</style>
