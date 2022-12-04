<template>
    <swiper
        :effect="'coverflow'"
        :grabCursor="true"
        :centeredSlides="true"
        :slidesPerView="5"
        :coverflowEffect="{
      rotate: 50,
      stretch: 1,
      depth: 100,
      modifier: 2,
      slideShadows: true,
    }"
        :pagination="{
      dynamicBullets: true,
    }"
        :modules="modules"
        class="mySwiper "
        style="width: 50%;"
    >
        <swiper-slide v-for="(img,index) in image">
            <div class="computer__img">
                    <div class="mb-4">
                        <img :src="img.srcImg" alt="" width="250" height="300">
                    </div>
            </div>
        </swiper-slide>
    </swiper>
</template>

<script>
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure,
} from "vee-validate";
import {Swiper, SwiperSlide} from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/effect-coverflow";
import { EffectCoverflow, Pagination } from "swiper";
import Loader from "../common/loader";
export default {
    setup() {
        const onSwiper = (swiper) => {
        };
        const onSlideChange = () => {
        };

        return {
            onSwiper,
            onSlideChange,
            modules: [EffectCoverflow,Pagination],
        };
    },
    components: {
        VeeForm,
        Field,
        ErrorMessage,
        Loader,
        Swiper,
        SwiperSlide,
    },
    data: function () {

        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            image : [

                // {srcImg: '/imgBook/3d2731bd3495a3a3b4abce1ba2ada02e.jpg',},
                // {srcImg: '/imgBook/08de03b47ec07fb8548fb0b695c718618b0f6824.png',},
                // {srcImg: '/imgBook/4290c1e59ec75153fe85120d53d7a413b549b4d4.jpg',},
                // {srcImg: '/imgBook/350577c42a783441a8a69226c9cb1db74a78033b.jpg',},
                // {srcImg: '/imgBook/704089ee55cf911e735b4f4562569c21ce4cc8db.jpg',},
                // {srcImg: '/imgBook/709097a62475a3bd396dd876306ae7f088c6fea9.png',},
                // {srcImg: '/imgBook/b7c89d25cfacc56cdf700ade8fe3f5366106ea3d.jpg',},
                // {srcImg: '/imgBook/bia1s.png',},
                {srcImg: '/imgBook/Bí-mật-tư-duy-triệu-phú-sách-dạy-làm-giàu-compressor.jpg',},
                {srcImg: '/imgBook/cuon-sach-hay-ve-ky-nang-song-dac-nhan-tam.jpg',},
                {srcImg: '/imgBook/Hành-trình-về-phương-đông.jpg',},
                {srcImg: '/imgBook/huan-hoa-hong-15879586607891232678525.jpg',},
                {srcImg: '/imgBook/image_241801.jpg',},
                {srcImg: '/imgBook/img181_2_5.jpg',},
                {srcImg: '/imgBook/kham-pha-the-gioi-tam-linh.png',},
                {srcImg: '/imgBook/Kinh-te-1.jpg',},
                {srcImg: '/imgBook/kinh-te-hoc-vi-mo-1616404088_1__3e4955887b2d408abfade01fb87f807f.webp',},
                {srcImg: '/imgBook/kinh-te-hoc-vi-mo-1616404088_1__3e4955887b2d408abfade01fb87f807f (1).jpg',},
                {srcImg: '/imgBook/lMJgYgdUlarge.jpg',},
                {srcImg: '/imgBook/loi-thu-toi-moi-cua-mot-sat-thu-kinh-te-761353.jpg',},
                {srcImg: '/imgBook/quan_ly_rui_ro_kinh_doanh_38352da773.jpg',},
                {srcImg: '/imgBook/quantrihocpng.png',},
                {srcImg: '/imgBook/sach-cach-nen-kinh-te-van-hanh.jpg',},
                {srcImg: '/imgBook/sach-kheo-an-noi-se-co-duoc-thien-ha-209x300.jpg',},
                {srcImg: '/imgBook/Sach-phap-luat-dai-cuong-dung-trong-cac-truong-dai-hoc-cao-dang-trung-cap.jpg',},
                {srcImg: '/imgBook/sach-thanh-pho-thong-minh-nen-tang-nguyen-ly-203x300.png',},
                {srcImg: '/imgBook/scan00351.jpg',},
                {srcImg: '/imgBook/tải xuống.jpg',},
                {srcImg: '/imgBook/u10836_t1409798085_8GcK8.jpg',},
                {srcImg: '/imgBook/upload_2021-8-4_21-15-37.png',},
            ]
        };
    },
}
</script>

<style scoped>

</style>
