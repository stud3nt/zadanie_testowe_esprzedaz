@php use Illuminate\Support\Facades\Session; @endphp

@extends('skeleton')

@section('content')
    <h2>
        @if($pet?->getId())
            PET #{{ $pet->getId() }} {{ $pet->getName() }}
        @else
            NEW PET
        @endif
    </h2>

    <hr/>

    <form method="POST" action="{{ route('pets.pet_editor', ['petId' => $pet->getId()]) }}">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if(Session::hasAny('save-result'))
            <div class="alert {{ Session::get('alert-class') }}" role="alert">
                {{ Session::get('save-result') }}
            </div>
        @endif

        <input type="hidden" name="id" value="{{ $pet->getId() }}"/>

        <div class="mb-3">
            <label for="pet_name" class="form-label">Pet Name</label>
            <input name="name" type="text" required class="form-control" id="pet_name" value="{{ $pet->getName() }}">
        </div>
        <div class="mb-3">
            <label for="pet_category" class="form-label">Category</label>
            <input name="category[id]" type="hidden" value="{{ $pet->getCategory()?->getId() }}">
            <input name="category[name]" type="text" class="form-control" id="pet_category"
                   value="{{ $pet->getCategory()?->getName() }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Photo Urls</label>

            <div class="row">
                <div class="col-12" id="photo_urls_container">
                    @if($pet->getPhotoUrls())
                        @foreach($pet->getPhotoUrls() as $photoKey => $photoUrl)
                            <div class="input-group mb-3 photo_url_row">
                                <input type="text" name="photoUrls[{{ $photoKey }}]" class="form-control"
                                       value="{{ $photoUrl }}">
                                <button class="btn btn-outline-secondary remove_photo_url" type="button">REMOVE PHOTO
                                    URL
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-secondary btn-sm" id="button_add_photo_url">ADD PHOTO URL
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Tags</label>

            <div class="row">
                <div class="col-12" id="tag_container">
                    @if($pet->getTags())
                        @foreach($pet->getTags() as $tagKey => $tag)
                            <div class="input-group mb-3 tag_row">
                                <input type="hidden" name="tags[{{ $tagKey }}][id]" value="{{ $tag->getId() }}">
                                <input type="text" name="tags[{{ $tagKey }}][name]" class="form-control"
                                       value="{{ $tag->getName() }}">
                                <button class="btn btn-outline-secondary button_remove_tag" type="button">REMOVE TAG
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-secondary btn-sm" id="button_add_tag">ADD TAG</button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="pet_name" class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value=""></option>
                <option value="available" @selected($pet->getStatus() === 'available')>Available</option>
                <option value="pending" @selected($pet->getStatus() === 'pending')>Pending</option>
                <option value="sold" @selected($pet->getStatus() === 'sold')>Sold</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">SAVE</button>
        <a href="{{ route('pets.search_pet') }}" class="btn btn-warning">BACK</a>
        @csrf
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        let lastTagKey = {{ count($pet->getTags()) }};
        let lastPhotoKey = {{ count($pet->getPhotoUrls()) }};

        function addTag() {
            $('#tag_container').append(
                $('<div/>', {
                    class: 'input-group mb-3 tag_row'
                }).append(
                    $('<input/>', {
                        type: 'hidden',
                        name: 'tags[' + lastTagKey + '][id]'
                    })
                ).append(
                    $('<input/>', {
                        type: 'text',
                        name: 'tags[' + lastTagKey + '][name]',
                        class: 'form-control'
                    })
                ).append(
                    $('<button/>', {
                        type: 'button',
                        class: 'btn btn-outline-secondary button_remove_tag'
                    }).text('REMOVE TAG')
                )
            );

            lastTagKey++;
        }

        function addPhotoUrl() {
            $('#photo_urls_container').append(
                $('<div/>', {
                    class: 'input-group mb-3 photo_url_row'
                }).append(
                    $('<input/>', {
                        type: 'text',
                        name: 'photoUrls[' + lastPhotoKey + ']',
                        class: 'form-control'
                    })
                ).append(
                    $('<button/>', {
                        type: 'button',
                        class: 'btn btn-outline-secondary button_remove_photo_url'
                    }).text('REMOVE PHOTO URL')
                )
            );

            lastPhotoKey++;
        }

        $(document).ready(function () {
            $(document).on('click', '#button_add_tag', function () {
                addTag();
            });

            $(document).on('click', '#button_add_photo_url', function () {
                addPhotoUrl();
            });

            $(document).on('click', '.button_remove_tag', function () {
                $(this).closest('.tag_row').remove();
            });

            $(document).on('click', '.button_remove_photo_url', function () {
                $(this).closest('.photo_url_row').remove();
            })
        })
    </script>
@endsection
