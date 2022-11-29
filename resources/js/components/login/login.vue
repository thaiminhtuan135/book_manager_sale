<template>
    <div class="container">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema"
                             @invalid-submit="onInvalidSubmit">
                        <form method="POST" @submit="handleSubmit($event, onSubmit)" action="/login" ref="formLogin">
                            <input type="hidden" :value="csrfToken" name="_token"/>
                            <!--              <input type="hidden" :value="data.request.url_redirect" name="url_redirect"/>-->
                            <div class="card" style="background: lightblue;">
                                <div class="card-body card-login">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 text-center title-login">
                                            <div class="row justify-content-center">
                                            </div>
                                            <h3>{{ this.data.login }}</h3>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <Field name="email" placeholder="Email" v-model="model.email"
                                                       type="text" class="form-control"/>
                                                <ErrorMessage class="error" name="email"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <Field class="form-control" type="password" autocomplete="off"
                                                       :placeholder="this.data.password1" name="password"
                                                       v-model="model.password"/>
                                                <ErrorMessage class="error" name="password"/>
                                            </div>
                                            <div class="pull-right mt-2">
                                                <!--                            <CLink href="/forgot_password">Quên mật khẩu</CLink>-->
                                                <a style="font-size: 20px;" href="/forgot_password">Quên mật khẩu</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="error text-center" role="alert" v-if="data.message">
                                            {{ this.data.message }}
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 p-l-20">
                                            <button class="btn btn-primary px-4 btn-login" style="border-radius: 30px"
                                                    type="submit">{{ this.data.login }}
                                            </button>
                                            <a class="btn btn-secondary px-4 btn-login" style="border-radius: 30px"
                                               :href="this.data.urlBack">
                                                <div>{{ this.data.backHome }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </VeeForm>
                </div>
            </div>
            <loader :flag-show="flagShowLoader"></loader>
        </div>
    </div>
</template>

<script>
import Loader from "../common/loader.vue";
import {Form as VeeForm, Field, ErrorMessage, defineRule, configure} from "vee-validate";
import * as Yup from "yup";
import * as rules from "@vee-validate/rules";
import {localize} from "@vee-validate/i18n";

export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    created() {
        // let messError = {
        //     en: {
        //         fields: {
        //             email: {
        //                 required: "adsdadad",
        //                 email: "asddsa",
        //                 max: "adssa",
        //             },
        //             password : {
        //                 required: "dasda",
        //                 min : "das",
        //                 max : "dasdsd",
        //             }
        //         },
        //     },
        // };
        // configure({
        //     generateMessage: localize(messError),
        // });
        this.schema = Yup.object().shape({
            email: Yup.string()
                .required(this.data.requiredEmail)
                .email(this.data.formatEmail),
            password: Yup.string()
                .min(8, this.data.minPassword)
                .required(this.data.requiredPassword),
        });

    },
    data() {
        return {
            flagShowLoader: false,
            model: {
                // email: this.data.request.email,
            },
            schema: Yup.object(),
            csrfToken: Laravel.csrfToken,
            baseUrl: Laravel.baseUrl,
        };
    },
    mounted() {
    },
    props: ["data"],
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
    },
    methods: {
        onInvalidSubmit({values, errors, results}) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
        },
        onSubmit() {
            this.flagShowLoader = true;
            this.$refs.formLogin.submit();
        },
    },
};
</script>
