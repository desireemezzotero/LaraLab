<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Modifica Progetto: {{ $project->title }}</h2>

        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-sm font-semibold mb-4 text-gray-600 uppercase">Allegati Attuali</h3>

            <div class="grid grid-cols-3 gap-4">
                @foreach ($project->attachments as $attachment)
                    <div class="border p-2 bg-white rounded shadow-sm">
                        <img src="{{ asset('storage/' . $attachment->file_path) }}"
                            class="w-full h-24 object-cover rounded">

                        <form action="{{ route('attachment.destroy', $attachment->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Eliminare questa foto?')"
                                class="bg-red-500 text-white text-xs px-2 py-1 rounded w-full">
                                Elimina
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="my-8 border-gray-200">

        <form action="{{ route('project.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                {{-- Titolo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titolo del Progetto</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- Descrizione --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descrizione</label>
                    <textarea name="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stato</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Attivo</option>
                            <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>In Pausa
                            </option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>
                                Completato
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data Fine Prevista</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                {{-- Caricamento Nuovi File --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aggiungi nuove foto</label>
                    <input type="file" name="attachments[]" multiple
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('project.show', $project) }}"
                        class="px-4 py-2 bg-gray-100 rounded-md">Annulla</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Salva Modifiche</button>
                </div>
            </div>
        </form>
    </div>
</div>
