<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface as ServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService implements ServiceInterface
{
    public function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function attemptLogin(array $credentials): bool
    {
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $credentials['remember'] ?? false)) {
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
    }
}
