<?php

namespace App\Contracts\Services;

interface UserServiceInterface extends BaseServiceInterface
{
    public function getUsersCount(): int;
    public function getAdminEmails(): array;
}
