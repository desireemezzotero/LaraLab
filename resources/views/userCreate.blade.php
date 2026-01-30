@extends('.layouts.master')

@section('component')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Registra un nuovo utente
        </h1>

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                {{-- Nome Completo --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700">Nome Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Es. Mario Rossi" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700">Indirizzo Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="mario.rossi@esempio.it" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ruolo Sistema --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Ruolo Sistema</label>
                    <select name="role"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        <option value="Researcher" {{ old('role') == 'Researcher' ? 'selected' : '' }}>🧪 Ricercatore
                            (Researcher)</option>
                        <option value="Admin/PI" {{ old('role') == 'Admin/PI' ? 'selected' : '' }}>👑 Admin / Principal
                            Investigator</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Minimo 8 caratteri" required>
                </div>

                {{-- Conferma Password --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700">Conferma Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Ripeti la password" required>
                </div>

                @error('password')
                    <div class="md:col-span-2">
                        <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                    </div>
                @enderror

                <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-100 mt-2">
                    <p class="text-xs text-blue-700">
                        <strong>Nota:</strong> Una volta creato l'account, l'utente potrà accedere immediatamente con
                        l'email e la password fornite. Assicurati che l'email sia corretta.
                    </p>
                </div>
            </div>

            {{-- Pulsanti Azione --}}
            <div class="flex justify-end space-x-3 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('user.index') }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition shadow-sm">
                    Annulla
                </a>
                <button type="submit"
                    class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                    Crea Utente
                </button>
            </div>
        </form>
    </div>
@endsection
