<div class="p-4 mx-auto container">

    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Ecco il tuo progetto {{ $project->title }}</h1>
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


            {{-- OBIETTIVI ASSEGANTE AL PROGETTO IN GENERALE --}}
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

        <div class="lg:col-span-1">

            @foreach ($project->attachments as $attachment)
                <div class="border p-2 rounded shadow-sm">
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                            class="w-full h-32 object-cover hover:opacity-80 transition">
                    </a>
                </div>
            @endforeach


            <a href="#"
                class="bg-neutral-primary-soft block max-w-sm p-6 border border-default rounded-base shadow-xs hover:bg-neutral-secondary-medium">
                <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">Noteworthy technology
                    acquisitions 2021</h5>
                <p class="text-body">Here are the biggest technology acquisitions of 2025 so far, in reverse
                    chronological order.</p>
            </a>
        </div>

        <a href="{{ route('project.edit', $project->id) }}">
            modifica
        </a>

    </div>
