@extends('.layouts.master')

@section('component')
    <div class="container mx-auto overflow-hidden">
        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-black text-slate-800 text-center p-4">Pubblicazioni generali</h1>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-10">
                <path
                    d="M360 160L280 160C266.7 160 256 149.3 256 136C256 122.7 266.7 112 280 112L360 112C373.3 112 384 122.7 384 136C384 149.3 373.3 160 360 160zM360 208C397.1 208 427.6 180 431.6 144L448 144C456.8 144 464 151.2 464 160L464 512C464 520.8 456.8 528 448 528L192 528C183.2 528 176 520.8 176 512L176 160C176 151.2 183.2 144 192 144L208.4 144C212.4 180 242.9 208 280 208L360 208zM419.9 96C407 76.7 385 64 360 64L280 64C255 64 233 76.7 220.1 96L192 96C156.7 96 128 124.7 128 160L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 160C512 124.7 483.3 96 448 96L419.9 96z" />
            </svg>

            <a href="{{ route('publication.create') }}">
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
                        <th class="px-6 py-3">Titolo </th>
                        <th class="px-6 py-3">Stato</th>
                        <th class="px-6 py-3">Descrizione</th>
                        <th class="px-6 py-3">Progetti associati</th>
                        <th class="px-6 py-3">Team</th>
                        <th class="px-6 py-3">Visualizza</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($publications as $publication)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $publication->title }}</td>

                            <td class="px-6 py-4">
                                @switch($publication->status)
                                    @case('drafting')
                                        <span class="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1 rounded-full">In
                                            stesura</span>
                                    @break

                                    @case('submitted')
                                        <span
                                            class="bg-blue-100 text-indigo-600 text-xs font-bold px-3 py-1
                                            rounded-full">Inviato</span>
                                    @break

                                    @case('published')
                                        <span
                                            class="bg-green-100 text-green-600 text-xs font-bold px-3 py-1 rounded-full">Pubblicato</span>
                                    @break

                                    @case('accepted')
                                        <span
                                            class="bg-green-200 text-green-900 text-xs font-bold px-3 py-1 rounded-full">Accettato</span>
                                    @break
                                @endswitch
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($publication->description, 50) }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @foreach ($publication->projects as $project)
                                    <span class="block text-blue-600">{{ $project->title }}</span>
                                @endforeach
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @foreach ($publication->authors as $author)
                                    <span
                                        class="inline-block bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-[10px] mr-1 mb-2">
                                        {{ $author->name }}
                                    </span>
                                @endforeach
                            </td>

                            <td>
                                <a href="{{ route('publication.show', $publication->id) }}"
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Dettagli
                                </a>
                            </td>

                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                    Nessuna pubblicazione trovata.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
