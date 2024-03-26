<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PostBox from '../Components/Post/Box.vue';
import AddPost from '../Components/Post/Form.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    props: {
        posts: Object,
        post: Object
    },
    data() {
        return {
            page: 1,
            posts: this.posts,
            post: ''
        }
    },
    components: {
        AppLayout,
        PostBox,
        Head,
        AddPost
    },
    mounted() {
        // when scroll bottom load more posts
        window.onscroll = () => {
            let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight >= document.documentElement.offsetHeight - 50;
            if (bottomOfWindow) {
                this.loadMore();
            }
        }
    },
    methods: {
        loadMore() {
            setTimeout(() => {
                axios.get('/posts?page=' + ++this.page)
                    .then(response => {
                        // append new posts to old posts
                        this.posts.data = this.posts.data.concat(response.data.posts);
                    });
            });
        },
        addNewPosts(newpost) {
            this.posts.data.unshift(newpost);
        }
    }
}
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Timeline</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="profile-content">

                    <div class="tab-content p-0">

                        <div class="tab-pane fade active show" id="profile-post">

                            <ul class="timeline">
                                <AddPost v-if="$page.props.auth.user" @newpost="addNewPosts"></AddPost>
                                <PostBox v-for="post in posts.data" :key="post.id" :post="post">
                                </PostBox>
                                <!-- <li v-for="post in this.posts.data">{{  post.content  }}</li> -->
                            </ul>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
