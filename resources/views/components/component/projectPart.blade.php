  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="p-6 border-b border-gray-100">
          <h3 class="text-lg font-bold text-gray-800">Progetti Attivi</h3>
      </div>
      <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                  <tr>
                      <th class="px-6 py-3">Nome Progetto</th>
                      <th class="px-6 py-3">Stato</th>
                      <th class="px-6 py-3">Scadenza</th>
                      <th class="px-6 py-3">Azioni</th>
                  </tr>
              </thead>
              <tbody>

                  @forelse($activeProjects as $project)
                      <tr class="bg-white border-b hover:bg-gray-50">
                          <td class="px-6 py-4 font-semibold text-gray-900">{{ $project->title }}</td>
                          <td class="px-6 py-4">
                              @if ($project->status === 'on_hold')
                                  <span
                                      class="bg-orange-100 text-orange-500 text-xs font-medium px-2.5 py-0.5 rounded-full">Sospeso</span>
                              @elseif($project->status === 'active')
                                  <span
                                      class="bg-green-100 text-green-500 text-xs font-medium px-2.5 py-0.5 rounded-full">Attivo</span>
                              @endif
                          </td>

                          <td class="px-6 py-4">{{ $project->end_date }}</td>
                          <td class="px-6 py-4">
                              <a href="#" class="text-emerald-600 hover:underline">Vedi dettagli</a>
                          </td>
                      </tr>
                  @empty

                      <tr>
                          <td colspan="4" class="px-6 py-4 text-center">Nessun progetto attivo assegnato.</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
  </div>
