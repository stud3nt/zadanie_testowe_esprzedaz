<?php

namespace App\Object;

use Symfony\Component\Serializer\Attribute\Groups;

class PetTag
{
    #[Groups(['public'])]
    private string|int|null $id = null;

    #[Groups(['public'])]
    private string $name;

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(string|int|null $id): PetTag
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PetTag
    {
        $this->name = $name;
        return $this;
    }
}
