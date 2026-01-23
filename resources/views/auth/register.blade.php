@extends('.layouts.master')

@section('component')
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">

        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-100">

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Registrati
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Entra a far parte anche tu dei nostri progetti
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
                    <x-text-input id="name"
                        class="block mt-1 w-full border-gray-300 focus:ring-emerald-600 focus:border-emerald-600"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                    <x-text-input id="email"
                        class="block mt-1 w-full border-gray-300 focus:ring-emerald-600 focus:border-emerald-600"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="role" :value="__('Ruolo nel Laboratorio')" class="text-gray-700 font-semibold" />
                    <select id="role" name="role"
                        class="block mt-1 w-full border-gray-300  focus:ring-emerald-600 focus:border-emerald-600 rounded-md shadow-sm py-2 px-3 text-gray-700 bg-white">
                        <option value="" disabled selected>Seleziona un ruolo</option>
                        <option value="Admin/PI">Admin/PI</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="Researcher">Researcher</option>
                        <option value="Collaborator">Collaborator</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border-gray-300  focus:ring-emerald-600 focus:border-emerald-600"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border-gray-300 focus:ring-emerald-600 focus:border-emerald-600"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Footer del Form --}}
                <div class="flex flex-col space-y-4">
                    <x-primary-button
                        class="w-full flex justify-center py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition duration-200">
                        {{ __('Registrati') }}
                    </x-primary-button>

                    <div class="text-center">
                        <a class="text-sm text-emerald-600 hover:text-emerald-500 font-medium" href="{{ route('login') }}">
                            {{ __('Già registrato?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
