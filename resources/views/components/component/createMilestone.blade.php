<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Aggiungi un nuovo milestone </h2>

        <hr class="mb-8">

        <form action="{{ route('milestones.store', $project) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                {{-- Titolo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titolo della milestone</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>

                {{-- stato --}}
                {{-- Stato (Default: In Corso) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stato Iniziale</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="0" selected>In Corso</option>
                        <option value="1">Già Completata</option>
                    </select>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Fine Prevista</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" min="{{ date('Y-m-d') }} "
                        max="2027-12-31" required>
                </div>
            </div>


            <div class="flex
                        justify-end space-x-3 mt-6">
                <a href="{{ route('project.show', $project) }}" class="px-4 py-2 bg-gray-100 rounded-md">Annulla</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Salva Modifiche</button>
            </div>
    </div>
    </form>
</div>
</div>
