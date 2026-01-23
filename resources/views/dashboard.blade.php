@extends('.layouts.master')

@section('component')
    <div class="container mx-auto mt-5">

        <h1 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-4xl lg:text-5xl text-center">
            Profilo di {{ $user->name }} ({{ $user->role }})
        </h1>



        <div class="bg-neutral-primary-soft block p-6 border border-default rounded-base hover:bg-neutral-secondary-medium">
            <h3 class="text-lg font-bold mb-4">I Miei Progetti di Ricerca</h3>

            @if ($user->projects->isNotEmpty())
                <a href="#">
                    <div class="space-y-4">
                        @foreach ($user->projects as $project)
                            <div class="p-4 border rounded">
                                <h4 class="font-bold">{{ $project->title }}</h4>
                                <p class="text-sm text-gray-500">Ruolo: {{ $project->pivot->project_role }}</p>
                            </div>
                        @endforeach
                    </div>
                </a>
            @else
                <p>Nessun progetto collegato a questo account.</p>
            @endif
        </div>


        <div
            class="bg-neutral-primary-soft block p-6 border border-default rounded-base hover:bg-neutral-secondary-medium mt-11">
            <h3 class="text-lg font-bold mb-4">I Miei Task</h3>

            @if ($user->tasks->isNotEmpty())
                <a href="#">
                    <div class="space-y-4">
                        @foreach ($user->tasks as $task)
                            <div class="p-4 border rounded">
                                <h4 class="font-bold">{{ $task->title }}</h4>
                                <p class="text-sm text-gray-500"> Status: {{ $task->status }}</p>
                            </div>
                        @endforeach
                    </div>
                </a>
            @else
                <p>Nessuna task assegnato</p>
            @endif
        </div>

    </div>
@endsection
