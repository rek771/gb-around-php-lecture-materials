<?php
namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource]
class User
{
   #[ORM\Id]
   #[ORM\GeneratedValue]
   #[ORM\Column(type: "integer")]
   #[Groups(['user:list', 'conference:item'])]
   public ?int $id;


   #[Groups(['user:list', 'conference:item'])]
   #[ORM\Column(type: "string", length: 255)]
   public ?string $name;


   public function getId(): ?int
   {
       return $this->id;
   }


   public function setName(string $name): self
   {
       $this->name = $name;
       return $this;
   }


   public function getName(): ?string
   {
       return $this->name;
   }
}
