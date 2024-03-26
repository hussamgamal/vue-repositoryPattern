<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\SocialProviderUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // provider name in request is Facebook
        $provider = $request->provider;
        $social_user = Socialite::driver($provider)->userFromToken($request->token);

        abort_unless($social_user, 401, __('auth.failed_login'));

        // if found use login and if not create user 
        /** @var SocialUser $social_user */
        $user = User::query()
            ->where('email', $this->getEmail($social_user, $provider))
            ->first();

        if (!$user) {
            $user = User::create([
                'name'     => $social_user->getName(),
                'email'    => $this->getEmail($social_user, $provider),
                'password' => bcrypt($social_user->getId()),
                'image' => $this->getImage($social_user, $provider)
            ]);
        }

        Auth::login($user);

        return UserResource::make($user)->additional([
            'token' => $user->createToken('user')->plainTextToken,
        ]);
    }

    private function getEmail($social_user, $provider): string
    {
        // if user prevent access to email or not have email make fake email
        // userID@facebook.com
        return $social_user->getEmail() ?? $social_user->getId() . '@' . $provider . '.com';
    }

    private function getImage($social_user, $provider): string
    {
        //https://graph.facebook.com/UserID/picture
        return $social_user->getAvatar() ?? 'https://graph.facebook.com/' . $social_user->getId() . '/picture';
    }
}
