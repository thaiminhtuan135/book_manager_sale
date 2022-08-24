<template>
    <div class="container">
        <div class="fade-in">
            <CRow>
                <CCol :sm="12">
                    <CCard>
                        <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
                            <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlUpdate"
                                  ref="formData" enctype="multipart/form-data">
                                <Field type="hidden" :value="csrfToken" name="_token"/>
                                <Field type="hidden" value="PUT" name="_method"/>
                                <CCardHeader>
                                    <CFormLabel>{{ data.title }}</CFormLabel>
                                </CCardHeader>
                                <CCardBody>
                                    <!-- code -->
                                    <CRow class="mb-2">
                                        <CFormLabel class="col-sm-3 lbl-input" require>Code</CFormLabel>
                                        <div class="col-sm-6">
                                            <Field
                                                name="code"
                                                v-model="model.code"
                                                rules="required|min:8"
                                                class="form-control"
                                            />
                                            <ErrorMessage class="error" name="code"/>
                                        </div>
                                    </CRow>
                                    <!-- name -->
                                    <CRow class="mb-2">
                                        <CFormLabel class="col-sm-3 lbl-input" require>name</CFormLabel>
                                        <div class="col-sm-6">
                                            <Field
                                                name="name"
                                                v-model="model.name"
                                                rules="required|max:255"
                                                class="form-control"
                                            />
                                            <ErrorMessage class="error" name="name"/>
                                        </div>
                                    </CRow>
                                    <!-- telephone -->
                                    <CRow class="mb-2">
                                        <CFormLabel class="col-sm-3 lbl-input">telephone</CFormLabel>
                                        <div class="col-sm-6">
                                            <Field
                                                name="telephone"
                                                v-model="model.telephone"
                                                rules="required|phone_number"
                                                class="form-control"
                                            />
                                            <ErrorMessage class="error" name="telephone"/>
                                        </div>
                                    </CRow>
                                    <!-- address -->
                                    <CRow class="mb-2">
                                        <CFormLabel class="col-sm-3 lbl-input" require>address</CFormLabel>
                                        <div class="col-sm-6">
                                            <Field
                                                name="address"
                                                v-model="model.address"
                                                rules="required|max:255"
                                                class="form-control"
                                            />
                                            <ErrorMessage class="error" name="address"/>
                                        </div>
                                    </CRow>
                                </CCardBody>
                                <CCardFooter>
                                    <div class="col-md-12 text-center btn-box">
                                        <CButton type="submit" class="btn-primary btn-w-100">
                                            Sửa
                                        </CButton>
                                        <a :href="data.urlBack" class="btn btn-default btn-w-100">
                                            Quay lại
                                        </a>
                                    </div>
                                </CCardFooter>
                            </form>
                        </VeeForm>
                    </CCard>
                </CCol>
            </CRow>
        </div>
        <loader :flag-show="flagShowLoader"></loader>
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
import axios from "axios";
import "@vueform/toggle/themes/default.css";

export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
    },
    computed: {},
    props: ["data"],
    data: function () {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: this.data.company,
        };
    },
    mounted() {
        this.model = this.data.company;
    },
    created() {
        let messError = {
            en: {
                fields: {
                    code: {
                        required: "code bắt buộc phải nhập",
                        min: "Nhập ít nhất 8 kí tự",
                    },
                    name: {
                        required: "Tên bắt buộc phải nhập",
                        max: "Nhập tối đa 255 kí tự",
                    },
                    telephone: {
                        required: "Điện thoại bắt buộc phải nhập",
                        phone_number: "Vui lòng nhập số điện thoại chính xác",
                    },
                    address: {
                        required: "Địa chỉ bắt buộc phải nhập",
                        max: "Nhập tối đa 255 kí tự",
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
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
    },
};
</script>
