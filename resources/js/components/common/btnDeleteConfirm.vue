<template>
<div>
  <a class="btn btn-danger" @click="showAlert" style="cursor: pointer">
    <i class="fa fa-trash" aria-hidden="true"></i>
    {{this.data.Delete}}
  </a>
  <loader :flag-show="flagShowLoader"></loader>
</div>
</template>

<script>
import Loader from "./loader.vue"
import axios from "axios";
import $ from 'jquery'

export default {
  data() {
    return {
      flagShowLoader: false,
        cancel : this.data.Cancel,
    }
  },
  components: {
    Loader
  },
  props: ['deleteAction', 'listUrl', 'messageConfirm','data'],
  mounted() {},
  methods: {
    showAlert() {
      let that = this;
      this.$swal({
        title: that.messageConfirm,
        icon: "warning",
        confirmButtonText: this.data.yes,
        cancelButtonText: this.data.no,
        showCancelButton: true
      }).then(result => {
        if (result.value) {
          that.flagShowLoader = true;
          $('.loading-div').removeClass('hidden');
          axios.delete(that.deleteAction, {
              _token: Laravel.csrfToken
            })
            .then(function (response) {
              that.flagShowLoader = false;
              $('.loading-div').addClass('hidden');
              that.$swal(
                {
                  title: response.data.message,
                  icon: "success",
                  confirmButtonText: "Đóng"
                })
                .then(function () {
                  //   window.location.href = that.listUrl;
                  location.reload();
                });
            })
            .catch(error => {
              that.flagShowLoader = false;
            });
        }
        else {
            this.$swal("Your item is safe!");
        }
      });
    }
  }
};
</script>
