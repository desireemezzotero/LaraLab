@extends('.layouts.master')

@section('component')
    <div class="container mx-auto min-h-[80vh] flex flex-col justify-center">

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-800">Bentornato, {{ auth()->user()->name }} 👋</h1>
            <p class="text-slate-500 font-medium">Gestione generale</p>
        </div>

        {{-- card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            @foreach (['projects', 'tasks', 'users', 'attachments'] as $type)
                @php
                    $label = '';
                    $icon = '';
                    $color = '';
                    $percentage = null;

                    switch ($type) {
                        case 'projects':
                            $label = 'Progetti';
                            $icon = '🚀';
                            $color = 'emerald';
                            $percentage =
                                $stats['projects'] > 0 ? ($stats['projects_completed'] / $stats['projects']) * 100 : 0;
                            break;
                        case 'tasks':
                            $label = 'Tasks';
                            $icon = '🎯';
                            $color = 'amber';
                            $percentage = $stats['tasks'] > 0 ? ($stats['tasks_completed'] / $stats['tasks']) * 100 : 0;
                            break;
                        case 'users':
                            $label = 'Team';
                            $icon = '👥';
                            $color = 'blue';
                            break;
                        case 'attachments':
                            $label = 'Assets';
                            $icon = '📁';
                            $color = 'purple';
                            break;
                    }
                @endphp

                <div
                    class="relative group p-8 bg-white rounded-[3rem] shadow-sm border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col items-center justify-center text-center overflow-hidden">

                    {{-- Sfondo decorativo --}}
                    <div
                        class="absolute inset-0 bg-{{ $color }}-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative z-10 w-full flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $icon }}</div>

                        <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats[$type] }}</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1 mb-6">
                            {{ $label }}</p>

                        {{-- Mostra il grafico SOLO se è un Progetto o un Task --}}
                        @if ($percentage !== null)
                            <div class="w-full max-w-[140px]">
                                {{-- Se è Progetti facciamo il Cerchio, se è Task facciamo la Barra  --}}
                                @if ($type == 'projects')
                                    {{-- PROGETTI --}}
                                    <div class="relative w-20 h-20 mx-auto">
                                        <svg class="w-full h-full transform -rotate-90">
                                            <circle cx="40" cy="40" r="35" stroke="currentColor"
                                                stroke-width="6" fill="transparent" class="text-slate-100" />
                                            <circle cx="40" cy="40" r="35" stroke="currentColor"
                                                stroke-width="6" fill="transparent"
                                                class="text-emerald-500 transition-all duration-1000"
                                                stroke-dasharray="219.9"
                                                style="stroke-dashoffset: {{ 219.9 - (219.9 * round($percentage)) / 100 }}" />
                                        </svg>
                                        <span
                                            class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-700">
                                            {{ round($percentage) }}%
                                        </span>
                                    </div>
                                @else
                                    {{-- GRAFICO A BARRA PER TASK --}}
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-[10px] font-black text-amber-600 uppercase">
                                            <span>Done</span>
                                            <span>{{ round($percentage) }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-500 rounded-full transition-all duration-1000"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- Spazio vuoto o decorazione per le card senza grafico (Team/Assets) --}}
                            <div class="h-10 flex items-center">
                                <span
                                    class="text-[10px] font-bold text-{{ $color }}-300 uppercase tracking-widest">Global
                                    Data</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        </div>
    </div>
@endsection
