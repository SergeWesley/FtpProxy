<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Model\FtpRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\FtpService;

#[Route('/ftp_servers')]
class FtpController extends AbstractController
{
    public function __construct (
        private FtpService $ftpService,
        private ValidatorInterface $validator
    )
    {}

    #[Route('/{alias}/{path}', methods: ['GET'], defaults: ['ftp_required' => true], requirements: ['path' => '.+'])]
    public function listFiles(Request $request, string $alias, string $path = '/'): JsonResponse 
    {
        $sanitizedPath = '/' . ltrim($path, '/');

        $filesystem = $this->ftpService->connectToServer($alias);
        $files = $filesystem->listContents($sanitizedPath, false);

        return $this->json(["files" => $files]);
    }
}