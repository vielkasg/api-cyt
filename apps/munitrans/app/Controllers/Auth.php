<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionExeption;
use Core\CoreBaseController;

class Auth extends CoreBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function register()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'clave' => 'required|min_length[8]|max_length[255]'
        ];
        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        $userModel = new UserModel();
        $userModel->save($input);

        return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_CREATED);
    }

    /**
     * Authenticate Existing user
     * @return Response
     */
    public function login()
    {
        $rules = [
            'username' => 'required|min_length[4]|max_length[50]',
            'clave' => 'required|min_length[4]|max_length[255]|validateUser[username, clave]'
        ];
        $errors = [
            'clave' => [
                'validateUser' => 'Invalid login credentials provided' . md5('M12345')
            ]
        ];
        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        return $this->getJWTForUser($input['username']);
    }
    private function getJWTForUser(string $username, int $responseCode = ResponseInterface::HTTP_OK)
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByUsername($username);
            unset($user['clave']);
            helper('jwt');
            return $this
                ->getResponse(
                    [
                        'message' => 'User logged is successfully',
                        'user' => [
                            'cod' => $user['cod'],
                            'username' => $user['username'],
                            'name' => $user['nombre'],
                            'email' => $user['email']
                        ],
                        'access_token' => getSignedJWTForUser($username)
                    ]
                );
        } catch (Exception $e) {
            return $this
                ->getResponse(
                    [
                        'error' => $e->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}
