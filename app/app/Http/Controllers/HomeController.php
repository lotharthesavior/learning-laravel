<?php

namespace App\Http\Controllers;

use App\Services\Tribe\TribeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $tribeAccountMeta = json_decode($user->metas->first(function($item){
            return $item->name === TribeService::TRIBE_ACCOUNT_META_KEY;
        })->value);

        return view('home', [
            'userAvatar' => $tribeAccountMeta->avatar ?? ''
        ]);
    }
}
