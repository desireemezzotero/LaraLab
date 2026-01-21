<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Progetti Totali</h3>
            <p class="text-3xl font-bold">{{ $stats['projects_count'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Pubblicazioni</h3>
            <p class="text-3xl font-bold">{{ $stats['publications_count'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Task Attivi</h3>
            <p class="text-3xl font-bold">{{ $stats['active_tasks '] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="font-bold text-lg mb-4 text-blue-800">Progetti di Ricerca Recenti</h3>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase">Titolo</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase">Team</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentProjects as $project)
                            <tr>
                                <td class="py-3 text-sm font-semibold">{{ $project->title }}</td>
                                <td class="py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $project->status == 'Concluso' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="py-3 text-sm"> {{ $project->users_count }} membri </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200 bg-red-50">
                <h3 class="font-bold text-lg text-red-700">⚠️ Scadenze Imminenti</h3>
            </div>
            <div class="p-6">
                @forelse($upcomingMilestones as $milestone)
                    <div class="mb-4 border-b pb-2">
                        <p class="text-sm font-bold text-gray-800">{{ $milestone->title }}</p>
                        <p class="text-xs text-red-600">Scadenza:
                            {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">Nessuna scadenza prevista nei prossimi 7 giorni.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
