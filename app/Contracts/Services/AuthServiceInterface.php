<?php

namespace App\Contracts\Services;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function getAuthenticatedUser();
    public function attemptLogin(array $credentials): bool;
    public function logout(): void;
}
