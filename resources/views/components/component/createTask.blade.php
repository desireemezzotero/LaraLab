<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Crea una nuova task</h2>
        <p class="text-sm text-blue-600 font-semibold mb-6 uppercase tracking-wider">
            Progetto: {{ $project->title }}
        </p>

        <hr class="mb-8">

        <form action="{{ route('project.task.store', $project->id) }}" method="POST">
            @csrf
            {{-- Campo nascosto per passare l'ID del progetto --}}
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Titolo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Titolo della task</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>

                {{-- Descrizione --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Descrizione</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                </div>

                {{-- Assegnazione Utente (Membri del Progetto) --}}
                <div>
                    <label class="block text-sm text-gray-700 font-bold mb-3">Assegna ai membri del progetto</label>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-2 p-4 border rounded-md bg-gray-50 max-h-48 overflow-y-auto">
                        @foreach ($project->users as $user)
                            <label
                                class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm border cursor-pointer hover:bg-blue-50 transition">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                    class="rounded text-blue-600 focus:ring-blue-500"
                                    {{ is_array(old('user_ids')) && in_array($user->id, old('user_ids')) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">
                                    <span class="font-medium">{{ $user->name }}</span>
                                    <br>
                                    <small class="text-gray-500">{{ $user->pivot->project_role }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('user_ids')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Milestone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Milestone</label>
                    <select name="milestone_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach ($project->milestones as $milestone)
                            <option value="{{ $milestone->id }}"
                                {{ old('milestone_id') == $milestone->id ? 'selected' : '' }}>
                                {{ $milestone->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Stato --}}
                <div>
                    <label class="block text-sm text-gray-700 font-bold">Stato
                        Avanzamento</label>
                    <select name="status"
                        class="mt-1 block w-full border-2 border-blue-500 p-2 rounded-md focus:ring-blue-500">
                        <option value="to_do" {{ old('status') == 'to_do' ? 'selected' : '' }}>In attesa</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In corso
                        </option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completato
                        </option>
                    </select>
                </div>

                {{-- Tag --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tag categoria</label>
                    <select name="tag"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="lab">🧪 Laboratorio</option>
                        <option value="writing">✍️ Stesura documenti</option>
                        <option value="research">🔍 Ricerca</option>
                        <option value="coding">👨‍💻 Sviluppo software</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('project.show', $project) }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">Annulla</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 shadow-lg transition">
                    Crea Task
                </button>
            </div>
        </form>
    </div>
</div>
