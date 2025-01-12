<?php

namespace App\Object;

use Symfony\Component\Serializer\Attribute\Groups;

class PetCategory
{
    #[Groups(['public'])]
    private string|int|null $id = null;

    #[Groups(['public'])]
    private ?string $name = null;

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(int|string|null $id): PetCategory
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): PetCategory
    {
        $this->name = $name;
        return $this;
    }

}
