<?php 

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(uriVariables: ['alias']),
        new GetCollection(),
        new Post(),
        new Patch(
            uriVariables: ['alias'],
            inputFormats: ['json' => ['application/json', 'application/merge-patch+json']]
        ),
        new Delete(uriVariables: ['alias'])
    ]
)]
class FtpServer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[ApiProperty(identifier: true)]
    #[Assert\NotBlank]
    private string $alias;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $host;

    public function getId() : int
    {
        return $this->id;
    }

    // Getter et Setter pour $alias
    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    // Getter et Setter pour $host
    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }
}
