<x-app-layout>
    <section class="min-h-screen">
        <div class="flex justify-between mb-5">
            <h1 class="text-xl font-semibold">Data Himpunan Fuzzy</h1>
        </div>
        <div class="flex flex-col gap-y-7">
            @foreach ($dataKriteria as $kriteria)
                <div>
                    <div class="flex items-end justify-between">
                        <span
                            class="h-fit bg-blue-500 text-white rounded-t-md px-5 py-0.5 uppercase font-medium text-sm tracking-wider">
                            {{ $kriteria->nama }}
                        </span>
                        <x-button
                            class="mb-3 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300"
                            x-data="{ id_kriteria: {{ $kriteria->id }} }"
                            x-on:click.prevent="$dispatch('open-modal', {name: 'form_fuzzy', id_kriteria, action: 'add'})">
                            <x-bi-plus-circle-dotted class="h-5 w-5" />
                            <span>Tambah</span>
                        </x-button>
                    </div>

                    @php
                        $number = 1;
                    @endphp

                    <x-table :headers="['No', 'Keterangan', 'Range Nilai', 'Nilai Fuzzy', 'Opsi']">
                        @foreach ($dataFuzzy as $index => $value)
                            @if ($value->id_kriteria === $kriteria->id)
                                <tr>
                                    <td class="py-3 px-6 text-center border-b">{{ $number++ }}</td>
                                    <td class="py-3 px-6 text-center border-b">{{ $value->keterangan }}</td>
                                    <td class="py-3 px-6 text-center border-b">
                                        {{ $value->nilai_start }} - {{ $value->nilai_end }}</td>
                                    <td class="py-3 px-6 text-center border-b">{{ $value->nilai_fuzzy }}</td>
                                    <td class="py-3 px-6 text-center border-b">
                                        <div class="flex justify-center gap-x-3">
                                            <x-bi-pencil-square
                                                class="text-blue-500 cursor-pointer hover:scale-125 duration-300"
                                                x-data="{ id_kriteria: {{ $kriteria->id }}, fuzzyFormData: {{ $value }} }"
                                                x-on:click.prevent="$dispatch('open-modal', {name: 'form_fuzzy', id_kriteria, fuzzyFormData, action: 'update'})" />
                                            <x-bi-trash class="text-red-500 cursor-pointer hover:scale-125 duration-300"
                                                x-data="{ fuzzyFormData: {{ $value }} }"
                                                x-on:click.prevent="$dispatch('open-modal', {name: 'delete_fuzzy', fuzzyFormData})" />
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </x-table>
                </div>
            @endforeach
        </div>
    </section>

    <x-modal name="form_fuzzy">
        <div x-data="{ fuzzyFormData: { keterangan: '', operator: '', nilai_start: 0, nilai_end: 0, nilai_persyaratan: 0, nilai_fuzzy: 0, }, id_kriteria: null, action: '' }"
            x-on:open-modal.window="fuzzyFormData = $event.detail.fuzzyFormData ? $event.detail.fuzzyFormData: {keterangan: '', operator: '', nilai_start: 0, nilai_end: 0, nilai_persyaratan: 0, nilai_fuzzy: 0}; id_kriteria = $event.detail.id_kriteria; action = $event.detail.action">
            <form method="POST"
                x-bind:action="action === 'add' ? `/fuzzy/add/${id_kriteria}` : `/fuzzy/update/${id_kriteria}/${fuzzyFormData.id}`">
                @csrf
                <h1 class="font-medium text-gray-500 text-xs uppercase tracking-wider mb-10">
                    Tambah Data Himpunan Fuzzy
                </h1>
                <section class="grid grid-cols-2 gap-x-5 gap-y-7 mb-7">
                    <x-text-input :label="'Keterangan'" type="text" name="keterangan" placeholder="Keterangan"
                        :value="old('keterangan')" required autofocus x-model="fuzzyFormData.keterangan" />

                    <div class="relative">
                        <select id="operator" name="operator" x-model="fuzzyFormData.operator"
                            class="w-full border border-gray-300 px-4 py-2.5 rounded-md focus:border-[1.5px] focus:outline-none">
                            <option value="" selected disabled class="text-gray-400">Pilih Operator</option>
                            <option value="Kurang Dari" x-bind:selected="fuzzyFormData.operator === 'Kurang Dari'">
                                Kurang Dari
                            </option>
                            <option value="Lebih Dari" x-bind:selected="fuzzyFormData.operator === 'Lebih Dari'">
                                Lebih Dari
                            </option>
                            <option value="Range Nilai" x-bind:selected="fuzzyFormData.operator === 'Range Nilai'">
                                Range Nilai
                            </option>
                        </select>
                        <label class="select-label text-sm">Operator</label>
                    </div>

                    <div x-show="fuzzyFormData.operator === 'Range Nilai'">
                        <div class="grid grid-cols-2 gap-x-5 gap-y-7">
                            <x-text-input :label="'Dari Nilai'" type="number" step="0.01" name="nilai_start"
                                placeholder="Dari Nilai" :value="old('nilai_start')" required
                                x-model="fuzzyFormData.nilai_start" />

                            <x-text-input :label="'Sampai Nilai'" type="number" step="0.01" name="nilai_end"
                                placeholder="Sampai Nilai" :value="old('nilai_end')" required
                                x-model="fuzzyFormData.nilai_end" />
                        </div>
                    </div>

                    <div x-show="fuzzyFormData.operator === 'Kurang Dari'">
                        <x-text-input :label="'Nilai Kurang Dari (<)'" type="number" step="0.01" name="nilai_persyaratan"
                            placeholder="Nilai Kurang Dari (<)" :value="old('nilai_persyaratan')" required
                            x-model="fuzzyFormData.nilai_persyaratan" />
                    </div>

                    <div x-show="fuzzyFormData.operator === 'Lebih Dari'">
                        <x-text-input :label="'Nilai Lebih Dari (>)'" type="number" step="0.01" name="nilai_persyaratan"
                            placeholder="Nilai Lebih Dari (>)" :value="old('nilai_persyaratan')" required
                            x-model="fuzzyFormData.nilai_persyaratan" />
                    </div>

                    <div x-show="fuzzyFormData.operator !== ''">
                        <x-text-input :label="'Nilai Fuzzy'" type="number" step="0.01" name="nilai_fuzzy"
                            placeholder="Nilai Fuzzy" :value="old('nilai_fuzzy')" required x-model="fuzzyFormData.nilai_fuzzy" />
                    </div>

                </section>
                <x-button type="submit"
                    class="w-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300">
                    <x-bi-save class="h-5 w-5" />
                    <span>Simpan</span>
                </x-button>
            </form>
        </div>
    </x-modal>

    <x-modal name="delete_fuzzy">
        <div x-data="{ fuzzyFormData: {} }" x-on:open-modal.window="fuzzyFormData = $event.detail.fuzzyFormData">
            <h1 class="text-center text-xl">Hapus data himpunan fuzzy?</h1>
            <div class="grid grid-cols-2 gap-5 mt-10">
                <x-button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300"
                    x-data x-on:click="$dispatch('close')">
                    <x-bi-x-circle class="h-5 w-5" />
                    <span>Batal</span>
                </x-button>
                <form method="POST" x-bind:action="`/fuzzy/delete/${fuzzyFormData.id}`">
                    @csrf
                    <x-button
                        class="w-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white duration-300">
                        <x-bi-trash class="h-5 w-5" />
                        <span>Hapus</span>
                    </x-button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>
