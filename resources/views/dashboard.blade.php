@extends('.layouts.master')

@section('component')
    <div class="p-4 mx-auto container">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Bentornato, {{ $user->name }} 👋</h1>
            <p class="text-gray-600">Ecco un riepilogo delle tue attività</p>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <div class="lg:col-span-1">
                {{-- NOTIFICHE --}}
                @include('.components.component.notificationPart')
            </div>

            <div class="lg:col-span-3">
                {{-- TASK --}}
                @include('.components.component.taskPart')

                {{-- PROGETTI --}}
                @include('.components.component.projectPart')
            </div>

        </div>

    </div>
@endsection
