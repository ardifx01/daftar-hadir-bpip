<?php

namespace App\Http\Controllers;

use App\Http\Classes\AuthSSO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
    }

    /**
     * Handle login action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function login(Request $request)
    {
        $token = AuthSSO::getSessionToken();
        $authSSO = new AuthSSO();
        $result = null;
        if ($token) {
            $result = $authSSO->login($request, $token);
        } else {
            $result = $authSSO->login($request);
        }
        if (array_key_exists('error_message', $result) && $result['error_message'] != '') {
            return Redirect::to($result['redirect_url'])
                ->with(['error' => $result['error_message']]);
        }
        //dd($result);

        return Redirect::to($result['redirect_url']);
    }


    /**
     * Handle logout action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function logout(Request $request)
    {
        $token = AuthSSO::getSessionToken();
        AuthSSO::clearCache($token);
        $result = AuthSSO::logout();
        if (array_key_exists('error_message', $result) && $result['error_message'] != '') {
            return Redirect::to($result['redirect_url'])
                ->with(['error' => $result['error_message']]);
        }
        return Redirect::to($result['redirect_url']);
    }
}
