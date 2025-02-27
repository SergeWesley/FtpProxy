<?php

namespace App\Repository;

use App\Entity\FtpServer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FtpServerRepository extends ServiceEntityRepository
{
    public function __construct (private ManagerRegistry $registry)
    {
        parent::__construct($registry, FtpServer::class);
    }
}
