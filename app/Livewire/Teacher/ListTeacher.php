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
    
    public function toggleCategorySpecialities(mixed $categoryID): void
    {
        $specialities = $this->categories->find($categoryID)->specialities->pluck('id')->toArray();

        // This is the new state, not the live one
        if (!in_array($categoryID, $this->selectedCategories)) {
            $this->selectedSpecialities = array_diff(
                $this->selectedSpecialities,
                $specialities,
            );
        } else {
            $this->selectedSpecialities = array_unique(
                array_merge(
                    $this->selectedSpecialities,
                    $specialities,
                )
            );
        }
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
