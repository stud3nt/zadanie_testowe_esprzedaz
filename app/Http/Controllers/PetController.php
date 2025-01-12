<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetSaveRequest;
use App\Http\Requests\PetSearchRequest;
use App\Object\Pet;
use App\Services\StorePetService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

class PetController extends Controller
{
    public function __construct(
        protected StorePetService $petService
    ) {
    }

    public function search(PetSearchRequest $request): View
    {
        $pet = [];
        $petId = null;

        if ($request->getMethod() === Request::METHOD_POST) {
            $petId = $request->get('pet_id');
            $pet = $this->petService->findPetById($petId);
        }

        return view('pet.search', [
            'pet' => $pet,
            'petId' => $petId
        ]);
    }

    public function editor(PetSaveRequest $request, $petId = null): Factory|Application|View|RedirectResponse
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $requestData = $request->validated();
            $savedPet = $this->petService->savePet($requestData);

            if ($savedPet instanceof Pet) {
                Session::flash('save-result', 'Saved successfully!');
                Session::flash('alert-class', 'alert-success');

                return redirect()->route('pets.pet_editor', ['petId' => $savedPet->getId()]);
            } else {
                Session::flash('save-result', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
            }
        }

        $pet = null;

        if ($petId) {
            try {
                $pet = $this->petService->findPetById($petId);
            } catch (\InvalidArgumentException) {

            }
        }

        if (!$pet instanceof Pet) {
            $pet = new Pet();
        }

        return view('pet.editor', [
            'pet' => $pet
        ]);
    }

    public function delete($petId = null): RedirectResponse
    {
        if ($this->petService->deletePet($petId)) {
            Session::flash('delete-result', 'Deleted successfully!');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('delete-result', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('pets.search_pet');
    }
}
