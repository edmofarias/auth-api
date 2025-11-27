<?php

namespace App\Services\Contracts;

interface IAuthService
{
    public function login(array $userData): array|null;
    
    public function register(array $userData): string;
}