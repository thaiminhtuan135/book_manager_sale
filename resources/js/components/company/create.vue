<template>
    <div class="container">
        <div class="fade-in">
            <CRow>
                <CCol :sm="12">
                    <CCard>
                        <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
                            <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore"
                                  ref="formData" enctype="multipart/form-data">
                                <Field type="hidden" :value="csrfToken" name="_token"/>
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
                                        <CFormLabel class="col-sm-3 lbl-input" >telephone</CFormLabel>
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
                                            Th??m
                                        </CButton>
                                        <a :href="data.urlBack" class="btn btn-default btn-w-100">
                                            Quay l???i
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
import Toggle from "@vueform/toggle";
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
        Toggle,
    },
    computed: {},
    props: ["data"],
    data: function () {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: {
                status: false,
            },
        };
    },
    created() {
        let messError = {
            en: {
                fields: {
                    code: {
                        required: "code b???t bu???c ph???i nh???p",
                        min: "Nh???p ??t nh???t 8 k?? t???",
                    },
                    name: {
                        required: "T??n b???t bu???c ph???i nh???p",
                        max: "Nh???p t???i ??a 255 k?? t???",
                    },
                    telephone: {
                        required: "??i???n tho???i b???t bu???c ph???i nh???p",
                        phone_number: "Vui l??ng nh???p s??? ??i???n tho???i ch??nh x??c",
                    },
                    address: {
                        required: "?????a ch??? b???t bu???c ph???i nh???p",
                        max: "Nh???p t???i ??a 255 k?? t???",
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
