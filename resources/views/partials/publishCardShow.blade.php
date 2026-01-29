<div class="p-4 mx-auto container">

    <div class="mb-8 flex items-center justify-between">

        <div class="w-24 hidden lg:block"></div>

        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Pubblicazione: {{ $publication->title }}
        </h1>

        {{-- ICONE DI MODIFICA ED ELIMINA --}}
        <div class="w-24 flex justify-end items-center space-x-3">
            @if (auth()->user()->role === 'Admin/PI')
                <div class="w-24 flex justify-end items-center space-x-3">


                    {{-- modifica --}}
                    <a href="{{ route('publication.edit', $publication->id) }}"
                        class="text-emerald-700 transition transform hover:scale-150" title="Modifica Progetto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-8 fill-current">
                            <path
                                d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z" />
                        </svg>
                    </a>

                    {{-- Icona Elimina --}}

                    <form action="{{ route('publication.destroy', $publication->id) }}" method="POST"
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
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- TEAM --}}
    <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center text-gray-800">
            <span
                class="flex h-3 w-3 rounded-full mr-3 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)] animate-pulse"></span>
            Team
        </h2>
        <div class="space-y-4">
            @foreach ($publication->authors as $user)
                <div
                    class="grid
                        grid-cols-10 items-center p-3 rounded-xl hover:bg-gray-50 transition-all border
                        border-transparent">


                    <div class="col-span-1 flex justify-start">
                        <span class="text-xs font-black text-gray-400">
                            #{{ $user->pivot->position }}
                        </span>
                    </div>

                    <div class="col-span-6 px-2 min-w-0">
                        <h4 class="text-sm font-bold text-gray-900 truncate">
                            {{ $user->name }}
                        </h4>
                        <p class="text-[10px] text-gray-500 truncate italic">
                            {{ $user->email }}
                        </p>
                    </div>

                    {{-- 3. DESTRA: Ruolo (Colspan 3) --}}
                    <div class="col-span-3 flex justify-end">
                        @switch($user->role)
                            @case('Admin/PI')
                                <span
                                    class="w-full max-w-[90px] text-center text-[9px] uppercase py-1 bg-red-50 text-red-600 rounded border border-red-100 font-bold tracking-tight">
                                    Principal Inv.
                                </span>
                            @break

                            @case('Researcher')
                                <span
                                    class="w-full max-w-[90px] text-center text-[9px] uppercase py-1 bg-blue-50 text-blue-600 rounded border border-blue-100 font-bold tracking-tight">
                                    Researcher
                                </span>
                            @break

                            @case('Collaborator')
                                <span
                                    class="w-full max-w-[90px] text-center text-[9px] uppercase py-1 bg-purple-50 text-purple-600 rounded border border-purple-100 font-bold tracking-tight">
                                    Collaborator
                                </span>
                            @break
                        @endswitch
                    </div>

                </div>

                @if (!$loop->last)
                    <div class="border-b border-gray-50 mx-2"></div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- FILE  + DESCRIZIONE --}}
    <div class="lg:col-span-1">
        <h2 class="text-lg font-semibold mb-3 flex items-center">
            <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
            Allegati del progetto
        </h2>


        {{-- file --}}
        <div class="grid grid-cols-1 gap-4">
            @foreach ($publication->attachments as $attachment)
                @php
                    $extension = pathinfo($attachment->file_path, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                <div class="border p-2 rounded shadow-sm bg-white relative">
                    @if ($isImage)
                        {{-- Immagine --}}
                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="block"
                            download>
                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                alt="{{ $attachment->file_name }}" class="h-32 w-full hover:opacity-80 object-contain">
                        </a>
                    @elseif (strtolower($extension) === 'pdf')
                        {{-- Caso PDF con Mini-Preview --}}
                        <div class="relative w-full h-32 overflow-hidden border rounded bg-gray-100">
                            <iframe
                                src="{{ asset('storage/' . $attachment->file_path) }}#toolbar=0&navpanes=0&scrollbar=0"
                                class="absolute top-0 left-0 w-[300%] h-[300%] origin-top-left scale-[0.33] pointer-events-none border-none">
                            </iframe>
                            {{-- Link sovrapposto correttamente chiuso --}}
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" download
                                class="absolute inset-0 z-10 flex items-end justify-center pb-1 bg-black/5 hover:bg-black/20 transition-colors">
                                <span
                                    class="bg-white/90 px-2 py-0.5 rounded text-[10px] font-bold text-red-700 shadow-sm border border-red-200">
                                    SCARICA PDF
                                </span>
                            </a>
                        </div>
                    @else
                        {{-- Caso altri file --}}
                        <div class="flex flex-col items-center justify-center h-32 bg-gray-50 rounded">
                            <span class="text-3xl">📁</span>
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                                class="text-xs text-blue-600 underline mt-2">
                                Scarica {{ $extension }}
                            </a>
                        </div>
                    @endif

                    <p class="text-[10px] text-gray-500 mt-1 truncate px-1">{{ $attachment->file_name }}</p>
                </div>
            @endforeach
        </div>

        {{-- descrizione --}}
        <div>
            <h2 class="text-lg font-semibold mb-3 flex items-center mt-5">
                <span class="flex w-3 h-3 rounded-full mr-2"></span>
                Descrizione della pubblicazione
            </h2>
            <div class="border p-1 rounded shadow-sm">
                <p>
                    {{ $publication->description }}
                </p>
            </div>
        </div>
    </div>

    @if (auth()->user()->role === 'Admin/PI')
        <div class="lg:col-span-2">

            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
                Progetti asseganti a questa pubblicazione

                {{-- creare un nuovo progetto --}}
                <a href="{{ route('project.create', ['publication_id' => $publication->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="text-black h-5 ml-2">
                        <path
                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                    </svg>
                </a>
            </h2>


            {{-- Progetti  --}}
            @foreach ($publication->projects as $project)
                <div class="px-6 mb-4">
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:border-blue-300 transition-all">
                        <div class="grid grid-cols-12 items-center w-full">
                            {{-- TITOLO + DATA FINE DEL PROGETTO --}}

                            <div class="col-span-6">
                                <h4 class="text-base font-bold text-gray-800 tracking-tight truncate">
                                    {{ $project->title }}
                                </h4>

                                {{-- stato del progetto --}}
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Scadenza: {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}
                                </div>
                            </div>

                            {{-- STATO DEL PROGETTO --}}
                            <div class="col-span-2 flex justify-center">
                                @if ($project->status === 'on_hold')
                                    <span
                                        class="bg-red-100 text-red-500 text-xs font-medium px-2.5 py-0.5 rounded-full">Sospeso</span>
                                @elseif($project->status === 'active')
                                    <span
                                        class="text-xs bg-indigo-200 text-indigo-500 font-medium px-2.5 py-0.5 rounded-full">Attivo</span>
                                @elseif($project->status === 'completed')
                                    <span
                                        class="bg-green-100 text-green-500 text-xs font-medium px-2.5 py-0.5 rounded-full">Completato</span>
                                @endif

                            </div>

                            {{-- DETTAGLI DEL PROGETTO --}}
                            <div class="col-span-2 flex justify-center">
                                <a href="{{ route('project.show', $project->id) }}"
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


                            {{-- MODIFICARE  + ELIMINARE I PROGETTI --}}

                            <div class="col-span-2 flex justify-end space-x-4">
                                {{-- Icona Modifica --}}
                                <a href="{{ route('project.edit', $project->id) }}"
                                    class="transition transform hover:scale-150" title="Modifica Progetto">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                        class="h-5 fill-current">
                                        <path
                                            d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z" />
                                    </svg>
                                </a>

                                {{-- Icona Elimina --}}

                                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Sei sicuro di voler eliminare la milestone?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="transition transform hover:scale-150"
                                        title="Elimina Progetto">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                            class="h-5 fill-current">
                                            <path
                                                d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

    @endif
</div>
</div>
