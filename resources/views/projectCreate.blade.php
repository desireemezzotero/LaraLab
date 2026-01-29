@extends('.layouts.master')

@section('component')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Aggiungi un nuovo progetto
        </h1>

        <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="publication_id" value="{{ $publicationId }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Titolo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Titolo Progetto</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition"
                        placeholder="Inserisci il nome del progetto..." required>
                </div>

                {{-- Descrizione --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Descrizione</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition"
                        placeholder="Di cosa si occupa il progetto?" required>{{ old('description') }}</textarea>
                </div>

                {{-- Obiettivi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Obiettivi</label>
                    <textarea name="objectives" rows="2"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition"
                        placeholder="Quali sono i traguardi previsti?" required>{{ old('objectives') }}</textarea>
                </div>

                {{-- Data Inizio --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Data Inizio</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition"
                        required>
                </div>

                {{-- Data Fine --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Data Fine (opzionale)</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition">
                </div>

                {{-- Stato --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Stato Iniziale</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Attivo</option>
                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>⏳ In Pausa</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>🏆 Completato
                        </option>
                    </select>
                </div>

                {{-- Selezione Team --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Assegna Team e Ruoli (Minimo 2
                        utenti)</label>
                    <div class="border rounded-xl bg-gray-50 overflow-hidden">
                        <div class="max-h-64 overflow-y-auto p-4 space-y-3">
                            @foreach ($users as $user)
                                <div
                                    class="flex flex-col md:flex-row md:items-center justify-between bg-white p-3 rounded-lg border border-gray-200 shadow-sm gap-4">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                            id="user_{{ $user->id }}"
                                            class="h-5 w-5 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300 transition cursor-pointer">
                                        <label for="user_{{ $user->id }}" class="cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-800">{{ $user->name }}</span>
                                            <span class="block text-xs text-gray-500 italic">Ruolo App:
                                                {{ $user->role }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <label class="text-[10px] uppercase font-black text-gray-400">Ruolo
                                            Progetto:</label>
                                        <select name="project_roles[{{ $user->id }}]"
                                            class="text-xs border-gray-200 rounded-md focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50">
                                            <option value="Researcher">Ricercatore</option>
                                            <option value="Project Manager">Project Manager</option>
                                            <option value="Collaborator">Colleaboratore</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('users')
                        <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Allegati --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Allegati Documentazione</label>
                    <div class="mt-2 p-4 border-2 border-dashed border-gray-300 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Aggiungi allegati (Immagini, PDF, Documenti)
                        </label>

                        {{-- Ho rimosso 'sr-only' e aggiunto 'cursor-pointer' --}}
                        <input type="file" name="attachments[]" multiple
                            class="block w-full text-sm text-gray-500 cursor-pointer
                   file:mr-4 file:py-2 file:px-4 
                   file:rounded-full file:border-0 
                   file:text-sm file:font-semibold 
                   file:bg-blue-50 file:text-blue-700 
                   hover:file:bg-blue-100">

                        <p class="mt-2 text-xs text-gray-400">
                            Puoi selezionare più file contemporaneamente. Formati supportati: JPG, PNG, PDF, DOCX, ZIP.
                        </p>
                    </div>
                </div>
            </div>


            {{-- Pulsanti Azione --}}
            <div class="flex justify-end space-x-3 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ url()->previous() }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition shadow-sm">
                    Annulla
                </a>
                <button type="submit"
                    class="px-8 py-2.5 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                    Crea Progetto
                </button>
            </div>
    </div>
    </form>
@endsection
