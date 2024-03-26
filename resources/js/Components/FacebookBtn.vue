<template>
    <div class="facebook-btn">
        <a href="javascript:;" class="btn btn-primary" @click="logInWithFacebook">
            <span>Sign in with Facebook</span>
        </a>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'FacebookBtn',
    mounted() {
        this.loadFacebookSDK(document, 'script', 'facebook-jssdk')
        this.initFacebook()
        if (this.$store.state.auth.redirect) {
            localStorage.setItem('redirect', this.$store.state.auth.redirect)
        }
        window.SocialLogin = this.SocialLogin
    },
    methods: {
        logInWithFacebook() {
            var vm = this;
            window.FB.login(function (response) {
                if (response.authResponse) {
                    // Now you can redirect the user or do an AJAX request 
                    // here I sent authResponse From Facebook to My Request API
                    vm.SocialLogin(response.authResponse)
                } else {
                    console.log('User cancelled login or did not fully authorize.')
                }
            })
            return false
        },
        initFacebook() {
            window.fbAsyncInit = function () {
                window.FB.init({
                    appId: '765823162168291', //App ID, You will need to change this
                    cookie: true, // This is important, it's not enabled by default
                    xfbml: true,
                    version: 'v19.0' // version v16.0
                })
            }
        },
        loadFacebookSDK(d, s, id) {
            const fjs = d.getElementsByTagName(s)[0]
            if (d.getElementById(id)) {
                return
            }
            const js = d.createElement(s)
            js.id = id
            js.src = 'https://connect.facebook.net/en_US/sdk.js'
            fjs.parentNode.insertBefore(js, fjs)
        },
        SocialLogin(response) {
            console.log(response);
            // //sent name provider with token to Socialite package to get use object
            axios.post('/social-login', {
                provider: 'facebook',
                token: response.accessToken
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.$emit('loggedIn')
            }).catch((err) => {
                console.log({ err })
            })
        },
    }
}
</script>