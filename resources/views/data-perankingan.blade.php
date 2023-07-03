<x-app-layout>
    <section class="min-h-screen">
        <h1 class="text-xl font-semibold mb-5">Data Hasil</h1>

        <div class="flex flex-col gap-y-7" x-data="{ sidebarOpen: true }" x-on:sidebar-open.window="sidebarOpen = $event.detail">
            <div>
                <div class="flex items-end">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Data Hasil Akhir
                    </span>
                </div>
                <div class="border-x border-t rounded-md overflow-auto"
                    x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Alternatif
                                </th>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Nilai
                                </th>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Ranking
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPerankingan as $index => $value)
                                <tr>
                                    <td class="border-b px-6 py-3 text-center">
                                        {{ $value['Nama_Alternatif'] }}
                                    </td>
                                    <td class="py-3 px-6 text-center border-b">{{ $value['Nilai_V'] }}</td>
                                    <td class="py-3 px-6 text-center border-b">{{ $index + 1 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</x-app-layout>
