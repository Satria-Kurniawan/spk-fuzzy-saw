<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="min-h-screen">
        <div class="grid grid-cols-3 gap-5">
            <div class="rounded-md p-5 border-l-4 border-l-blue-500 shadow-md">
                <h1 class="font-bold">Data Kriteria</h1>
                <p class="text-gray-500 font-medium">{{ count($dataKriteria) }} Kriteria</p>
            </div>
            <div class="rounded-md p-5 border-l-4 border-l-blue-500 shadow-md">
                <h1 class="font-bold">Data Himpunan Fuzzy</h1>
                <p class="text-gray-500 font-medium">{{ count($dataFuzzy) }} Himpunan</p>
            </div>
            <div class="rounded-md p-5 border-l-4 border-l-blue-500 shadow-md">
                <h1 class="font-bold">Data Alternatif</h1>
                <p class="text-gray-500 font-medium">{{ count($dataAlternatif) }} Alternatif</p>
            </div>
        </div>
    </section>
</x-app-layout>
