<x-app-layout>
    <section class="min-h-screen">
        <h1 class="text-xl font-semibold mb-5">Data Perhitungan</h1>

        <div class="flex flex-col gap-y-7" x-data="{ sidebarOpen: true }" x-on:sidebar-open.window="sidebarOpen = $event.detail">

            <div>
                <div class="flex items-end">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Data Nilai Numerik
                    </span>
                </div>
                <div class="border-x border-t rounded-md overflow-auto"
                    x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Alternatif
                                </th>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataAlternatif as $index => $value)
                                <tr>
                                    <td class="py-3 px-6 text-center border-b">{{ $index + 1 }}</td>
                                    <td class="border-b px-6 py-3 text-center">
                                        {{ $dataAlternatif[$loop->index]['nama'] }}
                                    </td>
                                    @foreach ($value->data as $nilaiKriteria)
                                        <td class="py-3 px-6 text-center border-b">{{ $nilaiKriteria }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Data Nilai Linguistik
                    </span>
                </div>
                <div class="border-x border-t rounded-md overflow-auto"
                    x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Alternatif
                                </th>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPenilaian as $item)
                                <tr>
                                    <td class="border-b px-6 py-3 text-center">{{ $loop->index + 1 }}</td>
                                    <td class="border-b px-6 py-3 text-center">
                                        {{ $dataAlternatif[$loop->index]['nama'] }}
                                    </td>
                                    @foreach ($item as $value)
                                        <td class="border-b px-6 py-3 text-center">
                                            @php
                                                $words = explode(' ', $value['Keterangan']);
                                                $abbreviation = '';
                                                foreach ($words as $word) {
                                                    $abbreviation .= substr($word, 0, 1);
                                                }
                                            @endphp
                                            {{ $abbreviation }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Matriks Keputusan (X)
                    </span>
                </div>
                <div class="border-t rounded-md overflow-auto" x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                </th>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matriks as $index => $m)
                                <tr>
                                    <td
                                        class="border px-6 py-3 text-center font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        A{{ $loop->index + 1 }}
                                    </td>
                                    @foreach ($m as $value)
                                        <td class="border px-6 py-3 text-center">{{ $value['Nilai_Fuzzy'] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Matriks Normalisasi (R)
                    </span>
                </div>
                <div class="border-t rounded-md overflow-auto" x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                </th>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalizedMatriks as $m)
                                <tr>
                                    <td
                                        class="border px-6 py-3 text-center font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        A{{ $loop->index + 1 }}
                                    </td>
                                    @foreach ($m as $value)
                                        <td class="border px-6 py-3 text-center">
                                            {{ $value['Nilai_Normalisasi'] }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Bobot Preferensi (W)
                    </span>
                </div>
                <div class="border-t rounded-md overflow-auto" x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }} ({{ $value['is_benefit'] ? 'Benefit' : 'Cost' }})
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach ($dataKriteria as $value)
                                    <td class="border px-6 py-3 text-center">{{ $value['bobot'] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between">
                    <span
                        class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                        Hasil Perhitungan
                    </span>
                </div>
                <div class="border-t rounded-md overflow-auto" x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
                    <table class="w-full table-auto rounded-md">
                        <thead>
                            <tr>
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                </th>
                                @foreach ($dataKriteria as $index => $value)
                                    <th
                                        class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        C{{ $index + 1 }}
                                    </th>
                                @endforeach
                                <th
                                    class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                    Nilai V
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dataHasilPerhitungan as $values)
                                <tr>
                                    <td
                                        class="border px-6 py-3 text-center font-medium text-gray-500 text-xs uppercase tracking-wider">
                                        A{{ $loop->index + 1 }}
                                    </td>
                                    @foreach ($values['Normalisasi_Terbobot'] as $value)
                                        <td class="border px-6 py-3 text-center">{{ $value }}</td>
                                    @endforeach
                                    <td class="border px-6 py-3 text-center">{{ $values['Nilai_V'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
