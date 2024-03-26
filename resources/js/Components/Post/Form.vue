<script>
import axios from 'axios';

export default {
    props: {
        post: Object
    },
    data() {
        return {
            content: this.post ? this.post.content : '',
            data: new FormData(),
        }
    },
    methods: {
        uploadImage() {
            this.data.append('image', event.target.files[0]);
        },
        submit() {
            this.data.append('content', this.content);

            axios.post(
                route('posts.store'),
                this.data,
            ).then(response => {
                this.$emit('newpost', response.data.post);
                this.content = "";
            })
        },
        cancelEdit() {
            this.$emit('cancelEdit');
        },
        submitEdit() {
            this.data.append('content', this.content);
            this.data.append('_method', "PUT");
            axios.post(
                route('posts.update', this.post.id),
                this.data,
            ).then(response => {
                console.log(response.data.post);
                this.$emit('postEdited', response.data.post);
            })
        }
    }
}

</script>
<template>
    <li>

        <div class="timeline-time">
            <!-- <span class="date">Today</span> -->
            <span class="time">{{ this.post ? $t('Edit Post') : $t('Add New Post') }}</span>
        </div>


        <div class="timeline-icon">
            <a href="javascript:;">&nbsp;</a>
        </div>


        <div class="timeline-body">
            <div class="timeline-header">
                <div>
                    <span class="userimage"><img :src="$page.props.auth.user.image"
                            :alt="$page.props.auth.user.name"></span>
                    <span class="username"><a href="javascript:;">{{ $page.props.auth.user.name }}</a>
                        <small></small></span>
                </div>
                <span class="input-group-btn p-l-10">
                    <button v-if="this.post" style="margin: 0px 10px;" @click="cancelEdit"
                        class="btn btn-danger f-s-12 rounded-corner">
                        {{ $t('Cancel') }}
                    </button>
                    <button v-if="this.post" @click="submitEdit()" class="btn btn-primary f-s-12 rounded-corner"
                        type="button">
                        {{ $t('Save Changes') }}
                    </button>
                    <button v-if="!this.post" @click="submit()" class="btn btn-primary f-s-12 rounded-corner"
                        type="button">
                        {{ $t('POST') }}
                    </button>
                </span>
            </div>
            <div class="timeline-content">
                <form @submit.prevent="submit()" enctype="multipart/form-data">
                    <textarea v-model="content" rows="5" placeholder="What's on your mind? ....."
                        class="form-control rounded-corner"></textarea>
                    <input type="file" @change="uploadImage($event)" accept="image/*" class="form-control"
                        style="margin-top:10px">
                </form>
            </div>

        </div>

    </li>
</template>