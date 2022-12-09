<template>
    <div>
    <stripe-checkout
        ref="checkoutRef"
        mode="payment"
        :pk="publishableKey"
        :sessionId="sessionId"
    />
    <button class="btn btn-primary" @click="submit">Pay now!</button>
<!--    <stripe-checkout-->
<!--        ref="checkoutSubRef"-->
<!--        :pk="publishableKey"-->
<!--        :sessionId="sessionSubId"-->
<!--        mode="subscription"-->

<!--    />-->
<!--    <button class="btn btn-primary" @click="submitSub">Subscription</button>-->
    </div>
</template>

<script>
import axios from "axios";
import {StripeCheckout} from "@vue-stripe/vue-stripe";
export default {
    components : {
        StripeCheckout
    },
    props: ["data"],
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
    created() {

    },
    mounted() {
        console.log('componet mount');
        this.getSession();
    },
    methods: {
        getSession() {
            axios
                .get('/getSession')
                .then( res => {
                    console.log(res)
                    this.sessionId = res.data.oneTime.id;
                    this.sessionSubId = res.data.sub.id;
                    // console.log()
                    // console.log(this.sessionId);
                }).catch(() => {});
        },
        submit () {
            // You will be redirected to Stripe's secure checkout page
            this.$refs.checkoutRef.redirectToCheckout();
        },
        // submitSub () {
        //     // You will be redirected to Stripe's secure checkout page
        //     this.$refs.checkoutSubRef.redirectToCheckout();
        // },
    },
}
</script>

<style scoped>

</style>
