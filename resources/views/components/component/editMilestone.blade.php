<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Modifica Milestone: {{ $milestone->title }}</h2>

        <hr class="mb-8">

        {{-- 2. FORM PRINCIPALE (Dati e Nuovi Allegati) --}}
        <form action="{{ route('milestones.update', $milestone) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                {{-- Titolo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titolo della milestone</label>
                    <input type="text" name="title" value="{{ old('title', $milestone->title) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- stato --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stato Milestone</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        {{-- Value 0 corrisponde a False (In corso/Pending) --}}
                        <option value="0" {{ $milestone->status == 0 ? 'selected' : '' }}>
                            In Corso (Pending)
                        </option>

                        {{-- Value 1 corrisponde a True (Completata) --}}
                        <option value="1" {{ $milestone->status == 1 ? 'selected' : '' }}>
                            Completata
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Fine Prevista</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $milestone->due_date) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>


            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('project.show', $milestone->project_id) }}"
                    class="px-4 py-2 bg-gray-100 rounded-md">Annulla</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Salva Modifiche</button>
            </div>
    </div>
    </form>
</div>
</div>
