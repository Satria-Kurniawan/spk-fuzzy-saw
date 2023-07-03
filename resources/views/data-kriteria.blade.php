<x-app-layout>
    <section class="min-h-screen">
        <div class="flex justify-between mb-5">
            <h1 class="text-xl font-semibold">Data Kriteria</h1>
            <x-button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300" x-data
                x-on:click.prevent="$dispatch('open-modal', {name: 'form_kriteria', action: 'add'})">
                <x-bi-plus-circle-dotted class="h-5 w-5" />
                <span>Tambah</span>
            </x-button>
        </div>
        <x-table :headers="['No', 'Kode Kriteria', 'Nama Kriteria', 'Bobot', 'Atribut', 'Opsi']">
            @foreach ($dataKriteria as $index => $value)
                <tr>
                    <td class="py-3 px-6 text-center border-b">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-center border-b">C{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-center border-b">{{ $value->nama }}</td>
                    <td class="py-3 px-6 text-center border-b">{{ $value->bobot }}</td>
                    <td class="py-3 px-6 text-center border-b">{{ $value->is_benefit ? 'Benefit' : 'Cost' }}</td>
                    <td class="py-3 px-6 text-center border-b">
                        <div class="flex justify-center gap-x-3">
                            <x-bi-pencil-square class="text-blue-500 cursor-pointer hover:scale-125 duration-300"
                                x-data="{ kriteriaFormData: {{ $value }} }"
                                x-on:click.prevent="$dispatch('open-modal', {name: 'form_kriteria', action: 'update', kriteriaFormData})" />
                            <x-bi-trash class="text-red-500 cursor-pointer hover:scale-125 duration-300"
                                x-data="{ kriteriaFormData: {{ $value }} }"
                                x-on:click.prevent="$dispatch('open-modal', {name: 'delete_kriteria', kriteriaFormData})" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </section>

    <x-modal name="form_kriteria">
        <div x-data="{ kriteriaFormData: { nama: '', bobot: '', is_benefit: 1 }, action: '' }"
            x-on:open-modal.window="kriteriaFormData = $event.detail.kriteriaFormData ? $event.detail.kriteriaFormData: {nama: '', bobot: '', is_benefit: 1}; action = $event.detail.action">
            <form method="POST"
                x-bind:action="action === 'add' ? '/kriteria/add' : `/kriteria/update/${kriteriaFormData.id}`">
                @csrf
                <h1 class="font-medium text-gray-500 text-xs uppercase tracking-wider mb-10">
                    Tambah Data Kriteria
                </h1>
                <section class="grid grid-cols-2 gap-x-5 gap-y-7 mb-7">
                    <x-text-input :label="'Nama Kriteria'" type="text" name="nama" placeholder="Nama Kriteria"
                        :value="old('nama')" required autofocus x-model="kriteriaFormData.nama" />
                    <x-text-input :label="'Bobot'" type="number" step="0.01" name="bobot" placeholder="Bobot"
                        :value="old('bobot')" required x-model="kriteriaFormData.bobot" />
                    <div class="relative">
                        <select name="is_benefit" x-model="kriteriaFormData.is_benefit"
                            class="w-full border border-gray-300 px-4 py-2.5 rounded-md focus:border-[1.5px] focus:outline-none">
                            <option value="1" x-bind:selected="kriteriaFormData.is_benefit === 1">
                                Benefit
                            </option>
                            <option value="0" x-bind:selected="kriteriaFormData.is_benefit === 0">
                                Cost
                            </option>
                        </select>
                        <label class="select-label text-sm">Atribut</label>
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

    <x-modal name="delete_kriteria">
        <div x-data="{ kriteriaFormData: {} }" x-on:open-modal.window="kriteriaFormData = $event.detail.kriteriaFormData">
            <h1 class="text-center text-xl">Hapus data kriteria
                <span class="text-red-500" x-text="kriteriaFormData.nama"></span>?
            </h1>
            <div class="grid grid-cols-2 gap-5 mt-10">
                <x-button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300"
                    x-data x-on:click="$dispatch('close')">
                    <x-bi-x-circle class="h-5 w-5" />
                    <span>Batal</span>
                </x-button>
                <form method="POST" x-bind:action="`/kriteria/delete/${kriteriaFormData.id}`">
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
