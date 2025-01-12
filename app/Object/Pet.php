<?php

namespace App\Object;

use Symfony\Component\Serializer\Attribute\Groups;

class Pet
{
    #[Groups(['public'])]
    private int|string|null $id = null;

    #[Groups(['public'])]
    private ?PetCategory $category = null;

    #[Groups(['public'])]
    private ?string $name = null;

    #[Groups(['public'])]
    private array $photoUrls = [];

    #[Groups(['public'])]
    private array $tags = [];

    #[Groups(['public'])]
    private ?string $status = null;

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(int|string|null $id): Pet
    {
        $this->id = $id;
        return $this;
    }

    public function getCategory(): ?PetCategory
    {
        return $this->category;
    }

    public function setCategory(?PetCategory $category = null): Pet
    {
        $this->category = $category;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Pet
    {
        $this->name = $name;
        return $this;
    }

    public function getPhotoUrls(): array
    {
        return $this->photoUrls;
    }

    public function setPhotoUrls(array $photoUrls): Pet
    {
        $this->photoUrls = $photoUrls;
        return $this;
    }

    /**
     * @return PetTag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param PetTag[] $tags
     * @return $this
     */
    public function setTags(array $tags = []): Pet
    {
        $this->tags = $tags;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Pet
    {
        $this->status = $status;
        return $this;
    }


}
