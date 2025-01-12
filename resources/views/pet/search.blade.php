@extends('skeleton')

@section('content')
    <div class="row">
        <div class="col-12">
            <a class="btn btn-success" href="{{ route('pets.pet_editor') }}">Create pet</a>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('pets.search_pet') }}">
                <div class="form-group">
                    <label for="search_pet_id">Pet ID</label>
                    <input
                        type="text"
                        name="pet_id"
                        class="form-control @if($errors->has('pet_id')) is-invalid @endif"
                        id="search_pet_id"
                        placeholder="Pet ID"
                        pattern="[0-9]+"
                        value="{{ $petId }}"
                    />
                    @if($errors->has('pet_id'))
                        <div id="pet_id_feedback" class="invalid-feedback">
                            {{ $errors->first('pet_id') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                @csrf
            </form>
        </div>
    </div>

    @if($petId && !$pet)
        No results
    @elseif($pet)
        <a href="{{ route('pets.pet_editor', ['petId' => $pet->getId()]) }}">{{ $pet->getName() }}</a>
        <a href="{{ route('pets.delete_pet', ['petId' => $pet->getId()]) }}" class="btn btn-xs btn-danger">DELETE THIS PET</a>
    @endif

    @if(Session::hasAny('delete-result'))
        <div class="alert {{ Session::get('alert-class') }}" role="alert">
            {{ Session::get('delete-result') }}
        </div>
    @endif
@endsection
