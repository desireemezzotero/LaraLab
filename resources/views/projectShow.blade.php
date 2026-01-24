@extends('.layouts.master')

@section('component')
    <div
        class="container mx-auto px-4 py-12 flex flex-col items-center bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
        <img class="object-cover w-full rounded-base h-64 md:h-auto md:w-48 mb-4 md:mb-0" src="#" alt="">

        <div class="flex flex-col justify-between md:p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-heading">{{ $project->title }}</h5>
            <p class="mb-6 text-body">{{ $project->description }}</p>

            {{-- <table class="table-auto">
                <thead>
                    <tr>
                        <th>Autore</th>
                        <th>Email</th>
                        <th>Posizione autore</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publication->authors as $author)
                        <tr>
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->email }}</td>
                            <td>{{ $author->pivot->position }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>


    </div>
@endsection
