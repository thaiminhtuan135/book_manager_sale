<template>
        <div class="comment-wrapper">
            <CommentAdd :urlStoreComment="this.urlStoreComment"/>
            <div v-for="comment in comments" :key="comment.id">
<!--                <Comment :comment="comment"/>-->
                <div class="d-flex justify-content-center mb-2">
                    <div class="chat-component">
                        <div class="flex flex-column w-full">

                            <div class="d-flex mt-2">
                                <p><i class="fa-solid fa-user-ninja image"></i></p>
                                <p class="user_name">{{comment.users.name}} :</p>
                            </div>
                            <div>
                                <p class="comment">{{comment.body}}</p>
                            </div>

                        </div>
                    </div>
                  </div>
            </div>

        </div>
</template>

<script>
import Comment from "./comment.vue"
import CommentAdd from "./commentAdd.vue"
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
    created() {
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
        configure({
            generateMessage: localize(messError),
        });
        let uri = window.location.href.split("/");
        this.book_id = uri[4];
        this.loadComments();
    },
    props: ['comments','data','urlStoreComment','urlGetComment'],
    components: {
        Loader,
        VeeForm,
        Field,
        ErrorMessage,
        UploadImages,
        Comment,
        CommentAdd
    },
    data() {
        return {
            comments: [],
            book_id : ''
        }
    },
    methods : {
        loadComments() {
            var postData = {
                book_id: this.book_id
            }
            axios
                .post(this.urlGetComment, postData)
                .then((res) => {
                    console.log(res.data.valid)
                    this.comments = res.data.valid
                }).catch(() => {
            });
        },
    }

}
</script>

<style scoped>
.comment{
    margin-left: 5px;
    color: white;
    background-color: blue;
    border-radius: 20px;
    padding: 0 10px 0 10px;
    width: fit-content;
}
.chat-component{
    height: auto;
    border: 3px solid lightskyblue;
    width: 75%;
    border-radius: 20px;
    padding: 0 10px 0 10px;
}
.w-full{
    width: 100%;
}
.user_name{
    font-weight: 700;
    margin-left: 30px;
}
.image{
    font-size: 30px;
}
</style>
