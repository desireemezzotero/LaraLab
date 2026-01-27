<div class="lg:col-span-1">
    <h2 class="text-lg font-semibold mb-3 flex items-center">
        <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
        Autori del progetto
    </h2>

    {{-- AUTORI --}}
    @foreach ($project->users as $user)
        <div class="px-6 pb-2">
            <span
                class="inline-block bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $user->pivot->project_role }}:
                {{ $user->name }}
            </span>
        </div>
    @endforeach



    {{-- OBIETTIVI ASSEGANTE AL PROGETTO  --}}
    <h2 class="text-lg font-semibold mb-3 flex items-center">
        <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
        obiettivi assegnati a questo progetto
    </h2>

    <div class="px-6 pb-2">
        <span
            class="inline-block bg-gray-200  px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $project->objectives }}
        </span>
    </div>
</div>
