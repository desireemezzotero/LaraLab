@extends('.layouts.master')

@section('component')
    <div class="container mx-auto p-4">

        {{-- Header con Profilo Rapido --}}

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Bentornato, {{ auth()->user()->name }} 👋</h1>
            <p class="text-gray-600">Ecco un riepilogo delle tue attività</p>
        </div>

        {{-- Cards Statistiche "Glass Style" --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @foreach (['projects', 'tasks', 'users', 'attachments'] as $type)
                @php
                    $label = '';
                    $icon = '';
                    $color = '';
                @endphp

                @switch($type)
                    @case('projects')
                        @php
                            $label = 'Progetti';
                            $icon = '🚀';
                            $color = 'emerald';
                        @endphp
                    @break

                    @case('tasks')
                        @php
                            $label = 'Tasks';
                            $icon = '🎯';
                            $color = 'amber';
                        @endphp
                    @break

                    @case('users')
                        @php
                            $label = 'Team';
                            $icon = '👥';
                            $color = 'blue';
                        @endphp
                    @break

                    @case('attachments')
                        @php
                            $label = 'Assets';
                            $icon = '📁';
                            $color = 'purple';
                        @endphp
                    @break
                @endswitch

                <div
                    class="group bg-white p-4 rounded-xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center">

                    {{-- Icona centrata con cerchio di sfondo --}}
                    <div
                        class="mb-5 p-4 rounded-3xl bg-{{ $color }}-50 text-{{ $color }}-600 text-3xl group-hover:scale-110 transition-transform duration-300">
                        {{ $icon }}
                    </div>

                    {{-- Testi centrati --}}
                    <div class="space-y-1">
                        <p class="text-4xl font-black text-slate-800">
                            {{ $stats[$type] }}
                        </p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                            {{ $label }}
                        </p>
                    </div>

                    {{-- Decorazione opzionale: pallino centrato in basso --}}
                    <div
                        class="mt-4 rounded-full bg-{{ $color }}-400 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">


        </div>
    </div>
@endsection
