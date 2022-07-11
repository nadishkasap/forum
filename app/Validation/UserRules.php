<?php

namespace App\Validation;

use App\Models\UserModel;
use Exception;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByEmailAddress($data['user_email']);
            return password_verify($data['user_password'], $user['user_password']);
        } catch (Exception $e) {
            return false;
        }
    }
}