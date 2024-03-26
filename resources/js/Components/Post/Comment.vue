<script>
import axios from 'axios';

export default {
    props: {
        post: Object
    },
    data() {
        return {
            post: this.post,
            comment: '',
            comment_ids: [],
            showDeleteCheck: false
        }
    },
    methods: {
        submitComment(id) {
            if (!this.comment) alert("please enter comment");
            axios.post(route('posts.comment', id), { comment: this.comment, csrf_token: this.post.csrf_token })
                .then(response => {
                    this.post = response.data.post;
                    this.$emit('actioned', response.data.post);
                    this.comment = "";
                });
        },
        showDeleteChecks() {
            this.showDeleteCheck = !this.showDeleteCheck;
        },
        deleteComments(id) {
            axios.post(route('posts.delete_comments', id), { comment_ids: this.comment_ids })
                .then(response => {
                    this.post = response.data.post;
                    this.$emit('actioned', response.data.post);
                    this.showDeleteCheck = false;
                });
        },
        checkIfAuthed() {
            if (!this.$page.props.auth.user) {
                this.comment = "";
                window.location.href = "/login";
            }

        }
    }
}
</script>
<template>
    <div class="timeline-comment-box">
        <div v-if="$page.props.auth.user" class="user">
            <img :src="$page.props.auth.user.image">
        </div>
        <div class="input">
            <form @submit.prevent="submitComment(post.id)">
                <div class="input-group">
                    <input @focus="checkIfAuthed" v-model="comment" type="text" class="form-control rounded-corner"
                        :placeholder="$t('Write a comment') + '...'">
                    <span class="input-group-btn p-l-10">
                        <button @click="submitComment(post.id)" class="btn btn-primary f-s-12 rounded-corner"
                            type="button">{{ $t("Comment") }}</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div v-if="post.comments_count" style="margin: 10px;display: flex;justify-content: space-between;">
        <b>{{ $t("Comments") }}</b>
        <a href="javascript:;" @click="showDeleteChecks()">
            {{ showDeleteCheck ? $t('Cancel Delete') : $t('Delete Comment') }}
        </a>
        <a v-if="showDeleteCheck" href="javascript:;" @click="deleteComments(post.id)">{{ $t("Delete Checked Comment")
            }}</a>
    </div>
    <div class="timeline-comments" v-if="post.comments_count">
        <div class="comment" v-for="comment in post.comments">
            <div class="user">
                <span class="userimage">
                    <input v-if="showDeleteCheck" type="checkbox" v-model="comment_ids" :value="comment.id">
                    <img :src="comment.user.image" :alt="comment.user.name">
                </span>
            </div>
            <span class="pull-right text-muted">
                <span class="username">
                    <a href="javascript:;">{{ comment.user.name }}</a>
                    <small>{{ comment.created_at }}</small>
                </span>
                <p>{{ comment.comment }}</p>
            </span>
        </div>
    </div>
</template>