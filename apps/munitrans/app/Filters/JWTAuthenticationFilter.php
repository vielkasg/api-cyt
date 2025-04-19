<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class JWTAuthenticationFilter implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        $authenticationHeader = $request->getHeaderLine('Authorization');

        if (is_null($authenticationHeader)) {
            return Services::response()
                ->setJSON(
                    [
                        'error' => 'Missing or invalid JWT in request'
                    ]
                )->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
        try {
            helper('jwt');
            $encodedToken = getJWTFromRequest($authenticationHeader);
            validateJWTFromRequest($encodedToken);
            return $request;
        } catch (Exception $e) {
            return Services::response()
                ->setJSON(
                    [
                        'error' => $e->getMessage()
                    ]
                )->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
