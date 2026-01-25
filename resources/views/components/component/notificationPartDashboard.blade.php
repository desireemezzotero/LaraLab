<h2 class="text-lg font-semibold mb-3 flex items-center">
    <span class="flex w-3 h-3 rounded-full mr-2 bg-red-500 animate-pulse"></span>
    Promemoria Scadenze
</h2>

@if ($upcomingDeadlines->isNotEmpty())
    @foreach ($upcomingDeadlines as $project)
        <div class="p-4 text-sm border-l-4 border-red-500 rounded-r-lg bg-red-50 mt-2" role="alert">
            <div class="flex items-start">
                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-red-700 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <p class="font-bold">{{ $project->title }}</p>
                    <p class="text-xs text-red-600">Scade il
                        {{ $project->end_date }}
                    </p>

                    <a href="{{ route('project.show', $project->id) }}">
                        <p class="font-bold text-red-800">continua a modificare</p>
                    </a>
                </div>

            </div>
        </div>
    @endforeach
@else
    <div class="p-4 text-sm text-gray-500 rounded-lg border border-dashed border-gray-300">
        <p class="italic"> Nessuna scadenza imminente.</p>
    </div>
@endif
