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
                @if (auth()->user()->role === 'Admin/PI' || $currentUserProjectRole === 'Project Manager')
                    <div class="col-span-3 flex justify-end space-x-4">
                        @include('components.component.milestoneIconModify')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

<h2 class="text-lg font-semibold mb-3 flex items-center">
    <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
    Task assegnate a te per questo progetto

    {{-- Solo se l'utente è Admin o PM (opzionale se hai già il controllo nel Controller) --}}
    @if (auth()->user()->role === 'Admin/PI' ||
            $project->users()->where('user_id', auth()->id())->first()?->pivot->project_role === 'Project Manager')
        <a href="{{ route('project.task.create', ['project' => $project->id]) }}"
            class="group ml-2 p-1 hover:bg-gray-100 rounded-full transition-all" title="Crea nuovo task">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                class="fill-current text-gray-700 group-hover:text-blue-600 h-5 w-5">
                <path
                    d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
            </svg>
        </a>
    @endif
</h2>



{{-- TASK ASSEGANTE AL PROGETTO  --}}
@forelse ($project->tasks as $task)
    <div class="px-6 mb-4">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:border-blue-300 transition-all">
            <div class="grid grid-cols-12 items-center w-full">
                <div class="col-span-6">
                    <h4 class="text-base font-bold text-gray-800 tracking-tight truncate">
                        {{ $task->title }}
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1">
                        <a href="{{ route('task.show', $task->id) }}">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">
                                <span class="w-2 h-2 mr-2 rounded-full bg-red-500"></span>
                                Visualizza dettagli
                            </span>
                        </a>
                    </div>
                </div>

                {{-- gestione dello stato dei task --}}
                <div class="col-span-3 flex justify-center">
                    @if ($task->status === 'to_do')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-red-500"></span>
                            In attesa
                        </span>
                    @elseif($task->status === 'completed')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-emerald-500"></span>
                            Completato
                        </span>
                    @elseif($task->status === 'in_progress')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-amber-500"></span>
                            In corso
                        </span>
                    @endif
                </div>

                {{-- gestione dei tag  --}}
                <div class="col-span-3 flex justify-center">
                    @if ($task->status !== 'completed')
                        @if ($task->tag == 'lab')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-500 border border-indigo-200">
                                🧪
                                Laboratorio
                            </span>
                        @elseif($task->tag == 'writing')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-600 border border-cyan-200">
                                ✍️ Stesura documenti
                            </span>
                        @elseif($task->tag == 'research')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                🔍 In fase di studio
                            </span>
                        @elseif($task->tag == 'coding')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-200">
                                👨‍💻 Sviluppo software
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="px-6">
        <p class="text-gray-500 italic text-sm p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            Non ci sono task assegnati a te per questo progetto.
        </p>
    </div>
@endforelse
