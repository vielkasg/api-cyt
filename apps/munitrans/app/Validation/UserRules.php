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
            $user = $model->findUserByUsername($data['username']);
            return md5($data['clave']) === $user['clave'];
        } catch (Exception $e) {
            return false;
        }
    }
}
