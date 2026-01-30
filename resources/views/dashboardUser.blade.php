@extends('.layouts.master')

@section('component')
    <div class="container mx-auto overflow-hidden">
        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-black text-slate-800 text-center p-4">Utenti appartenenti al progetto</h1>

            <a href="{{ route('user.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="text-black h-5 ml-2">
                    <path
                        d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-100">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                    <tr>
                        <th class="px-6 py-3">Nome </th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Ruolo</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $user->name }}</td>

                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->role }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
