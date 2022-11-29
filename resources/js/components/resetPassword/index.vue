<template>
    <div class="container">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema" @invalid-submit="onInvalidSubmit">
                        <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore" ref="formLogin">
                            <input type="hidden" :value="csrfToken" name="_token" />
                            <div class="card">
                                <div class="card-body card-login">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 text-center title-login">
                                            <div class="row justify-content-center">
                                            </div>
                                            <h3>Đặt lại mật khẩu</h3>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <label for="" class="lbl-input mb1" require>Mã code</label>
                                                <Field name="code" placeholder="Code" rules="required|regex:^[a-zA-Z0-9]*$|max:6|min:6" v-model="model.code" type="text" class="form-control"/>
                                                <ErrorMessage class="error" name="code" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <label for="" class="lbl-input mb1" require>Password</label>
                                                <Field type="password" name="password" rules="required|max:16|min:8"
                                                       placeholder="this.data.password1" v-model="model.password" class="form-control"/>
                                                <ErrorMessage class="error" name="password" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <label for="" class="lbl-input mb1" require>Confirm password</label>
                                                <Field class="form-control" rules="required|confirmed:@password" type="password"
                                                       autocomplete="off" placeholder="Confirm password" name="password_old" v-model="model.password_old"/>
                                                <ErrorMessage class="error" name="password_old" />
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
                                            <button class="btn btn-primary px-4 btn-login" type="submit">Xác nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </VeeForm>
                </div>
            </div>
        </div>
        <loader :flag-show="flagShowLoader"></loader>
    </div>

</template>

<script>
import Loader from "../common/loader.vue";
import {Form as VeeForm, Field, ErrorMessage, defineRule, configure} from "vee-validate";
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
        let messError = {
            en: {
                fields: {
                    code: {
                        required: "Code bat buoc phai nhap",
                        regex : "khong co ky tu dc biet",
                        max : "Mã chỉ có 6 ký tự",
                        min : "Mã chỉ có 6 ký tự"
                    },
                    password : {
                        required: "Bat buoc phai nhap",
                        min : "Mật khẩu 8-16 ký tự",
                        max : "Mật khẩu 8-16 ký tự",
                    },
                    password_old : {
                        required: "bat buoc nhap",
                        confirmed : "Hai mat khau phai giong nhau"
                    }
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });

    },
    data() {
        return {
            flagShowLoader: false,
            model: {},
            csrfToken: Laravel.csrfToken,
            baseUrl: Laravel.baseUrl,
        };
    },
    props: ["data"],
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
    },
    methods: {
        onInvalidSubmit({ values, errors, results }) {
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
