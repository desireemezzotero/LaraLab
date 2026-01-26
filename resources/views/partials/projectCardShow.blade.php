<div class="p-4 mx-auto container">

    <div class="mb-8 flex items-center justify-between">

        <div class="w-24 hidden lg:block"></div>

        <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">
            Progetto: {{ $project->title }}
        </h1>

        <div class="w-24 flex justify-end items-center space-x-3">
            @include('.components.component.projectIconShow')
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('.components.component.projectCardShowUserTask')

        {{-- file del progetto --}}
        <div class="lg:col-span-1">
            @include('.components.component.projectCardShowFile')
        </div>

        <div class="lg:col-span-1">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <span class="flex w-3 h-3 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
                Descrizione del progetto
            </h2>
            <div class="border p-2 rounded shadow-sm">
                <p>
                    {{ $project->description }}
                </p>
            </div>
        </div>

        <div class="lg:col-span-1">
            @include('.components.component.projectCardShowObjectMile')
        </div>
    </div>
</div>
