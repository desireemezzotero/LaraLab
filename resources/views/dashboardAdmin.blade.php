@extends('.layouts.master')

@section('component')
    <div class="container mx-auto min-h-[80vh] flex flex-col justify-center py-10">

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-800">Bentornato, {{ auth()->user()->name }} 👋</h1>
            <p class="text-slate-500 font-medium">Gestione generale</p>
        </div>

        {{-- Griglia Card Statistiche --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            @foreach (['projects', 'tasks', 'users', 'attachments'] as $type)
                @php
                    $label = '';
                    $icon = '';
                    $colorClass = ''; // Usiamo classi intere per Tailwind
                    $percentage = null;

                    switch ($type) {
                        case 'projects':
                            $label = 'Progetti';
                            $icon = '🚀';
                            $colorClass = 'bg-emerald-50 text-emerald-500';
                            $percentage =
                                $stats['projects'] > 0 ? ($stats['projects_completed'] / $stats['projects']) * 100 : 0;
                            break;
                        case 'tasks':
                            $label = 'Tasks';
                            $icon = '🎯';
                            $colorClass = 'bg-amber-50 text-amber-500';
                            $percentage = $stats['tasks'] > 0 ? ($stats['tasks_completed'] / $stats['tasks']) * 100 : 0;
                            break;
                        case 'users':
                            $label = 'Team';
                            $icon = '👥';
                            $colorClass = 'bg-blue-50 text-blue-500';
                            break;
                        case 'attachments':
                            $label = 'Assets';
                            $icon = '📁';
                            $colorClass = 'bg-purple-50 text-purple-500';
                            break;
                    }
                @endphp

                <div
                    class="relative group p-8 bg-white rounded-[3rem] shadow-sm border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col items-center justify-center text-center overflow-hidden">

                    {{-- Sfondo decorativo al hover --}}
                    <div
                        class="absolute inset-0 {{ explode(' ', $colorClass)[0] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative z-10 w-full flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $icon }}</div>

                        <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats[$type] }}</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1 mb-6">
                            {{ $label }}</p>

                        {{-- AREA GRAFICI / LINK --}}
                        <div class="w-full max-w-[140px] flex justify-center">

                            {{-- PROGETTI: Grafico a Cerchio --}}
                            @if ($type == 'projects')
                                <a href="{{ route('publication.indexAdmin') }}"
                                    class="relative w-20 h-20 mx-auto block hover:scale-105 transition-transform">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="40" cy="40" r="35" stroke="currentColor" stroke-width="6"
                                            fill="transparent" class="text-slate-100" />
                                        <circle cx="40" cy="40" r="35" stroke="currentColor" stroke-width="6"
                                            fill="transparent" class="text-emerald-500 transition-all duration-1000"
                                            stroke-dasharray="219.9"
                                            style="stroke-dashoffset: {{ 219.9 - (219.9 * $percentage) / 100 }}" />
                                    </svg>
                                    <span
                                        class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-700">
                                        {{ round($percentage) }}%
                                    </span>
                                </a>

                                {{-- TASKS: Grafico a Barra --}}
                            @elseif ($type == 'tasks')
                                <div class="w-full space-y-2">
                                    <div class="flex justify-between text-[10px] font-black text-amber-600 uppercase">
                                        <span>Done</span>
                                        <span>{{ round($percentage) }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full transition-all duration-1000"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>

                                {{-- TEAM / USERS: Link Dettagli --}}
                            @elseif ($type == 'users')
                                <a href="{{ route('user.index') }}"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Team View
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Sezione inferiore (opzionale) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        </div>
    </div>
@endsection
