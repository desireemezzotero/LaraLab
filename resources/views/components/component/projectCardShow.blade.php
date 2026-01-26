<div class="p-4 mx-auto container">

    <div class="mb-8 flex items-center justify-between">

        <div class="w-24 hidden lg:block"></div>

        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Progetto: {{ $project->title }}
        </h1>

        <div class="w-24 flex justify-end items-center space-x-3">
            @php
                $user = auth()->user();
                $isManager = $project
                    ->users()
                    ->where('user_id', $user->id)
                    ->wherePivot('project_role', 'Project Manager')
                    ->exists();
            @endphp

            @if ($user->role === 'Admin/PI' || $isManager)
                {{-- Icona Modifica --}}
                <a href="{{ route('project.edit', $project->id) }}"
                    class="text-emerald-700 transition transform hover:scale-150" title="Modifica Progetto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-8 fill-current">
                        <path
                            d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z" />
                    </svg>
                </a>

                {{-- Icona Elimina --}}
                <form action="{{-- {{ route('project.destroy', $project->id) }} --}}" method="POST"
                    onsubmit="return confirm('Sei sicuro di voler eliminare l\'intero progetto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 transition transform hover:scale-150"
                        title="Elimina Progetto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-7 fill-current">
                            <path
                                d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

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

        {{-- file del progetto --}}
        <div class="lg:col-span-1">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
                Allegati del progetto
            </h2>
            @foreach ($project->attachments as $attachment)
                <div class="border p-2 rounded shadow-sm">
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" download>
                        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                            class="w-full h-32 object-cover hover:opacity-80 transition">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="lg:col-span-1">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
                Descrizione del progetto
            </h2>
            <div class="border p-2 rounded shadow-sm">
                <p>
                    {{ $project->description }}
                </p>
            </div>
        </div>





    </div>
