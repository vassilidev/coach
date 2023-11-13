<x-filament-panels::page>
    @livewire(\App\Filament\Widgets\ClientBookTeacherCalendar::class, ['record' => $record])
    <a href="{{ route('front.home') }}" class="btn btn-success" style="
           background-color: rgb(204,0,0);
           color: white;
           text-align: center;
           border-radius: 8px;}"
    >Retour</a>
</x-filament-panels::page>
