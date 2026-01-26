   <h2 class="text-lg font-semibold mb-3 flex items-center">
       <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
       Allegati del progetto
   </h2>

   <div class="grid grid-cols-1 gap-4">
       @foreach ($project->attachments as $attachment)
           @php
               $extension = pathinfo($attachment->file_path, PATHINFO_EXTENSION);
               $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
           @endphp

           <div class="border p-2 rounded shadow-sm bg-white relative">
               @if ($isImage)
                   {{-- Immagine --}}
                   <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="block" download>
                       <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                           class="h-32 w-full hover:opacity-80 object-contain">
                   </a>
               @elseif (strtolower($extension) === 'pdf')
                   {{-- Caso PDF con Mini-Preview --}}
                   <div class="relative w-full h-32 overflow-hidden border rounded bg-gray-100">
                       <iframe src="{{ asset('storage/' . $attachment->file_path) }}#toolbar=0&navpanes=0&scrollbar=0"
                           class="absolute top-0 left-0 w-[300%] h-[300%] origin-top-left scale-[0.33] pointer-events-none border-none">
                       </iframe>
                       {{-- Link sovrapposto correttamente chiuso --}}
                       <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" download
                           class="absolute inset-0 z-10 flex items-end justify-center pb-1 bg-black/5 hover:bg-black/20 transition-colors">
                           <span
                               class="bg-white/90 px-2 py-0.5 rounded text-[10px] font-bold text-red-700 shadow-sm border border-red-200">
                               SCARICA PDF
                           </span>
                       </a>
                   </div>
               @else
                   {{-- Caso altri file --}}
                   <div class="flex flex-col items-center justify-center h-32 bg-gray-50 rounded">
                       <span class="text-3xl">📁</span>
                       <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                           class="text-xs text-blue-600 underline mt-2">
                           Scarica {{ $extension }}
                       </a>
                   </div>
               @endif

               <p class="text-[10px] text-gray-500 mt-1 truncate px-1">{{ $attachment->file_name }}</p>
           </div>
       @endforeach
   </div>
