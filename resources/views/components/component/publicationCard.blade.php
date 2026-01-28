<div class="container mx-auto px-4 py-12">

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-heading">Pubblicazioni</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        @foreach ($publicationPublished as $publication)
            <div
                class="bg-neutral-primary-soft flex flex-col h-full p-6 border border-default rounded-base shadow-xs hover:shadow-md transition-shadow duration-300">


                <a href="#" class="block overflow-hidden rounded-base">
                    <img class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-500"
                        src="#" alt="#" />
                </a>

                <div class="flex flex-col flex-grow">
                    <h5 class="mt-6 mb-2 text-2xl font-semibold tracking-tight text-heading">{{ $publication->title }}
                    </h5>

                    <p class="mb-6 text-body line-clamp-3 flex-grow">
                        {{ $publication->description }}
                    </p>
                </div>
                <div class="mt-2">
                    <strong>Autori:</strong>
                    <ul class="list-disc ml-5">
                        @foreach ($publication->authors as $author)
                            <li>
                                {{ $author->name }}
                                <span class="italic text-blue-600">
                                    (Ruolo: {{ $author->role }})
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('publication.show', $publication->id) }}"
                    class="inline-flex items-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                    Leggi di più
                    <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </a>
            </div>
        @endforeach
    </div>
</div>
