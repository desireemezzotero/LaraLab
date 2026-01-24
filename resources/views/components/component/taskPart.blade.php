  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

      <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <h3 class="text-gray-700 font-bold mb-4 text-lg">Stato di avanzamento dei task</h3>
          <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-emerald-600">{{ round($progressPercentageTasks) }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-4">
              <div class="bg-emerald-600 h-4 rounded-full transition-all duration-500"
                  style="width: {{ $progressPercentageTasks }}%"></div>
          </div>
          <p class="mt-4 text-sm text-gray-500 italic">Basato sui task a te assegnati nei progetti attivi</p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
          <h3 class="text-gray-700 font-bold mb-4 text-lg">Stato di avanzamento delle pubblicazioni</h3>
          <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-emerald-600">{{ round($progressPercentagePublications) }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-4">
              <div class="bg-emerald-600 h-4 rounded-full transition-all duration-500"
                  style="width: {{ $progressPercentagePublications }}%"></div>
          </div>
          <p class="mt-4 text-sm text-gray-500 italic">Basato sulle pubblicazioni a te assegnate</p>
      </div>
  </div>
