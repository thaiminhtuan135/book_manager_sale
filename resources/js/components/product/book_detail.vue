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
                    <div style="margin-left:300px;" class="d-flex flex-column">
                        <img :src="filePreviewWeb" alt="" width="600" height="500" style="float: right">
                        <div class="d-flex justify-content-center">
                            <div class="stars">
                                <input class="star star-5" id="star-5" type="radio" name="star"/>
                                <label @click="click5" class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="star"/>
                                <label @click="click4" class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="star"/>
                                <label @click="click3" class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="star"/>
                                <label @click="click2" class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="star"/>
                                <label @click="click1" class="star star-1" for="star-1"></label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn star-width" :class="this.activeClass">{{this.message}}</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mt-2 book-title" >Tên sách: {{ model.title }}</div>
                    <div class="mt-2 book-author">Tên tác giả: {{ model.author }}</div>
                    <div class="mt-2" >
                        <a class="btn btn-primary ml-100" @click="changeStatus"><i style="margin-right: 4px;" class="fa-regular fa-thumbs-up"></i>Thích {{status}}</a>
                        <a class="btn btn-primary" style="margin-left: 20px;">Chia sẻ</a>
                    </div>

                    <div class="mt-2" style="margin-left: 100px; font-size: 20px;">Tình trạng : Còn hàng </div>
                    <label class="book-author" for="amount">Số lượng</label>
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
import StarRating from "vue-dynamic-star-rating";
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
        StarRating

    },
    computed: {},
    props: ["data"],
    data: function () {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: this.data.book,
            star: 0,
            filePreviewWeb: "",
            status: 0,
            amount: "",
            urlStoreComment: this.data.urlStoreComment,
            urlGetComments: this.data.urlGetComments,
            message: '',
            activeClass: '',

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
        click1() {
            this.message = 'Tôi ghét nó';
            this.activeClass = 'btn-hate';
            this.star = 1;
            this.evaluate();
        },
        click2() {
            this.message = 'Tôi không thích nó';
            this.activeClass = 'btn-warning';
            this.star = 2;
            this.evaluate();

        },
        click3() {
            this.message = 'Nó ổn';
            this.activeClass = 'btn-danger';
            this.star = 3;
            this.evaluate();


        },
        click4() {
            this.message = 'Tối thích nó';
            this.activeClass = 'btn-primary';
            this.star = 4;
            this.evaluate();
        },
        click5() {
            this.message = 'Tôi yêu nó';
            this.activeClass = 'i-love-it';
            this.star = 5;
            this.evaluate();

        },
        evaluate() {
            console.log(this.star);
            const data = {
                star: this.star,
                book_id: this.model.id,

            }
            axios
                .post(this.data.urlEvaluate, data)
                .then((res) => {
                    console.log(res);
                    console.log(res.data)

                }).catch(() => {
            });
        },
    }

}
</script>

<style scoped>
.amount{
    margin-left: 100px;
}
.container{
    width: 400px;
    /*background: #111;*/
    padding: 20px 30px;
    border: 1px solid #444;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.star-widget input{
    display: none;
}

body{
    background-color: #eee;
}

div.stars {

    width: 270px;

    display: inline-block;

}

.mt-200{
    margin-top:200px;
}

input.star { display: none; }



label.star {
    float: right;
    padding: 10px;
    font-size: 36px;
    color: #4A148C;
    transition: all .2s;
}

input.star:checked ~ label.star:before {
    content: '\f005';
    color: #FD4;
    transition: all .25s;
}
input.star-5:checked ~ label.star:before {
    color: #FE7;
    text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }



label.star:hover { transform: rotate(-15deg) scale(1.3); }



label.star:before {

    content: '\f006';

    font-family: FontAwesome;

}
.btn-hate{
    background-color: #C0C0C0;
}
.star-width{
    width: 50%;
}
.i-love-it{
    background-color: hotpink;
}
.book-title{
    margin-left: 100px;
    font-size: 30px;
}
.book-author{
    margin-left: 100px;
    font-size: 20px;
}
.ml-100{
    margin-left: 100px
}
</style>
