<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface as ServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserService extends BaseService implements ServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersCount(): int
    {
        return $this->userRepository->get([
            'scopeMethods' => [
                'user' => null
            ],
            'count' => true
        ]);
    }

    public function getAdminEmails(): array
    {
        $admins = $this->userRepository->get([
            'whereConditions' => [
                ['field' => 'role', 'operator' => '=', 'value' => 'admin'],
            ],
        ]);
        return $admins->pluck('email')->toArray();
    }
}
