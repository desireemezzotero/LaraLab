<div class="p-4 mx-auto container">

    <div class="mb-8 flex items-center justify-between">

        <div class="w-24 hidden lg:block"></div>

        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Progetto: {{ $publication->title }}
        </h1>

        <div class="w-24 flex justify-end items-center space-x-3">
            {{--  @include('.components.component.projectIconShow') --}}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold mb-6 flex items-center text-gray-800">
                <span
                    class="flex h-3 w-3 rounded-full mr-3 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)] animate-pulse"></span>
                Team di Ricerca
            </h2>

            <div class="space-y-4">
                @foreach ($publication->authors as $user)
                    {{-- GRID A 3 COLONNE: 10% numero, 60% dati, 30% ruolo --}}
                    <div
                        class="grid grid-cols-10 items-center p-3 rounded-xl hover:bg-gray-50 transition-all border border-transparent">

                        {{-- 1. SINISTRA: Numero Posizione (Colspan 1) --}}
                        <div class="col-span-1 flex justify-start">
                            <span class="text-xs font-black text-gray-400">
                                #{{ $user->pivot->position }}
                            </span>
                        </div>

                        {{-- 2. CENTRO: Dati Utente (Colspan 6) --}}
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

                    {{-- Divisore leggero tra le righe, tranne l'ultima --}}
                    @if (!$loop->last)
                        <div class="border-b border-gray-50 mx-2"></div>
                    @endif
                @endforeach
            </div>
        </div>


        {{-- fVEDERE SE CI SONO I ile del progetto --}}
        <div class="lg:col-span-1">
            {{--    @include('.components.component.projectCardShowFile' --}}

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


        <div class="lg:col-span-2">

            @if (auth()->user()->role === 'Admin/PI')
                <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Zona Pericolosa</h3>
                        <p class="text-xs text-red-600">L'eliminazione è irreversibile.</p>
                    </div>

                    <form action="{{ route('publication.destroy', $publication->id) }}" method="POST"
                        onsubmit="return confirm('Sei sicuro di voler eliminare questa pubblicazione?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                            Elimina Pubblicazione
                        </button>
                    </form>
                </div>
            @endif

            {{--   @include('.components.component.projectCardShowMileTask') --}}

        </div>
    </div>
</div>
