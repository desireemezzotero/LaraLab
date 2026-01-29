@extends('.layouts.master')

@section('component')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Aggiungi una nuova pubblicazione
        </h1>

        <form action="{{ route('publication.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Titolo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Titolo Pubblicazione</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Inserisci il titolo della pubblicazione..." required>
                </div>

                {{-- Descrizione --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Descrizione / Abstract</label>
                    <textarea name="description" rows="4"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Inserisci un breve riassunto della pubblicazione..." required>{{ old('description') }}</textarea>
                </div>

                {{-- Stato --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Stato Pubblicazione</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        <option value="drafting" {{ old('status') == 'drafting' ? 'selected' : '' }}>📝 In Stesura
                            (Drafting)</option>
                        <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>✉️ Inviata
                            (Submitted)</option>
                        <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>✅ Accettata (Accepted)
                        </option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>📚 Pubblicata
                            (Published)</option>
                    </select>
                </div>

                {{-- Selezione Autori --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Assegna Autori e Ordine di Posizione</label>
                    <div class="border rounded-xl bg-gray-50 overflow-hidden">
                        <div class="max-h-64 overflow-y-auto p-4 space-y-3">
                            @foreach ($users as $user)
                                <div
                                    class="flex flex-col md:flex-row md:items-center justify-between bg-white p-3 rounded-lg border border-gray-200 shadow-sm gap-4">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="authors[]" value="{{ $user->id }}"
                                            id="user_{{ $user->id }}"
                                            class="h-5 w-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 transition cursor-pointer">
                                        <label for="user_{{ $user->id }}" class="cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-800">{{ $user->name }}</span>
                                            <span class="block text-xs text-gray-500">{{ $user->email }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <label class="text-[10px] uppercase font-black text-gray-400">Posizione:</label>
                                        <input type="number" name="positions[{{ $user->id }}]" value="1"
                                            min="1"
                                            class="w-16 text-xs border-gray-200 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-50 p-1 text-center">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('authors')
                        <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Allegati Polimorfici --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Allegati Pubblicazione (PDF, Docx,
                        Immagini)</label>
                    <div class="mt-2 p-4 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Seleziona i file da caricare
                        </label>

                        <input type="file" name="attachments[]" multiple
                            class="block w-full text-sm text-gray-500 cursor-pointer
                            file:mr-4 file:py-2 file:px-4 
                            file:rounded-full file:border-0 
                            file:text-sm file:font-semibold 
                            file:bg-blue-50 file:text-blue-700 
                            hover:file:bg-blue-100">

                        <p class="mt-2 text-xs text-gray-400">
                            Dimensione massima per file: 5MB. Puoi caricare più file.
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
                    class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                    Salva Pubblicazione
                </button>
            </div>
        </form>
    </div>
@endsection
