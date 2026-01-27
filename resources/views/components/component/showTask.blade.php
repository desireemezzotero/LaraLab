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

                <div class="flex justify-center">
                    @if ($task->status === 'to_do')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-red-500"></span> In attesa
                        </span>
                    @elseif($task->status === 'completed')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-emerald-500"></span> Completato
                        </span>
                    @elseif($task->status === 'in_progress')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                            <span class="w-2 h-2 mr-2 rounded-full bg-amber-500"></span> In corso
                        </span>
                    @endif
                    <div class="col-span-3 flex justify-center ml-2">
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

        {{-- SEZIONE DESCRIZIONE --}}
        <div class="mt-4">
            <h5 class="text-xs font-semibold text-gray-400 uppercase mb-2">Descrizione</h5>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $task->description ?: 'Nessuna descrizione disponibile per questo task.' }}
            </p>
        </div>

        {{-- SEZIONE COMMENTI --}}
        <div class="mt-6 pt-4 border-t border-gray-50">
            <h5 class="text-xs font-semibold text-gray-400 uppercase mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Commenti ({{ $task->comments->count() }})
            </h5>

            <div class="space-y-3">
                @forelse ($task->comments as $comment)
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold text-gray-700">{{ $comment->user->name }}</span>
                            <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-600">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">Ancora nessun commento.</p>
                @endforelse
            </div>

            <a href="{{ route('task.edit', $task->id) }}">modifica</a>
        </div>
    </div>
</div>
