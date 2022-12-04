<template>
    <CCard>
        <VeeForm
            as="div"
            v-slot="{ handleSubmit }"
            @invalid-submit="onInvalidSubmit"
        >
            <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.urlStore"
                ref="formData"
                enctype="multipart/form-data"
            >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field name="book_id" v-model="model.id" class="hidden"/>
        <CCardHeader>
        </CCardHeader>
        <CCardBody>
            <div class="d-flex">
                <div>
                    <div style="margin-left:300px;">
                        <img :src="filePreviewWeb" alt="" width="600" height="500" style="float: right">
                    </div>
                </div>
                <div>
                    <div class="mt-2" style="margin-left: 100px; font-size: 30px;">Tên sách: {{ model.title }}</div>
                    <div class="mt-2" style="margin-left: 100px; font-size: 20px;">Tên tác giả: {{ model.author }}</div>
                    <div class="mt-2" >
                        <a class="btn btn-primary" style="margin-left: 100px;" @click="changeStatus"><i style="margin-right: 4px;" class="fa-regular fa-thumbs-up"></i>Thích {{status}}</a>
                        <a class="btn btn-primary" style="margin-left: 20px;">Chia sẻ</a>
                    </div>

                    <div class="mt-2" style="margin-left: 100px; font-size: 20px;">Tình trạng : Còn hàng </div>
                    <label style="margin-left: 100px;font-size: 20px;" for="amount">Số lượng</label>
                    <Field  class="form-control amount mt-2" v-model="amount" id="amount" rules="required|amount|number" name="amount"/>
                    <div>
                        <ErrorMessage style="margin-left: 100px" class="error" name="amount"/>
                    </div>
                    <button type="submit" style="margin-left: 100px;" class="mt-3 btn btn btn-success">Thêm giỏ hàng</button>
                </div>
            </div>
        </CCardBody>
        <CCardFooter>
        </CCardFooter>
            </form>
        </VeeForm>
        <div>
            <CommentWrapper
                :comments="this.data.comments"
                :urlStoreComment="this.urlStoreComment"
                :urlGetComment="this.urlGetComments"
            />
        </div>
    </CCard>
</template>

<script>
import CommentWrapper from "../comments/commentWrapper";
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
import Toggle from "@vueform/toggle";
import Datepicker from "@vuepic/vue-datepicker";
import axios from "axios";
import Loader from "../common/loader";
import UploadImages from "vue-upload-drop-images";
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
        Datepicker,
        UploadImages,
        CommentWrapper,

    },
    computed: {},
    props: ["data"],
    data: function () {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: this.data.book,
            filePreviewWeb: "",
            status: 0,
            amount: "",
            urlStoreComment: this.data.urlStoreComment,
            urlGetComments: this.data.urlGetComments,


        };
    },
    created() {
        this.filePreviewWeb = this.data.book.image ? this.data.book.image : "";
        let messError = {
            en: {
                fields: {
                    amount: {
                        required: "Số lượng không được để trống",
                        amount : "không được nhập số âm",
                        number : "Chỉ được nhập số"
                    },
                },
            },
        };
        defineRule("amount", (value) => {
            if (value < 0) {
                return false
            }
            return true;
        })
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
        changeStatus() {
            if (this.status == 0) {
                this.status = 1;
            }
            else{
                this.status = 0;
            }
        },
    }


}
</script>

<style scoped>
.amount{
    margin-left: 100px;
}
</style>
