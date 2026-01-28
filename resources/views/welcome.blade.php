@extends('.layouts.master')

@section('component')
    {{-- Contenitore Immagine con altezza bloccata --}}
    <div class="overflow-hidden relative">
        <img src="{{ asset('img/jumb.jpg') }}" alt="Immagine di copertina"
            class="w-full h-full object-cover object-top pointer-events-none">
    </div>

    {{-- Sezione Card --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        @include('.components.component.publicationCard')
    </div>
@endsection
