<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $table = 'sq_users';
    protected $allowedfields = [
        'nombre',
        'email',
        'clave'
    ];
    protected $updatedfield = 'updated_at';

    protected $beforeinsert = ['beforeinsert'];
    protected $beforeupdate = ['beforeupdate'];
    protected function beforeinsert(array $data): array
    {
        return $this->getupdateddatawithhashedpassword($data);
    }

    protected function beforeupdate(array $data): array
    {
        return $this->getupdateddatawithhashedpassword($data);
    }

    private function getupdateddatawithhashedpassword(array $data): array
    {
        if (isset($data['data']['clave'])) {
            $plaintextpassword = $data['data']['clave'];
            $data['data']['clave'] = $this->hashpassword($plaintextpassword);
        }
        return $data;
    }

    private function hashpassword(string $plaintextpassword): string
    {
        return password_hash($plaintextpassword, PASSWORD_BCRYPT);
    }

    public function finduserbyemailaddress(string $emailaddress)
    {
        $user = $this
            ->asarray()
            ->where(['email' => $emailaddress])
            ->first();

        if (!$user)
            throw new exception('user does not exist for specified email address');

        return $user;
    }

    public function finduserbyusername(string $username)
    {
        $user = $this
            ->asarray()
            ->where(['username' => $username])
            ->first();

        if (!$user)
            throw new exception('user does not exist for specified username');

        return $user;
    }
}
