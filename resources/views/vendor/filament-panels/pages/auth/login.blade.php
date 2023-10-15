<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <section class='flex flex-col gap-6 mt-4'>
        <div class="relative flex items-center">
            <div class="flex-grow border-t border-gray-400"></div>
            <span class="flex-shrink mx-4 text-gray-400 px-4">
                {{ config('socialment.view.prompt', 'Or Login Via') }}
            </span>
            <div class="flex-grow border-t border-gray-400"></div>
        </div>

        <div class='flex justify-center gap-x-4 p-2'>
            @foreach(\App\Enums\Auth\SocialiteProvider::cases() as $provider)
                <a class='ring-2 ring-slate-700/50 hover:ring-slate-600/70 transition-all rounded-lg px-4 py-3 flex gap-2 items-center'
                   href='{{ route('socialite.redirect', $provider) }}'>
                    @svg($provider->getIcon())
                    <span>{{ $provider->getLabel() }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}
</x-filament-panels::page.simple>
