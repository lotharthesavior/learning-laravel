<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

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
	}
}
