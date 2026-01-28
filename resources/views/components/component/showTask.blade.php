{{-- TASK ASSEGNATO AL PROGETTO --}}
<div class="px-6 m-10 ">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:border-blue-300 transition-all">
        <div class="items-center pb-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-xs text-gray-500 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Creato il: {{ $task->created_at->format('d/m/Y') }}
                </div>

                <h4 class="text-lg font-bold text-gray-800 tracking-tight">
                    {{ $task->title }}
                </h4>



                {{-- DETTAGLIO, STATO E TAG DEI TASK --}}
                <div class="flex items-center text-xs text-gray-500 mt-1">
                    {{-- Dettaglio --}}

                    <a href="{{ route('task.show', $task->id) }}"
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Dettagli
                    </a>

                    {{-- Stato del Task --}}
                    <div class="col-span-3 flex ml-2 mr-2">
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
                    <div class="col-span-3 flex">
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

        {{-- SEZIONE DESCRIZIONE --}}
        <div class="mt-4">
            <h5 class="text-s font-bold text-gray-400 uppercase mb-2">Descrizione</h5>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $task->description ?: 'Nessuna descrizione disponibile per questo task.' }}
            </p>
        </div>

        {{-- SEZIONE COMMENTI --}}
        <div class="mt-6 pt-4 border-t border-gray-50">
            @include('components.component.comments')
        </div>
    </div>
</div>
