@extends('.layouts.master')

@section('component')
    @php
        $isAdmin = auth()->user()?->role === 'Admin/PI';
    @endphp

    <div class="container mx-auto pb-10 pt-5">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Modifica Pubblicazione: {{ $publication->title }}
        </h1>
        @if ($isAdmin)
            {{-- Admin --}}

            {{-- Visualizzazione Allegati Esistenti --}}
            <div class="grid grid-cols-3 gap-4 mb-8">
                @foreach ($publication->attachments as $attachment)
                    <div class="relative border p-2 rounded bg-gray-50">
                        {{-- Anteprima --}}
                        @if (Str::endsWith($attachment->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                class="w-full h-24 object-cover rounded">
                        @else
                            <div class="w-full h-24 flex items-center justify-center bg-gray-200 rounded">
                                <span class="text-xs text-gray-500">File Documento</span>
                            </div>
                        @endif

                        {{-- Bottone Elimina --}}
                        <button type="button"
                            onclick="event.preventDefault(); if(confirm('Eliminare?')) { document.getElementById('delete-att-{{ $attachment->id }}').submit(); }"
                            class="mt-2 bg-red-500 text-white text-xs px-2 py-1 rounded w-full hover:bg-red-700 transition">
                            Elimina
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- Form "invisibili" fuori dal form principale per non annidarli --}}
            @foreach ($publication->attachments as $attachment)
                <form id="delete-att-{{ $attachment->id }}" action="{{ route('attachment.destroy', $attachment->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

            <form action="{{ route('publication.update', $publication->id) }}" method="POST" enctype="multipart/form-data"
                onsubmit="this.submit_btn.disabled = true;">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-xl shadow-lg">

                    {{-- Titolo --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Titolo</label>
                        <input type="text" name="title" value="{{ old('title', $publication->title) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    {{-- Descrizione --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Descrizione</label>
                        <textarea name="description" rows="4"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description', $publication->description) }}</textarea>
                    </div>


                    {{-- Team Autori --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Autori e Posizioni</label>
                        <div class="border rounded-lg bg-gray-50 max-h-60 overflow-y-auto p-4 space-y-2">
                            @foreach ($users as $user)
                                @php
                                    $author = $publication->authors->find($user->id);
                                    $isAuthor = !is_null($author);
                                    $position = $isAuthor ? $author->pivot->position : 1;
                                @endphp
                                <div class="flex items-center justify-between bg-white p-2 rounded border shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="authors[]" value="{{ $user->id }}"
                                            id="u{{ $user->id }}" {{ $isAuthor ? 'checked' : '' }}
                                            class="rounded text-blue-600">
                                        <label for="u{{ $user->id }}"
                                            class="text-sm font-medium">{{ $user->name }}</label>
                                    </div>
                                    <input type="number" name="positions[{{ $user->id }}]"
                                        value="{{ $position }}" min="1"
                                        class="w-14 text-xs border-gray-200 rounded p-1 text-center">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Allegati --}}
                    <div class="md:col-span-2 border-t pt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Aggiungi nuovi allegati</label>
                        <input type="file" name="attachments[]" multiple class="block w-full text-sm text-gray-500">
                    </div>

                    {{-- Stato --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Stato</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            @foreach (['drafting' => 'Drafting', 'submitted' => 'Submitted', 'accepted' => 'Accepted', 'published' => 'Published'] as $val => $label)
                                <option value="{{ $val }}" {{ $publication->status == $val ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('publication.show', $publication->id) }}"
                        class="px-6 py-2 bg-gray-200 rounded-lg font-bold">Annulla</a>
                    <button type="submit" name="submit_btn"
                        class="px-8 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition">
                        Salva Modifiche
                    </button>
                </div>
            </form>
        @else
            {{-- non admin --}}
            <form action="{{ route('publication.update', $publication->id) }}" method="POST" enctype="multipart/form-data"
                onsubmit="this.submit_btn.disabled = true;">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-xl shadow-lg">
                    {{-- Stato --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Stato</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            @foreach (['drafting' => 'Drafting', 'submitted' => 'Submitted', 'accepted' => 'Accepted', 'published' => 'Published'] as $val => $label)
                                <option value="{{ $val }}" {{ $publication->status == $val ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('publication.show', $publication->id) }}"
                        class="px-6 py-2 bg-gray-200 rounded-lg font-bold">Annulla</a>
                    <button type="submit" name="submit_btn"
                        class="px-8 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition">
                        Salva Modifiche
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection
