<script>
import axios from 'axios';

export default {
    props: {
        post: Object
    },
    data() {
        return {
            post : this.post,
        }
    },
    methods: {
        like(id) {
            axios.get(route('posts.like', this.post.id))
                .then(response => {
                    this.post = response.data.post;
                    this.$emit('actioned', response.data.post);
                });
        }
    }
}
</script>
<template>
    <div class="timeline-footer">
        <a @click="like(post.id)" href="javascript:;" class="m-r-15 text-inverse-lighter"><i
                class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i>
            {{ post.is_liked ? $t('Unlike') : $t('Like') }}</a>
        <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i>
            {{ $t("Comment") }}</a>
        <!-- <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-share fa-fw fa-lg m-r-3"></i>
            Share</a> -->
    </div>
</template>