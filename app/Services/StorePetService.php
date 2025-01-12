<?php

namespace App\Services;

use App\Http\Requests\PetSaveRequest;
use App\Object\Pet;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Request;
use WayOfDev\Serializer\Manager\SerializerManager;

class StorePetService
{
    private Client $client;

    public function __construct(
        private readonly SerializerManager $serializerManager
    ) {
        $this->client = app(Client::class, ['config' => [
            'base_uri' => config('services.pet_store.api_url')]
        ]);
    }

    public function findPetById($petId): ?Pet
    {
        $endpoint = sprintf('/v2/pet/%s', $petId);

        try {
            $response = $this->client->request(Request::METHOD_GET, $endpoint);
        } catch (GuzzleException|\InvalidArgumentException $e) {
            return null;
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return $this->serializerManager->deserialize($response->getBody()->getContents(), Pet::class);
        } else {
            return null;
        }
    }

    public function savePet(array $petData): ?Pet
    {
        $petData['id'] = $petData['id'] ?? 0;
        $petData['photoUrls'] = array_values($petData['photoUrls'] ?? []);
        $petData['tags'] = array_values($petData['tags'] ?? []);

        $endpoint = '/v2/pet';

        $method = ($petData['id'] === 0)
            ? Request::METHOD_POST // ID === 0 -> save
            : Request::METHOD_PUT; // ID !== 0 -> update

        $response = $this->client->request($method, $endpoint, [
            RequestOptions::JSON => $petData
        ]);

        try {
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                return $this->serializerManager->deserialize($response->getBody()->getContents(), Pet::class);
            }
        } catch (\InvalidArgumentException|GuzzleException $exception) {
            // error msg
        }

        return null;
    }

    public function deletePet($petId): bool
    {
        $endpoint = sprintf('/v2/pet/%s', $petId);

        try {
            $response = $this->client->request(Request::METHOD_DELETE, $endpoint);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                return true;
            }
        } catch (GuzzleException|\InvalidArgumentException $e) {
            return false;
        }

        return false;
    }
}
