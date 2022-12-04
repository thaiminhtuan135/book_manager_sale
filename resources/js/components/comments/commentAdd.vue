<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-control">
                <textarea class="form-control" v-model="comment" placeholder="Thêm bình luận" name="comment">

                </textarea>
            </div>
            <div class="form-control mb-2">
                <button class="btn btn-primary" @click="saveNewComment">Bình luận</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    created() {
        let uri = window.location.href.split("/");
        this.book_id = uri[4];
    },
    props: ['urlStoreComment'],
    data() {
        return {
            comment: '',
            book_id: '',

        }
    },
    methods : {
        saveNewComment() {
            var postData = {
                comment: this.comment,
                book_id: this.book_id
            }
            axios
                .post(this.urlStoreComment, postData)
                .then((res) => {
                        this.comment = ''
                }).catch(() => {
            });
            // this.window.location.reload();
            location.reload();
        },
    }
}
</script>

<style scoped>

</style>
