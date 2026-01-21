@extends('.layouts.master')

@section('component')
    <div>
        <div class="container mx-auto px-4 py-12">

            <div class="mb-10">
                <h2 class="text-3xl font-bold text-heading">pubblicazione </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-neutral-primary-soft flex flex-col h-full p-6 border border-default rounded-base shadow-xs hover:shadow-md transition-shadow duration-300">


                    <a href="#" class="block overflow-hidden rounded-base">
                        <img class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-500"
                            src="#" alt="#" />
                    </a>

                    <div class="flex flex-col flex-grow">
                        <h5 class="mt-6 mb-2 text-2xl font-semibold tracking-tight text-heading">
                            {{ $publication->title }}
                        </h5>

                        <p class="mb-6 text-body line-clamp-3 flex-grow">
                            {{ $publication->description }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    @endsection
