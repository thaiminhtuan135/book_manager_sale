<template>
    <div class="container">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema" @invalid-submit="onInvalidSubmit">
                        <form method="POST" @submit="handleSubmit($event, onSubmit)" :action="data.urlStore" ref="formLogin">
                            <input type="hidden" :value="csrfToken" name="_token" />
                            <!--              <input type="hidden" :value="data.request.url_redirect" name="url_redirect"/>-->
                            <div class="card">
                                <div class="card-body card-login">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 text-center title-login">
                                            <div class="row justify-content-center">
                                            </div>
<!--                                            <h3>{{ this.data.login }}</h3>-->
                                            <h1>Đặt lại mật khẩu</h1>
                                            <p>Mã đặt lại sẽ được gửi đến email đăng ký của bạn</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 mb-3">
                                            <div class="form-group">
                                                <label for="" class="lbl-input mb-2" require>Địa chỉ Email</label>
                                                <Field name="email" placeholder="Email" v-model="model.email" type="text" class="form-control"/>
                                                <ErrorMessage class="error" name="email" />
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
                                            <button class="btn btn-primary px-4 btn-login" type="submit">Gửi</button>
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
import { Form as VeeForm, Field, ErrorMessage } from "vee-validate";
import * as Yup from "yup";

export default {
    created: function () {
        this.schema = Yup.object().shape({
            email: Yup.string()
                .required("Email không được để trống")
                .email("Email chưa đúng định dạng"),
        });
    },
    data() {
        return {
            flagShowLoader: false,
            model: {
                email: this.data.request.email,
            },
            csrfToken: Laravel.csrfToken,
            baseUrl: Laravel.baseUrl,
            schema: Yup.object(),
        };
    },
    mounted() {},
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
