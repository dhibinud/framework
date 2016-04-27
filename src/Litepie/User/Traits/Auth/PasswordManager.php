<?php

namespace Litepie\User\Traits\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Request;

trait PasswordManager
{

    use ResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  string|null                 $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm($token = null)
    {

        $guard = Request::input(config('user.params.type'), 'user');

        if (is_null($token)) {
            return $this->getEmail();
        }

        return $this->theme->of($this->getView('reset', $guard), compact('token'))
            ->render();
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $guard = Request::input(config('user.params.type'), 'user');

        return $this->theme->of($this->getView('password', $guard))->render();
    }

    /**
     * Display the form to request a password reset link.
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {

        $guard = Request::input(config('user.params.type'), 'user');

        return $this->theme->of($this->getView('password', $guard))->render();
    }

    /**
     * Check whether the view exists for the role, else return defaut role.
     *
     * @param type $view
     * @param type $guard
     * @return type
     */
    public function getView($view, $guard)
    {

        if (view()->exists("user::public.$guard.$view")) {
            return "user::public.$guard.$view";
        }

        return "user::public.default.$view";
    }

}
