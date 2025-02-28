<?php

namespace App\Service;

use App\Entity\FtpServer;
use App\Repository\FtpServerRepository;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FtpService 
{
    public function __construct (
        private FtpServerRepository $ftpServerRepository
    )
    {}

    public function connectToServer(string $alias, string $ftpUser, $ftpPass): Filesystem 
    {
        $ftpServer = $this->ftpServerRepository->findOneBy(['alias' => $alias]);

        if (!$ftpServer) {
            throw new NotFoundHttpException("FTP Server not found for alias : $alias");
        }

        $connectionOptions = FtpConnectionOptions::fromArray([
            'host' => $ftpServer->getHost(),
            'username' => $ftpUser,
            'password' => $ftpPass,
            'port'     => 21,
            'timeout'  => 10,
            'root'     => '/',
            'ssl'      => false,
            'passive'  => true
        ]);

        $adapter = new FtpAdapter($connectionOptions);  

        return new Filesystem($adapter);
    }
}
