<template>
<!--    <component :is="componentName" :data="data" :index="index"></component>-->
    <!--name-->
    <CRow class="mb-3">
        <CFormLabel class="col-sm-3 lbl-input" require>{{message.FullName}}</CFormLabel>
        <div class="col-sm-6">
            <Field v-model="data.name" :name="'name'+index" class="form-control" :placeholder="message.FullName" rules="required|max:255"/>
            <ErrorMessage class="error" :name="'name'+index"/>
        </div>
    </CRow>
    <!--address-->
    <CRow class="mb-3">
        <CFormLabel class="col-sm-3 lbl-input" require>{{ message.Address }}</CFormLabel>
        <div class="col-sm-6">
            <Field v-model="data.address" :name="'address'+index" class="form-control" :placeholder="message.Address" rules="required|max:255"/>
            <ErrorMessage class="error" :name="'address'+index"/>
        </div>
    </CRow>
    <!--dob-->
    <CRow class="mb-3">
        <CFormLabel class="col-sm-3 lbl-input" require>ngay sinh</CFormLabel>
        <div class="col-sm-6">
            <Field as="div" rules="required" :name="'dob'+index" v-model="data.dob">
                <datepicker
                    v-model="data.dob"
                    :closeOnAutoApply="false"
                    :enableTimePicker="false"
                    :maxDate="new Date()"
                    :monthChangeOnScroll="false"
                    autoApply
                    border="3"
                    cancelText="Đóng"
                    format="yyyy-MM-dd"
                    keepActionRow
                    locale="vn"
                    :name="'dob'+index"
                    placeholder="1990 - 01 - 01"
                    selectText="Chọn"
                />
            </Field>
            <ErrorMessage class="error" :name="'dob'+index"/>
        </div>
    </CRow>
<!--    <CRow class="mb-3">-->
<!--        <CFormLabel class="col-sm-3 lbl-input" require>{{ message.Dob }}</CFormLabel>-->
<!--        <div class="col-sm-6">-->
<!--            <Field v-model="data.dob" :name="'dob'+index" class="form-control" placeholder="XXXX-XX-XX" rules="required|dob"/>-->
<!--            <ErrorMessage class="error" :name="'dob'+index"/>-->
<!--        </div>-->
<!--    </CRow>-->
    <!-- telephone -->
    <CRow class="mb-3">
        <CFormLabel class="col-sm-3 lbl-input" require>{{ message.PhoneNumber }}</CFormLabel>
        <div class="col-sm-6">
            <Field placeholder="0XXXXXXXXX" :name="'telephone'+ index " v-model="data.telephone" class="form-control" rules="required|phone_number"/>
            <ErrorMessage class="error" :name="'telephone'+ index "/>
        </div>
    </CRow>
    <!-- email -->
    <CRow class="mb-3">
        <CFormLabel class="col-sm-3 lbl-input" require>{{ message.Email }}</CFormLabel>
        <div class="col-sm-6">
            <Field placeholder="Email" :name="'email'+index" v-model="data.email" rules="required|email|max:255|unique_email|email_duplicate_fe" class="form-control"/>
            <ErrorMessage class="error" :name="'email'+index"/>
        </div>
    </CRow>
    <!-- pasword -->
    <CRow class="mb-5">
        <CFormLabel class="col-sm-3 lbl-input" require>{{ message.password }}</CFormLabel>
        <div class="col-sm-6">
            <Field autocomplete="off" :placeholder="message.password" :name="'password'+index"
                   v-model="data.password" rules="required|min:8|max:255"
                   class="form-control" type="password"/>
            <ErrorMessage class="error" :name="'password'+index"/>
        </div>
        <div class="col-sm-2">
            <CButton class="fs-5" @click="$emit('remove')">
                <i class="fa fa-minus-circle" aria-hidden="true"></i>
            </CButton>
        </div>
    </CRow>
</template>
<script>
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure,
} from "vee-validate";
import * as rules from "@vee-validate/rules";
import Loader from "../common/loader";
import Datepicker from "@vuepic/vue-datepicker";
export default {
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
        Datepicker
    },
    props: {
        data: Object,
        index: Number,
        message: Object,

    },

};
</script>
