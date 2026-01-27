@php

    $userProjectRole = $task->project
        ->users()
        ->where('user_id', auth()->id())
        ->first()?->pivot->project_role;

    $isManager = auth()->user()->role === 'Admin/PI' || $userProjectRole === 'Project Manager';
@endphp



<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6">Modifica Task</h2>

    <form action="{{ route('task.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($isManager)
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Titolo</label>
                <input type="text" name="title" value="{{ $task->title }}" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-2 text-blue-600">Stato Avanzamento</label>
                <select name="status" class="w-full border-2 border-blue-500 p-2 rounded">
                    <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>In attesa</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In corso</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completato</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Descrizione</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ $task->description }}</textarea>
            </div>
        @else
            {{-- VISTA UTENTE: Vede titolo/descrizione ma cambia solo lo stato --}}
            <div class="mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase">Task</h3>
                <p class="text-lg text-gray-800 mb-4">{{ $task->title }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-2 text-blue-600">Aggiorna Stato</label>
                <select name="status" class="w-full border-2 border-blue-500 p-2 rounded">
                    <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>In attesa</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In corso</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completato</option>
                </select>
            </div>
        @endif

        {{-- Bottoni comuni (devono stare fuori dall'if o in entrambi) --}}
        <div class="flex justify-between mt-6 pt-4 border-t">
            <a href="{{ route('task.show', $task->id) }}" class="text-gray-500 pt-2 hover:underline">Annulla</a>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors">
                Salva Modifiche
            </button>
        </div>
    </form>
</div>
