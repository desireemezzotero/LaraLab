  @php
      $userRoleInProject = $task->project
          ->users()
          ->where('user_id', auth()->id())
          ->first()->pivot->project_role;
  @endphp

  <h5 class="text-xs font-bold text-gray-400 uppercase mb-3 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
      </svg>
      Commenti ({{ $task->comments->count() }})
  </h5>

  <div class="space-y-3 mt-6 pt-4 pb-6 border-b border-gray-50">
      @forelse ($task->comments as $comment)
          <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between">
              <div class="items-center mb-1">
                  <span class="text-xs font-bold text-gray-700">{{ $comment->user->name }}</span>

                  <div>
                      <p class="text-xs text-gray-600">{{ $comment->body }}</p>
                  </div>
              </div>

              <div>
                  <span class="text-[12px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                  {{-- Mostra il tasto solo se Admin o PM --}}
                  @if (auth()->user()->role === 'Admin/PI' || $userRoleInProject === 'Project Manager')
                      <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" onclick="return confirm('Vuoi eliminare questo commento?')"
                              class="hover:underline text-xs hover:scale-105">
                              <span
                                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-indigo-600 border border-indigo-100">
                                  Elimina
                              </span>
                          </button>
                      </form>
                  @endif
              </div>

          </div>

      @empty
          <p class="text-xs text-gray-400 italic">Ancora nessun commento.</p>
      @endforelse
  </div>

  <div class="mt-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
      <h5 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
          Aggiungi un commento
      </h5>

      <form action="{{ route('comments.store', $task->id) }}" method="POST" class="space-y-3">
          @csrf

          <div class="relative">
              <textarea name="body" rows="3" required placeholder="Scrivi un aggiornamento o una domanda..."
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-all resize-none p-3"></textarea>
          </div>

          <div class="flex justify-end">
              <button type="submit"
                  class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                  Invia Commento
              </button>
          </div>
      </form>
  </div>
