<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Mainick\KeycloakClientBundle\Interface\IamClientInterface;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly IamClientInterface $iamClient
    ) {
    }

    #[Route('/api/login', name: 'app_login')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LoginController.php',
            'admin_token' =>  $this->iamClient->authenticate('admin', 'admin'),
            'user_token' =>  $this->iamClient->authenticate('user', 'password'),
        ]);
    }
}
