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
     * @var Collection
     */
    private $categories;

    /**
     * @var string
     */
    public $userSearch;

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

        $categories =  Category::query()
            ->with('specialities')
            ->whereHas('specialities')
            ->get();

        return view('livewire.teacher.list-teacher', [
            'teachers' => $teachers->get(),
            'categories' => $categories
        ]);
    }
}
