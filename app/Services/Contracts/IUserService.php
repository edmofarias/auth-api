<?php

namespace App\Services\Contracts;

use App\Models\User;

interface IUserService
{
    public function show(int $userId): ?User;
    
    public function update(int $userId, array $userData): ?User;

    public function delete(int $userId): bool;
}