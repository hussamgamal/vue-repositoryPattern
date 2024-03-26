<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    {{-- <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0&appId=765823162168291" nonce="JnLaxdhw">
    </script>

    <div class="fb-login-button" data-width="" data-size="" data-button-type="" data-layout=""
        data-auto-logout-link="false" data-use-continue-as="false"></div> --}}

    <button onclick="fbLogin()">Login</button>
    <div id="fb-root"></div>
    <script src="https://connect.facebook.net/en_US/sdk.js" nonce="zhhICoHA"></script>
    <script nonce="zhhICoHA">
        FB.init({
            appId: 765823162168291,
            status: true,
            xfbml: true,
            version: 'v19.0'
        });
        FB.AppEvents.logPageView();
    </script>

    <script>
        function fbLogin() {
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    FB.api('/me', function(response) {
                        console.log(response);
                        console.log('Good to see you, ' + response.name + '.');
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            });
        }
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
</body>

</html>
