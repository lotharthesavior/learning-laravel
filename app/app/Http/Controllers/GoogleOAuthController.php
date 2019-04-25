<?php

namespace App\Http\Controllers;

use App\Services\Tribe\TribeService;
use App\User;
use App\UserMeta;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use \Laravel\Socialite\Two\User as SocialiteUser;

class GoogleOAuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // --
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->with(['hd' => 'tri.be'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        $userModel = $this->persistTribeUser($user);

        Auth::login($userModel);

		return redirect('home');
    }

    /**
     * @param SocialiteUser $user
     *
     * @return User
     */
    private function persistTribeUser(SocialiteUser $user)
    {
        $userModel = User::updateOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'fh287gr8ybfow8fufihriuwhfoahv9hdis'
            ]
        );

        UserMeta::updateOrCreate(
            [
                'user_id' => $userModel->id,
                'name' => TribeService::TRIBE_ACCOUNT_META_KEY,
            ],
            [
                'user_id' => $userModel->id,
                'name' => TribeService::TRIBE_ACCOUNT_META_KEY,
                'value' => json_encode($user),
            ]
        );

        return $userModel;
    }
}
