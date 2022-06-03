<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('welcome', ['name' => 'Nikola']);

        //$user = User::find(2);
        //
        // $user->makeVisible('fuck');
        // $user->makeHidden('email');
        //dd($user->toJson());
    }

    public function store(Request $request)
    {
        sleep(5);

        User::create([
            'name'     => 'Nikola',
            'email'    => 'nicks-'.rand(32, 323).'@hotmail.com',
            'password' => '2321321',
            'active'   => true,
            'votes'    => 201,
        ]);

        echo 'vtoro store se povikuva vo kontrolerot.';
    }

    public function update()
    {
        return 'sds';
    }
}
