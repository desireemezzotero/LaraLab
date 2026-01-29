@php
    $currentUserProjectRole = $project
        ->users()
        ->where('user_id', auth()->id())
        ->first()?->pivot->project_role;
@endphp

<h2 class="text-lg font-semibold mb-3 flex items-center">
    <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
    Milestoni assegnate a questo progetto
    <a href="{{ route('milestones.create', $project->id) }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="text-black h-5 ml-2">
            <path
                d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
        </svg>
    </a>
</h2>


{{-- MILESTONI ASSEGANTE AL PROGETTO  --}}
@foreach ($project->milestones as $milestone)
    <div class="px-6 mb-4">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:border-blue-300 transition-all">
            <div class="grid grid-cols-12 items-center w-full">

                <div class="col-span-6">
                    <h4 class="text-base font-bold text-gray-800 tracking-tight truncate">
                        {{ $milestone->title }}
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Scadenza: {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="col-span-3 flex justify-center">
                    @if ($milestone->status == '0')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-amber-500"></span>
                            In corso
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-emerald-500"></span>
                            Completato
                        </span>
                    @endif
                </div>
                @if ($isManager)
                    <div class="col-span-3 flex justify-end space-x-4">
                        @include('components.component.milestoneIconModify')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach



{{-- TASK ASSEGNATE AL MANAGER --}}
@if ($isManager)
    <h2 class="text-lg font-semibold mb-3 flex items-center">
        <span class="flex w-3 h-3 rounded-full mr-2"></span>
        📊 Task assegnati al progetto

        <a href="{{ route('project.task.create', ['project' => $project->id]) }}"
            class="group ml-2 p-1 hover:bg-gray-100 rounded-full transition-all" title="Crea nuovo task">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                class="fill-current text-gray-700 group-hover:text-blue-600 h-5 w-5">
                <path
                    d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
            </svg>
        </a>
    </h2>
    @foreach ($otherTasks as $task)
        <div class="px-6 mb-4">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:border-blue-300 transition-all">
                <div class="grid grid-cols-12 items-center w-full">
                    <div class="col-span-6">
                        <h4 class="text-base font-bold text-gray-800 tracking-tight truncate">
                            {{ $task->title }}
                        </h4>

                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <a href="{{ route('task.show', $task->id) }}"
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Dettagli
                            </a>
                        </div>

                    </div>

                    {{-- Stato del Task --}}
                    <div class="col-span-3 flex justify-center">
                        @switch($task->status)
                            @case('to_do')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-slate-400"></span>
                                    In attesa
                                </span>
                            @break

                            @case('in_progress')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    In corso
                                </span>
                            @break

                            @case('completed')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-emerald-500"></span>
                                    Completato
                                </span>
                            @break
                        @endswitch
                    </div>

                    {{-- Tag del Task --}}
                    <div class="col-span-3 flex justify-end">
                        @switch($task->tag)
                            @case('lab')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    🧪 Laboratorio
                                </span>
                            @break

                            @case('writing')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-600 border border-cyan-100">
                                    ✍️ Scrittura
                                </span>
                            @break

                            @case('research')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600 border border-orange-100">
                                    🔍 Ricerca
                                </span>
                            @break

                            @case('coding')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    👨‍💻 Sviluppo
                                </span>
                            @break

                            @default
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-100">
                                    📌 Task
                                </span>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif




@if (auth()->user()->role !== 'Admin/PI')
    {{-- TASK ASSEGANTE A ME  --}}
    <h2 class="text-lg font-semibold mb-3 flex items-center">
        <span class="flex w-3 h-3 rounded-full mr-2"></span>
        🚀 Task assegnati a me
    </h2>

    @forelse ($myTasks as $task)
        <div class="px-6 mb-4">
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:border-blue-300 hover:shadow-md transition-all">
                <div class="grid grid-cols-12 items-center w-full gap-4">

                    {{-- Info Task --}}
                    <div class="col-span-6">
                        <h4 class="text-base font-bold text-gray-800 tracking-tight truncate">
                            {{ $task->title }}
                        </h4>
                        <div class="flex items-center mt-2 space-x-2">
                            <a href="{{ route('task.show', $task->id) }}"
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Dettagli
                            </a>
                        </div>
                    </div>

                    {{-- Stato del Task --}}
                    <div class="col-span-3 flex justify-center">
                        @switch($task->status)
                            @case('to_do')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-slate-400"></span>
                                    In attesa
                                </span>
                            @break

                            @case('in_progress')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    In corso
                                </span>
                            @break

                            @case('completed')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-emerald-500"></span>
                                    Completato
                                </span>
                            @break
                        @endswitch
                    </div>

                    {{-- Tag del Task --}}
                    <div class="col-span-3 flex justify-end">
                        @switch($task->tag)
                            @case('lab')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    🧪 Laboratorio
                                </span>
                            @break

                            @case('writing')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-600 border border-cyan-100">
                                    ✍️ Scrittura
                                </span>
                            @break

                            @case('research')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600 border border-orange-100">
                                    🔍 Ricerca
                                </span>
                            @break

                            @case('coding')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    👨‍💻 Sviluppo
                                </span>
                            @break

                            @default
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-100">
                                    📌 Task
                                </span>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="px-6">
                <div
                    class="flex flex-col items-center justify-center p-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500 italic text-sm text-center">
                        Non hai task
                    </p>
                </div>
            </div>
        @endforelse
    @endif
