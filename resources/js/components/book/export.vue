<template>
    <div>
        <button type="button" @click="exportBook" class="btn btn-primary" style="background-color: darkgreen">
            <i class="fa fa-download"></i>{{title}} CSV
        </button>
        <a :href="link" ref="linkDownLoad" id="linkCsv" download></a>
        <form id="formExport" class="hidden">
            <input type="hidden" :value="csrfToken" name="_token">
            <input
                type="hidden"
                v-for="item in input"
                :key="item.key"
                :name="item.key"
                :value="item.value"
            />
        </form>
        <loader :flag-show="flagShowLoader"></loader>
    </div>
</template>

<script>
import $ from "jquery";
import Loader from "../common/loader";
import axios from "axios";

export default {
    props: ["data"],
    mounted() {
        for (let [key, value] of Object.entries(this.data.request)) {
            this.input.push({
                key: key,
                value: value ?? "",
            });
        }
    },
    data() {
        return {
            link: '',
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            input: [],
            title : this.data.message,
        };
    },
    components: {
        Loader,
    },
    methods: {
        exportBook() {
            let that = this;
            this.flagShowLoader = true;
            console.log(that.data.url);
            axios
                .post(that.data.url, $("#formExport").serialize())
                .then((res) => {
                    this.link = res.data.path;
                    console.log(this.link)
                    window.setTimeout(function () {
                        that.$refs["linkDownLoad"].click();
                        that.flagShowLoader = false;
                    }, 1000);

                })
                .catch((error) => {});
        },
    },
}
</script>

