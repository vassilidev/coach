<div>
    <div class="row">
        <div class="col-xl-8 col-12 order-2 order-xl-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0 bold font-weight-bold fw-bolder text-custom-darkblue custom-title-size">{{ __('front/home.listTeacher') }}</h1>
                <div>
                    <input type="text"
                           wire:model.live="userSearch"
                           placeholder="Rechercher un professeur..."
                           class="form-control rounded-pill">
                </div>
            </div>
            <div class="teacher-section card-body p-2 my-4">
                @foreach($teachers as $teacher)
                    <div class="card my-4 p-4 custom-shadow" wire:key="teacher-{{ $teacher->id }}">
                        <div class="row">
                            <div class="col-12 col-xl-9 border-end-xl">
                                <div class="row">
                                    <div class="col-3 col-xl-2">
                                        <img src="{{ $teacher->user->avatar }}" alt="Teacher picture" class="img-fluid rounded-circle m-2">
                                    </div>
                                    <div class="col-9 col-xl-10 text-start">
                                        <h4 class="mb-4">{{ $teacher->user->name }}</h4>
                                        <h6>{{ __('front/home.about') }}</h6>
                                        <p class="text-start">{{ $teacher->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-3">
                                <h4>{{ __('front/home.specialities') }}</h4>
                                @foreach($teacher->specialities as $speciality)
                                    <div class="text-start" wire:key="speciality-{{ $speciality->id }}">
                            <span class="badge custom-background-badge text-white w-100 text-start">
                                {{ $speciality->name }}
                            </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-xl-2 mt-5">
                                <button class="btn btn-primary p-2 w-100">
                                    {{ __('front/home.book') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-xl-4 col-12 order-1 order-xl-2">
            <div class="card mb-5">
                <div class="card-body custom-shadow rounded">
                    @foreach($categories as $category)
                        <div class="p-2 mb-4 rounded border custom-shadow" wire:key="category-{{ $category->id }}">
                            <div class="input-group mb-3 flex-nowrap">
                                <div class="input-group-text">
                                    <input type="checkbox"
                                           wire:model="selectedCategories"
                                           wire:change="toggleCategorySpecialities({{ $category->id }})"
                                           id="category-{{ $category->id }}"
                                           value="{{ $category->id }}"
                                           autocomplete="off"
                                           class="form-check-input mt-0">
                                </div>
                                <label class="input-group-text w-auto flex-grow-1 p-2"
                                       for="category-{{ $category->id }}">
                                    <i class="fa-solid fa-person-skiing text-primary me-3 fs-3"></i>
                                    <span class="text-custom-darkblue bold fw-bold fs-4">
                                        {{ $category->name }}
                                    </span>
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
                                    <label class="btn m-1 btn-sm rounded-3 border custom-background-button shadow-sm"
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
