<div>
    <div class="row">
        <div class="col-lg-8 col-12 order-2 order-lg-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0">{{ __('front/home.listTeacher') }}</h1>
                <div>
                    <input type="text"
                           wire:model.live="userSearch"
                           placeholder="Rechercher un professeur..."
                           class="form-control rounded-pill">
                </div>
            </div>
            <div class="teacher-section card-body p-2 my-4">
                @foreach($teachers as $teacher)
                    <div class="card my-4 p-4 custom-shadow">
                        <div class="row">
                            <div class="col-lg-9 col-8 border-end">
                                <div class="row">
                                    <div class="col-md-2 col-3">
                                        <img
                                            src="{{asset('img/teachers/Teacher-image-exemple.png')}}"
                                            alt="Teacher picture" class="img-fluid rounded-circle m-2">
                                    </div>
                                    <div class="col-md-10 col-9 text-start">
                                        <h4>{{ $teacher->user->name }}</h4>
                                        <h5>{{ __('front/home.about') }}</h5>
                                        <p class="text-start">{{ $teacher->description }}</p>
                                        <button class="btn btn-primary p-2">
                                            {{ __('front/home.book') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-4">
                                <h4>{{ __('front/home.specialities') }}</h4>
                                @foreach($teacher->specialities as $speciality)
                                    <div class="text-start">
                                        <span
                                            class="badge custom-background-badge text-custom-dark w-100 text-start">
                                            {{ $speciality->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4 col-12 order-1 order-lg-2">
            <div class="card mb-5">
                <div class="card-body custom-shadow">
                    @foreach($categories as $category)
                        <div class="p-2 mb-4 rounded border custom-shadow" wire:key="category-{{ $category->id }}">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input type="checkbox"
                                           wire:model.live="selectedCategories"
                                           id="category-{{ $category->id }}"
                                           value="{{ $category->id }}"
                                           autocomplete="off"
                                           class="form-check-input mt-0">
                                </div>
                                <label class="input-group-text w-auto flex-grow-1"
                                       for="category-{{ $category->id }}">
                                    <i class="fa-solid fa-person-skiing text-primary me-3"></i>
                                    {{ $category->name }}
                                </label>
                            </div>
                            <div class="text-start">
                                @foreach($category->specialities as $speciality)
                                    <input type="checkbox"
                                           wire:model.live="selectedSpecialities"
                                           id="speciality-{{ $speciality->id }}"
                                           value="{{ $speciality->id }}"
                                           autocomplete="off"
                                           class="btn-check">
                                    <label class="btn m-1 btn-sm rounded-3 border custom-background-badge"
                                           for="speciality-{{ $speciality->id }}">
                                        {{ $speciality->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
