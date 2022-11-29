<template>
    <div class="container-fluid">
        <div class="fade-in">
            <VeeForm as="div" v-slot="{ handleSubmit }" :validation-schema="schema" @invalid-submit="onInvalidSubmit">
                <form method="POST" @submit="handleSubmit($event, onSubmit)" action="/login" ref="formLogin">
                    <input type="hidden" :value="csrfToken" name="_token"/>
                    <div class="form-group">
                        <Field name="email" placeholder="Email" v-model="model.email" type="text" class="form-control" require/>
                        <ErrorMessage class="error" name="email" />
                    </div>
                </form>
            </VeeForm>
        </div>
    </div>
</template>

<script>
import * as rules from "@vee-validate/rules";
import {configure, defineRule, ErrorMessage, Field, Form as VeeForm} from "vee-validate";
import {localize} from "@vee-validate/i18n";
import Loader from "../common/loader";

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
                    email: {
                        required: "âccacacac",
                        email: "asddsa",
                        max: "adssa",
                    },
                    password : {
                        required: "dasda",
                        min : "das",
                        max : "dasdsd",
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
            model: {
                // email: this.data.request.email,
            },
            csrfToken: Laravel.csrfToken,
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
}
</script>

<style scoped>

</style>
