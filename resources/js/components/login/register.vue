<template>
    <div class="container-fluid align-items-center">
        <div class="fade-in">
            <div class="row justify-content-center mb-3">
                <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema"
                         @invalid-submit="onInvalidSubmit">
                    <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore"
                          ref="formRegister">
                        <input type="hidden" :value="csrfToken" name="_token"/>
                        <Field type="hidden" v-model="listModel.length" name="size"/>
                        <div class="card" style="background: lightblue;">
                            <CCardBody>
                                <CRow class="mb-2 justify-content-center" style="font-size: 70px">
                                    {{ this.data.registration }}
                                </CRow>
                                <Field class="hidden" name="role_id" v-model="role_id"/>
                                <!-- name0 -->
                                <CRow class="mb-3">
                                    <CFormLabel class="col-sm-3 lbl-input" require>{{ this.data.name }}</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field :placeholder="this.data.name" v-model="listModel[0].name"
                                               class="form-control" name="name0" rules="required|max:255"/>
                                        <ErrorMessage class="error" name="name0"/>
                                    </div>
                                </CRow>
                                <!-- address0 -->
                                <CRow class="mb-3">
                                    <CFormLabel class="col-sm-3 lbl-input" require>{{ this.data.address }}</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field v-model="listModel[0].address" class="form-control" name="address0"
                                               rules="required|max:255" :placeholder="this.data.address"/>
                                        <ErrorMessage class="error" name="address0"/>
                                    </div>
                                </CRow>
                                <!-- dob0 -->
                                <CRow class="mb-3">
                                    <CFormLabel class="col-sm-3 lbl-input" require>ngay sinh</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field as="div"  rules="required" name="dob0" v-model="listModel[0].dob">
                                            <datepicker
                                                v-model="listModel[0].dob"
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
                                                name="dob0"
                                                placeholder="1990 - 01 - 01"
                                                rules="required"
                                                selectText="Chọn"
                                            />
                                        </Field>
                                        <ErrorMessage class="error" name="dob0"/>
                                    </div>
                                </CRow>
<!--                                <CRow class="mb-3">-->
<!--                                    <CFormLabel class="col-sm-3 lbl-input" require>{{ this.data.dob }}</CFormLabel>-->
<!--                                    <div class="col-sm-6">-->
<!--                                        &lt;!&ndash; <datepicker&ndash;&gt;-->
<!--                                        &lt;!&ndash; v-model="model.dob" :closeOnAutoApply="false" :enableTimePicker="false" :maxDate="new Date()"&ndash;&gt;-->
<!--                                        &lt;!&ndash; :monthChangeOnScroll="false" autoApply border="3" cancelText="Đóng" format="yyyy-MM-dd"&ndash;&gt;-->
<!--                                        &lt;!&ndash; keepActionRow locale="vn" name="dob" placeholder="1990 - 01 - 01" rules="required" selectText="Chọn"&ndash;&gt;-->
<!--                                        &lt;!&ndash; />&ndash;&gt;-->
<!--                                        <Field name="dob0" v-model="listModel[0].dob" placeholder="XXXX-XX-XX"-->
<!--                                               class="form-control" rules="required|dob"/>-->
<!--                                        <span class="error" style="display: block;"-->
<!--                                              v-if="msg.err_dob">{{ msg.err_dob }}</span>-->
<!--                                        <ErrorMessage class="error" name="dob0"/>-->
<!--                                    </div>-->
<!--                                </CRow>-->
                                <!-- telephone0 -->
                                <CRow class="mb-3">
                                    <CFormLabel class="col-sm-3 lbl-input" require>{{ this.data.phoneNumber }}</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field placeholder="0XXXXXXXXX" name="telephone0" v-model="listModel[0].telephone"
                                               class="form-control" rules="required|phone_number"/>
                                        <span class="error" style="display: block;"
                                              v-if="msg.err_msg">{{ msg.err_msg }}</span>
                                        <ErrorMessage class="error" name="telephone0"/>
                                    </div>
                                </CRow>
                                <!-- email -->
                                <CRow class="mb-3">
                                    <CFormLabel class="col-sm-3 lbl-input" require>Email</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field placeholder="Email" name="email0" v-model="listModel[0].email"
                                               rules="required|email|max:255|unique_email|email_duplicate_fe" class="form-control"/>
                                        <ErrorMessage class="error" name="email0"/>
                                    </div>
                                </CRow>
                                <!-- pasword -->
                                <CRow class="mb-5">
                                    <CFormLabel class="col-sm-3 lbl-input" require>{{ this.data.password }}</CFormLabel>
                                    <div class="col-sm-6">
                                        <Field autocomplete="off" :placeholder="this.data.password" name="password0"
                                               v-model="listModel[0].password" rules="required|min:8|max:288"
                                               class="form-control" type="password"/>
                                        <ErrorMessage class="error" name="password0"/>
                                    </div>
                                </CRow>
                                <dynamicComp v-for="index in items.length" :key="index"
                                             @remove="removeInput(items, index)" :data="listModel[index]" :index="index"
                                                    :message="message[0]">
                                </dynamicComp>
                                <CCol :sm="12">
                                    <CButton class="fs-1" @click="addInput">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </CButton>
                                </CCol>
                            </CCardBody>
    <!--                            <vue-recaptcha ref="recaptcha" @verify="mxVerify" sitekey="6Ld2sPEiAAAAAGc1WVBWXDp_QLneySlmoQbkZRMV">-->
    <!--                            </vue-recaptcha>-->

                                <div style="background: lightblue;" class="col-md-12 text-center btn-box">
                                    <CButton type="submit" class="btn-primary btn-w-100">
                                        {{ this.data.SignIn }}
                                    </CButton>
                                    <a :href="data.urlBack" class="btn btn-default btn-w-100">
                                        {{ this.data.Back }}
                                    </a>
                                </div>

                        </div>
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
import dynamicComp from "../common/dynamicComp";
import Datepicker from "@vuepic/vue-datepicker";
// import "@vuepic/vue-datepicker/dist/main.css";
// import {VueRecaptcha} from 'vue-recaptcha';
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
            role_id: 1,
            csrfToken: Laravel.csrfToken,
            msg: [],
            items: [],
            recaptcha : null,
            message: [
                {
                    FullName : this.data.name,
                    Address : this.data.address,
                    Dob : this.data.dob,
                    PhoneNumber : this.data.phoneNumber,
                    Email : 'Email',
                    password : this.data.password,
                }
            ],
            listModel: [
                {
                    name: "",
                    address: "",
                    dob: "",
                    telephone: "",
                    email: "",
                    password: "",
                },
            ],

        };
    },
    props: ["data"],
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
        dynamicComp,
        Datepicker,
    },
    created() {

        let messError = {
            en: {
                fields: {
                    name0: {
                        required: this.data.nameBlank,
                        max: this.data.max255,
                    },
                    telephone0: {
                        required: this.data.requiredPhoneNumber,
                        phone_number: this.data.formatPhoneNumber,
                    },
                    address0: {
                        required: this.data.requiredAddress,
                        max: this.data.max255,
                    },
                    dob0: {
                        required: this.data.requiredDob,
                        dob: this.data.formatDob,
                    },
                    email0: {
                        required: this.data.requiredEmail,
                        email: this.data.formatEmail,
                        max: this.data.max255,
                        unique_email: this.data.uniqueEmail,
                        email_duplicate_fe : this.data.EmailEntered
                    },
                    password0: {
                        required: this.data.requiredPassword,
                        min: this.data.minPassword,
                        max: this.data.max255,
                    }
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });

        let that = this;
        defineRule('unique_email', (value) => {
            return axios
                .post(that.data.urlCheckMail, {
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
        defineRule("email_duplicate_fe", (value) => {
            let count = 0;
            for (let i = 0; i < that.listModel.length; i++) {
                if (that.listModel[i].email == value) {
                    count++;
                }
            }
            if (count > 1) {
                return false
            }
            return true;
        })
    },

    methods: {
        onInvalidSubmit({values, errors, results}) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
        },
        onSubmit() {
            this.flagShowLoader = true;
            this.$refs.formRegister.submit();
        },
        mxVerify(response) {
            this.recaptcha = response;
        },
        addInput() {
            this.listModel.push({
                name: '',
                address: '',
                dob: '',
                telephone: '',
                email: '',
                password: '',
            })
            // console.log(this.listModel.length);
            // console.log(this.items);
            this.items.push({
                componentName: "dynamic"
            })
        },
        removeInput(items, i) {
            this.listModel.splice(i, 1);
            items.splice(i - 1, 1);
        },
    },
    watch: {
        // 'model.telephone'() {
        //     if (!/\d/.test(this.model.telephone)) {
        //         this.msg["err_msg"] = this.data.onlyNumber;
        //     } else {
        //         this.msg["err_msg"] = "";
        //     }
        // },
        'listModel.length'() {
            let messError = {
                en: {
                    fields: {},
                }
            }
            for (let i = 0; i < this.listModel.length; i++) {
                messError.en.fields['name' + i] = {
                    required: this.data.nameBlank,
                    max: this.data.max255,
                }
                messError.en.fields["address" + i] = {
                    required: this.data.requiredAddress,
                    max: this.data.max255,
                }
                messError.en.fields["dob" + i] = {
                    required: this.data.requiredDob,
                    dob: this.data.formatDob,
                }
                messError.en.fields["telephone" + i] = {
                    required: this.data.requiredPhoneNumber,
                    phone_number: this.data.formatPhoneNumber,
                }
                messError.en.fields["email" + i] = {
                    required: this.data.requiredEmail,
                    email: this.data.formatEmail,
                    max: this.data.max255,
                    unique_email: this.data.uniqueEmail,
                    email_duplicate_fe : this.data.EmailEntered
                }
                messError.en.fields["password" + i] = {
                    required: this.data.requiredPassword,
                    min: this.data.minPassword,
                    max: this.data.max255,
                }
            }
            configure({
                generateMessage: localize(messError),
            });
        },
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
