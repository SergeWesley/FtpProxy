<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    public function __construct(
        private JWTTokenManagerInterface    $jwtManager
    )
    {}

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request, UserInterface $user): JsonResponse
    {
        if (!$user) {
            throw new BadCredentialsException('Invalid credentials');
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse([
            'token' => $token
        ]);
    }
}