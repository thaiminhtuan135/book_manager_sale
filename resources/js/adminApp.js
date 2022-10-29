// require('./bootstrap');
import { createApp } from "vue";
import CoreuiVue from "@coreui/vue";
import { configure, defineRule } from "vee-validate";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
configure({
    validateOnBlur: false,
    validateOnChange: false,
    validateOnInput: true,
    validateOnModelUpdate: false,
});
const app = createApp({});
app.use(CoreuiVue);
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
app.use(VueSweetalert2);

defineRule('code', value => {
    return /^[A-Za-z0-9]*$/i.test(value);
});

defineRule('phone_number', value => {
    return /^0(\d{9})+$/i.test(value.trim());
});
defineRule('dob', value => {
    return /^(\d{4}-\d{2}-\d{2})+$/i.test(value.trim());
});


import Test from "./components/test.vue";
import BtnDeleteConfirm from "./components/common/btnDeleteConfirm.vue";
import DataEmpty from "./components/common/dataEmpty.vue";
import PopupAlert from "./components/common/popupAlert.vue";
import LimitPageOption from "./components/common/limitPageOption.vue";
import CompanyCreate from "./components/company/create.vue";
import CompanyEdit from "./components/company/edit.vue";
import Login from "./components/login/login.vue";
import Register from "./components/login/register.vue"
import BookCreate from "./components/book/create.vue";
import BookEdit from "./components/book/edit.vue";
app.component("test", Test);
app.component("btn-delete-confirm", BtnDeleteConfirm);
app.component("data-empty", DataEmpty);
app.component("popup-alert", PopupAlert);
app.component("limit-page-option", LimitPageOption);
app.component("company-create", CompanyCreate);
app.component("company-edit", CompanyEdit);
app.component("login", Login);
app.component("register", Register);
app.component("book-create", BookCreate);
app.component("book-edit", BookEdit);




app.mount("#app");
