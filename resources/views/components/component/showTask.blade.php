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



                {{-- MODIFICA, STATO E TAG DEI TASK --}}
                <div class="flex items-center text-xs text-gray-500 mt-1">
                    {{-- Modifica --}}

                    <a href="{{ route('task.edit', $task->id) }}"
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-5 fill-current mr-2">
                            <path
                                d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z" />
                        </svg>
                        Modifica
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
