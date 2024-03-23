<script>
import Actions from './Actions.vue';
import Comment from './Comment.vue';
import EditPost from './Form.vue';
export default {
    props: {
        post: Object
    },
    data() {
        return {
            post: this.post,
            showCommentBox: false,
            editClicked: false,
            showPost : true
        }
    },
    components: {
        Actions,
        Comment,
        EditPost
    },
    methods: {
        refreshData(val) {
            this.post = val;
        },
        editPost(val) {
            console.log(val, 111111);
            this.post = val;
            this.editClicked = false;
        },
        removePost(post) {
            var t = confirm("Are you sure you want to delete this post?");
            if (!t) return;
            axios.delete(route('posts.destroy', post.id))
                .then(response => {
                    this.showPost = false;
                })
        }
    }
}

</script>
<template>
    <EditPost v-if="editClicked" :post="post" @cancelEdit="editClicked = false" @postEdited="editPost"></EditPost>
    <li v-if="showPost && !editClicked">

        <div class="timeline-time">
            <!-- <span class="date">Today</span> -->
            <span class="time">{{ this.post.created_at }}</span>
        </div>


        <div class="timeline-icon">
            <a href="javascript:;">&nbsp;</a>
        </div>


        <div class="timeline-body">
            <div class="timeline-header">
                <div>
                    <span class="userimage"><img :src="this.post.user.image" :alt="this.post.user.name"></span>
                    <span class="username"><a href="javascript:;">{{ this.post.user.name }}</a>
                        <small></small></span>
                    <span class="pull-right text-muted" v-if="post.views">{{ post.views }} Views</span>
                </div>
                <div class="actions" v-if="post.user.id == $page.props.auth.user.id">
                    <a @click="editClicked = true" href="javascript:;">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <a class="remove" href="javascript:;" @click="removePost(post)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="timeline-content">
                <p class="lead">
                    <i class="fa fa-quote-left fa-fw pull-left"></i>
                    {{ post.content }}
                    <i class="fa fa-quote-right fa-fw pull-right"></i>
                </p>
                <div class="imgs" v-for="img in post.attachments">
                    <img :src="img.path">
                </div>

            </div>
            <div class="timeline-likes">
                <div class="stats-right">
                    <!-- <span class="stats-text">{{ post.shares }} Shares</span> -->
                    <span class="stats-text">{{ post.comments_count }} Comments</span>
                </div>
                <div class="stats">
                    <span class="fa-stack fa-fw stats-icon">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="stats-total">{{ post.likes }}</span>
                </div>
            </div>

            <Actions :post="this.post" @actioned="refreshData"></Actions>

            <Comment :post="this.post"></Comment>
        </div>

    </li>
</template>