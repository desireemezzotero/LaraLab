  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

      <div
          class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-center text-center">

          <h3 class="text-gray-700 font-bold mb-4 text-lg">Stato di avanzamento dei task</h3>


          <div class="flex justify-center mb-2">
              <span class="text-sm font-medium text-emerald-600">
                  {{ round($progressPercentageTasks) }}%
              </span>
          </div>

          <div class="w-full max-w-md mx-auto bg-gray-200 rounded-full h-4">
              <div class="bg-emerald-600 h-4 rounded-full transition-all duration-500"
                  style="width: {{ $progressPercentageTasks }}%">
              </div>
          </div>

          <p class="mt-4 text-sm text-gray-500 italic">
              Basato sui task a te assegnati nei progetti attivi
          </p>
      </div>

      <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <h2 class="text-lg font-semibold mb-3 flex items-center">

              <span class="flex w-3 h-3 rounded-full mr-2 bg-red-500 animate-pulse"></span>
              Pubblicazioni in corso
          </h2>

          @if ($publicationCount)
              @foreach ($publicationCount as $publication)
                  <div class="p-4 text-sm border-l-4 border-red-500 rounded-r-lg bg-red-50 mt-2" role="alert">
                      <div class="flex items-start">
                          <svg class="flex-shrink-0 w-4 h-4 mr-2 text-red-700 mt-0.5" fill="currentColor"
                              viewBox="0 0 20 20">
                              <path
                                  d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                          </svg>
                          <div>
                              <p class="font-bold">{{ $publication->title }}</p>

                              <a href="{{ route('publication.show', $publication->id) }}">
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
      </div>
  </div>
