<template>
    <div class="container-fluid align-items-center">
        <div class="fade-in">
            <div class="row justify-content-center mb-3">
                <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema" @invalid-submit="onInvalidSubmit">
                    <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore" ref="formRegister">
                        <input type="hidden" :value="csrfToken" name="_token" />
                        <CCardBody>
                            <CRow class="mb-2 justify-content-center" style="font-size: 70px">
                                Đăng ký người dùng
                            </CRow>
                            <!-- name -->
                            <CRow class="mb-4">
                                <CFormLabel class="col-sm-3 lbl-input" require>Họ tên</CFormLabel>
                                <Field class="hidden" name="role_id" v-model="role_id"/>
                                <div class="col-sm-6">
                                    <Field
                                        placeholder="Họ tên"
                                        v-model="model.name"
                                        class="form-control"
                                        name="name"
                                        rules="required|max:255"
                                    />
<!--                                    <span class="error" style="display: block;" v-if="msg.err_name">{{msg.err_name}}</span>-->
                                    <ErrorMessage class="error" name="name"/>
                                </div>
                            </CRow>
                            <!-- address -->
                            <CRow class="mb-4">
                                <CFormLabel class="col-sm-3 lbl-input" require>Địa chỉ</CFormLabel>
                                <div class="col-sm-6">
                                    <Field
                                        v-model="model.address"
                                        class="form-control"
                                        name="address"
                                        rules="required|max:255"
                                        placeholder="Địa chỉ"
                                    />
                                    <ErrorMessage class="error" name="address"/>
                                </div>
                            </CRow>
                            <!-- dob -->
                            <CRow class="mb-4">
                                <CFormLabel class="col-sm-3 lbl-input" require>Ngày sinh</CFormLabel>
                                <div class="col-sm-6">
<!--                                    <datepicker-->
<!--                                        v-model="model.dob" :closeOnAutoApply="false" :enableTimePicker="false" :maxDate="new Date()"-->
<!--                                        :monthChangeOnScroll="false" autoApply border="3" cancelText="Đóng" format="yyyy-MM-dd"-->
<!--                                        keepActionRow locale="vn" name="dob" placeholder="1990 - 01 - 01" rules="required" selectText="Chọn"-->
<!--                                    />-->
                                    <Field  name="dob"  v-model="dob" placeholder="XXXX-XX-XX" class="form-control" rules="required|dob"/>
                                    <span class="error" style="display: block;" v-if="msg.err_dob">{{msg.err_dob}}</span>
                                    <ErrorMessage class="error" name="dob"/>
                                </div>
                            </CRow>
                            <!-- telephone -->
                            <CRow class="mb-4">
                                <CFormLabel class="col-sm-3 lbl-input" require>Số điện thoại</CFormLabel>
                                <div class="col-sm-6">
                                    <Field
                                           placeholder="Số điện thoại"
                                           name="telephone"
                                           v-model="model.telephone"
                                           class="form-control"
                                           rules="required|phone_number"/>
                                    <span class="error" style="display: block;" v-if="msg.err_msg">{{msg.err_msg}}</span>
                                    <ErrorMessage class="error" name="telephone"/>
                                </div>
                            </CRow>
                            <!-- email -->
                            <CRow class="mb-4">
                                <CFormLabel class="col-sm-3 lbl-input" require>Email</CFormLabel>
                                <div class="col-sm-6">
                                    <Field
                                        placeholder="Email"
                                        name="email"
                                        v-model="model.email"
                                        rules="required|email|max:255|unique_email"
                                        class="form-control"
                                    />
                                    <ErrorMessage class="error" name="email"/>
                                </div>
                            </CRow>
                            <!-- pasword -->
                            <CRow class="mb-5">
                                <CFormLabel class="col-sm-3 lbl-input" require>Mật khẩu</CFormLabel>
                                <div class="col-sm-6">
                                    <Field
                                        autocomplete="off"
                                        placeholder="Mật khẩu"
                                        name="password"
                                        v-model="model.password"
                                        rules="required|min:8|max:288"
                                        class="form-control"
                                        type="password"
                                    />
                                    <ErrorMessage class="error" name="password"/>
                                </div>
                            </CRow>
                        </CCardBody>
                        <CCardFooter>
                            <div class="col-md-12 text-center btn-box">
                                <CButton type="submit" class="btn-primary btn-w-100">
                                    Đăng ký
                                </CButton>
                                <a :href="data.urlBack" class="btn btn-default btn-w-100">
                                    Quay lại
                                </a>
                            </div>
                        </CCardFooter>
                    </form>
                </VeeForm>
            </div>
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
    configure
} from "vee-validate";
// import * as Yup from "yup";
import Datepicker from "@vuepic/vue-datepicker";
// import "@vuepic/vue-datepicker/dist/main.css";
import * as rules from "@vee-validate/rules";
import {localize} from "@vee-validate/i18n";
import axios from "axios";
export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    data() {
        return {
            flagShowLoader: false,
            model: {},
            role_id : 1,
            dob :'',
            csrfToken: Laravel.csrfToken,
            msg : []
        };
    },
    props: ["data"],
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
        Datepicker,
    },
    created() {
        let messError = {
            en: {
                fields: {
                    name: {
                        required: "Họ tên không được để trống",
                        max: "Nhập tối đa 255 kí tự",
                    },
                    telephone: {
                        required: "Điện thoại không được để trống",
                        phone_number: "Vui lòng nhập số điện thoại đúng định dạng",
                    },
                    address: {
                        required: "Địa chỉ không được để trống",
                        max: "Nhập tối đa 255 kí tự",
                    },
                    dob: {
                        required: "Ngày sinh bắt buộc phải chọn",
                        dob : "Ngày sinh chưa đúng định dạng",
                    },
                    email: {
                        required: "Email không được để trống",
                        email: "Email chưa đúng định dạng",
                        max: "Nhập tối đa 255 kí tự",
                        unique_email : "Email đã được đăng ký",
                    },
                    password : {
                        required: "Mật khẩu không được để trống",
                        min : "Mật khẩu phải ít nhất 8 ký tự",
                        max : "Mật khẩu tối đa 255 ký tự",

                    }
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });

        let that = this;
        defineRule('unique_email',(value) => {
            return axios
            .post(that.data.urlCheckMail,{
                _token: Laravel.csrfToken,
                value : value
            })
            .then(function (response) {
                console.log(response.data.valid);
                return response.data.valid
            })
            .catch((error)=>{})
        })
    },

    methods: {
        onInvalidSubmit({ values, errors, results }) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
        },
        onSubmit() {
            this.flagShowLoader = true;
            this.$refs.formRegister.submit();
        },
    },
    watch :{
        'model.telephone'() {
            if (!/\d/.test(this.model.telephone)) {
                this.msg["err_msg"] = "Chỉ được nhập số";
            } else {
                this.msg["err_msg"] = "";
            }
        },
        // 'dob' () {
        //     this.dob = this.dob.replace(/[^0-9]/g, '').replace(/^(\d{4})(\d{2})(\d{2})/, '$1-$2-$3');
        // },
        // 'model.name'() {
        //     if (! (/^[A-Za-z]+$/).test(this.model.name)) {
        //         this.msg["err_name"] = "Chỉ được nhập chữ";
        //     } else {
        //         this.msg["err_name"] = "";
        //
        //     }
        // },
    }
}
</script>

<style scoped>
.input-group-text {
    border-radius: 4px;
    font-size: 15px;
    line-height: 24px;
    color: #fff;
    font-weight: bold;
    background-color: #ccc;
    border: 1px solid #ccc;
}
</style>
