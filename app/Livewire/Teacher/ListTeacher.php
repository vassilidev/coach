<?php

namespace App\Livewire\Teacher;

use App\Models\Category;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ListTeacher extends Component
{
    /**
     * @var string
     */
    public string $userSearch = '';

    /**
     * @var Collection
     */
    public Collection $categories;

    /**
     * @var array
     */
    public array $selectedCategories = [];

    /**
     * @var array
     */
    public array $selectedSpecialities = [];


    /**
     * @return Collection
     */
    public function mount(): Collection
    {
        return $this->categories = Category::query()
            ->with('specialities')
            ->whereHas('specialities')
            ->get();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $teachers = Teacher::query()
            ->with('user')
            ->with('specialities');

        if ($this->userSearch) {
            $teachers->whereHas('user', function ($query) {
                $search = "%{$this->userSearch}%";

                $query->where('name', 'LIKE', $search);
            });
        }

        if (!empty($this->selectedCategories)) {
            $this->selectedSpecialities = array_unique(
                array_merge(
                    $this->selectedSpecialities,
                    ...$this->categories
                    ->find($this->selectedCategories)
                    ->pluck('specialities.*.id')
                    ->toArray()
                )
            );
        }

        if (!empty($this->selectedSpecialities)) {
            $teachers->whereHas('specialities', function ($query) {
                $query->whereIn('id', $this->selectedSpecialities);
            });
        }

        return view('livewire.teacher.list-teacher', [
            'teachers' => $teachers->get(),
            'categories' => $this->categories
        ]);
    }
}
