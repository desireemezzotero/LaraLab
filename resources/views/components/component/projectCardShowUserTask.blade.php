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

    <h2 class="text-lg font-semibold mb-3 flex items-center">
        <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
        Task assegnate a questo progetto
    </h2>

    {{-- TASK ASSEGANTE AL PROGETTO IN GENERALE --}}
    @foreach ($project->tasks as $task)
        <div class="px-6 pb-2">
            <span
                class="inline-block bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $task->title }}
            </span>
        </div>
    @endforeach
</div>
