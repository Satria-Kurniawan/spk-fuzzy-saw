<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="min-h-screen">
        <div class="grid grid-cols-3 gap-3">
            <div class="rounded-md p-3 border-l-4 border-blue-500 shadow-md">Data Kriteria</div>
        </div>
    </section>
</x-app-layout>
