 <h2 class="text-lg font-semibold mb-3 flex items-center">
     <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
     Milestoni assegnate a questo progetto
 </h2>

 {{-- MILESTONI ASSEGANTE AL PROGETTO  --}}
 @foreach ($project->milestones as $milestone)
     <div class="px-6 pb-2">
         <span
             class="inline-block bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $milestone->title }}
         </span>
     </div>
 @endforeach

 {{-- OBIETTIVI ASSEGANTE AL PROGETTO  --}}
 <h2 class="text-lg font-semibold mb-3 flex items-center">
     <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
     obiettivi assegnati a questo progetto
 </h2>

 <div class="px-6 pb-2">
     <span
         class="inline-block bg-gray-200  px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $project->objectives }}
     </span>
 </div>
