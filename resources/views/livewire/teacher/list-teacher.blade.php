{{--
<div>
    <div class="row">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="m-0">{{ __('Liste des prof') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            @foreach($categories ?? [] as $category)
                <p>{{$category->name}}</p>
                <ul>
                    @foreach($category->specialities ?? [] as $speciality)
                        <li>{{$speciality->name}}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</div>
 --}}

<div>
    {{ $userSearch }}
    <div class="form-group">
        <input type="text"
               wire:model.live="userSearch"
               placeholder="Prénom..."
               class="rounded-pill form-control"/>
    </div>
</div>
