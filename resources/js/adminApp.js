// require('./bootstrap');
import {createapp} from "vue";
import coreuivue from "@coreui/vue";
import {configure, definerule} from "vee-validate";
import datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import {fontawesomeicon} from "@fortawesome/vue-fontawesome";
// window.vue = require('vue')
// window.eventbus = new vue({});
configure({
    validateonblur: false,
    validateonchange: false,
    validateoninput: true,
    validateonmodelupdate: false,
});

const app = createapp({});
app.use(coreuivue);
app.use(commentgrid);
import vuesweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

app.use(vuesweetalert2);

definerule('code', value => {
    return /^[a-za-z0-9]*$/i.test(value);
});
definerule('number', value => {
    return /^[0-9]*$/i.test(value);
});
definerule('phone_number', value => {
    return /^0(\d{9})+$/i.test(value.trim());
});
definerule('dob', value => {
    return /^(\d{4}-\d{2}-\d{2})+$/i.test(value.trim());
});

import commentgrid from 'vue-comment-grid'
import test from "./components/test.vue";
import btndeleteconfirm from "./components/common/btndeleteconfirm.vue";
import dataempty from "./components/common/dataempty.vue";
import popupalert from "./components/common/popupalert.vue";
// import limitpageoption from "./components/common/limitpageoption.vue";
import companycreate from "./components/company/create.vue";
import companyedit from "./components/company/edit.vue";
import login from "./components/login/login.vue";
import register from "./components/login/register.vue"
import bookcreate from "./components/book/create.vue";
import bookedit from "./components/book/edit.vue";
import bookexport from "./components/book/export.vue";
import forgotpassword from "./components/forgotpassword/index.vue";
import resetpassword from "./components/resetpassword/index.vue";
import swiperslide from "./components/common/swiper.vue"
import bookdetail from "./components/product/book_detail.vue"
import product from "./components/product/product.vue"
import card from "./components/card/card.vue"

import fakelogin from "./components/login/fakelogin.vue";
import fakelogin from "./components/login/fakelogin";
import {vuerecaptcha} from "vue-recaptcha";
// import vue from "laravel-mix/src/components/vue";
import stripe from "./components/stripe/index.vue"

app.component("test", test);
app.component("btn-delete-confirm", btndeleteconfirm);
app.component("data-empty", dataempty);
app.component("popup-alert", popupalert);
// app.component("limit-page-option", limitpageoption);
app.component("company-create", companycreate);
app.component("company-edit", companyedit);
app.component("login", login);
app.component("register", register);
app.component("book-create", bookcreate);
app.component("book-edit", bookedit);
app.component("book-export", bookexport);
app.component("fake-login", fakelogin);
app.component('vue-recaptcha', vuerecaptcha)
app.component('forgot-password', forgotpassword)
app.component('reset-password', resetpassword)
app.component('swiper-slide', swiperslide)
app.component('book-detail', bookdetail)
app.component('comment-grid', commentgrid)
app.component('stripe', stripe)
app.component('product', product)
app.component('card', card)


app.mount("#app");
