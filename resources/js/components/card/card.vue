<template>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label for="">Giỏ hàng</label>
                        </div>
                        <div class="card-body">
                            <div v-if="this.data.products">
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Sách</th>
                                        <th>Tác giả</th>
                                        <th>Số lượng</th>
                                        <th class="w-100"></th>
                                    </tr>
                                    </thead>
                                    <tbody v-for="product in this.data.products.data">
                                        <tr>
                                            <td><img :src="product.books.image" alt="" width="100" height="120"></td>
                                            <td>{{product.books.author}}</td>
                                            <td>{{product.amount }}</td>
                                            <td style="width: 110px;">
                                                <btn-delete-confirm
                                                    :message-confirm="'Bạn có chắc chắn muốn xóa ?'"
                                                    :delete-action="product.destroy_url">
                                                </btn-delete-confirm>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex pull-right">
                                    <stripe-checkout
                                        ref="checkoutRef"
                                        mode="payment"
                                        :pk="publishableKey"
                                        :sessionId="sessionId"
                                    />
                                    <a :href="this.data.urlBuy" class="pull-right btn btn-primary" style="margin-right: 20px;">Tiếp tục mua hàng</a>
                                    <button class="btn btn-primary" @click="submit">Thanh toán</button>
<!--                                    <button class="btn btn-success w-25 pull-right mb-2" style="margin-right: 20px;">Thanh toán</button>-->
<!--                                    <a :href="this.data.urlBuy" class="pull-right btn btn-primary" style="margin-right: 20px;">Tiếp tục mua hàng</a>-->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {StripeCheckout} from "@vue-stripe/vue-stripe";
import axios from "axios";

export default {
    props: ["data"],
    components : {
        StripeCheckout
    },
    data() {
        return {
            publishableKey : 'pk_test_51MCxVEJ9DfixT1i38pYhWHAYkqHlTaLiYWbS5rkPRF2TrfXEDRkmJsCaNsqa10HlV4KkYuxEUhvguLIyjhd1kXtl00k19kYXAd',
            sessionId : null,
            sessionSubId : null,
            items: [
                {  'tuan' : 'lala'}
            ],
        }
    },
    mounted() {
        console.log('componet mount');
        this.getSession();
    },
    methods: {
        getSession() {
            const data ={
                cards : this.data.products.data
            }
            axios
                .post('/getSession', data)
                .then( res => {
                    this.sessionId = res.data.oneTime.id;
                    this.sessionSubId = res.data.sub.id;
                }).catch(() => {});
        },
        submit () {
            this.$refs.checkoutRef.redirectToCheckout();
        },
    },
    created() {
    }
}
</script>

<style scoped>

</style>
