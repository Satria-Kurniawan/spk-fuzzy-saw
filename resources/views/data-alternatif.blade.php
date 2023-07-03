<x-app-layout>
    <section class="min-h-screen">
        <div class="flex justify-between mb-5">
            <h1 class="text-xl font-semibold">Data Alternatif</h1>
            <x-button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', {name: 'form_alternatif', action: 'add'})">
                <x-bi-plus-circle-dotted class="h-5 w-5" />
                <span>Tambah</span>
            </x-button>
        </div>
        <x-table :headers="['No', 'Nama Alternatif']" :headers2="$dataKriteria">
            @foreach ($dataAlternatif as $index => $value)
                <tr>
                    <td class="py-3 px-6 text-center border-b">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-center border-b">{{ $value->nama }}</td>
                    @foreach ($value->data as $nilaiKriteria)
                        <td class="py-3 px-6 text-center border-b">{{ $nilaiKriteria }}</td>
                    @endforeach
                    <td class="py-3 px-6 text-center border-b">
                        <div class="flex justify-center gap-x-3">
                            <x-bi-pencil-square class="text-blue-500 cursor-pointer hover:scale-125 duration-300"
                                x-data="{ kriteria: {{ json_encode($value->data) }}, alternatifFormData: {{ $value }} }"
                                x-on:click.prevent="$dispatch('open-modal', {name: 'form_alternatif', action: 'update', kriteria, alternatifFormData})" />
                            <x-bi-trash class="text-red-500 cursor-pointer hover:scale-125 duration-300"
                                x-data="{ alternatifFormData: {{ $value }} }"
                                x-on:click.prevent="$dispatch('open-modal', {name: 'delete_alternatif', alternatifFormData})" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </section>

    <x-modal name="form_alternatif">
        <div x-data="{
            alternatifFormData: { nama: '' },
            kriteria: {},
            action: '',
        }"
            x-on:open-modal.window="action = $event.detail.action; kriteria = $event.detail.kriteria ?? {{ json_encode($dataKriteria) }}; alternatifFormData = $event.detail.alternatifFormData ?? { nama: '' }">
            <form method="POST"
                x-bind:action="action === 'add' ? '/alternatif/add' : `/alternatif/update/${alternatifFormData.id}`">
                @csrf
                <h1 class="font-medium text-gray-500 text-xs uppercase tracking-wider mb-10">
                    Tambah Data Alternatif
                </h1>
                <template x-for="(item, index) in kriteria" :key="index">
                    <span></span>
                </template>
                <section class="mb-7">
                    <x-text-input :label="'Nama Alternatif'" type="text" name="nama" placeholder="Nama Alternatif"
                        :value="old('nama')" required autofocus x-model="alternatifFormData.nama" />

                    <div class="grid grid-cols-2 gap-x-5 gap-y-7 mt-7">
                        @foreach ($dataKriteria as $namaKriteria)
                            <x-text-input :label="$namaKriteria" type="number" step="0.01" name="{{ $namaKriteria }}"
                                placeholder="Nilai {{ $namaKriteria }}" :value="old('{{ $namaKriteria }}')" required
                                x-model="kriteria['{{ $namaKriteria }}']" />
                        @endforeach
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

    <x-modal name="delete_alternatif">
        <div x-data="{ alternatifFormData: {} }"
            x-on:open-modal.window="alternatifFormData = $event.detail.alternatifFormData ?? {nama: ''}">
            <h1 class="text-center text-xl">Hapus data kriteria
                <span class="text-red-500" x-text="alternatifFormData.nama"></span>?
            </h1>
            <div class="grid grid-cols-2 gap-5 mt-10">
                <x-button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white duration-300"
                    x-data x-on:click="$dispatch('close')">
                    <x-bi-x-circle class="h-5 w-5" />
                    <span>Batal</span>
                </x-button>
                <form method="POST" x-bind:action="`/alternatif/delete/${alternatifFormData.id}`">
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
