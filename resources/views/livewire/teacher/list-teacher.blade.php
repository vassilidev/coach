<div>
    <div class="row">
        <div class="col-8">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0">{{ __('Liste des prof') }}</h1>
                    <div>
                        <input type="text"
                               placeholder="Rechercher un professeur..."
                               class="form-control rounded-pill">
                    </div>
                </div>
                @foreach($teachers as $teacher)
                    <div class="card my-4 p-2">
                        <div class="row">
                            <div class="col-8 text-left">
                                <h4>{{ $teacher->user->name }}</h4>
                                <h5>About</h5>
                                <p>{{ $teacher->description }}</p>
                                <button class="btn btn-primary">
                                    Book
                                </button>
                            </div>
                            <div class="col-4">
                                <h4>Spécialities</h4>
                                @foreach($teacher->specialities as $speciality)
                                    <span class="badge bg-primary">{{ $speciality->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    @foreach($categories as $category)
                        <div class="p-4 mb-2 rounded border" wire:key="category-{{ $category->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="category-{{ $category->id }}">
                                <label class="form-check-label h1" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>

                            <hr>

                            @foreach($category->specialities as $speciality)
                                <input type="checkbox"
                                       class="btn-check"
                                       id="speciality-{{ $speciality->id }}" autocomplete="off">
                                <label class="btn m-1 btn-sm rounded-pill btn-outline-primary"
                                       for="speciality-{{ $speciality->id }}">
                                    {{ $speciality->name }}
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>