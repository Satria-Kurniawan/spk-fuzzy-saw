<aside x-data="{ open: true }" x-bind:class="open ? 'w-80' : 'w-20'" class="h-screen sticky top-0 duration-300">
    <div class="h-full border-r py-5 relative">
        <div class="px-5 flex items-center gap-x-3">
            <x-bi-bar-chart-line-fill />
            <h1 x-bind:class="!open && 'hidden'" class="font-semibold text-xl">
                Fuzzy <span class="text-blue-500">SAW</span>
            </h1>
        </div>
        <div x-on:click="open = !open; $dispatch('sidebar-open', open)"
            x-bind:class="open ? 'right-0 rounded-l-md' : '-right-6 rounded-r-md'"
            class="absolute top-12 bg-blue-500 cursor-pointer">
            <x-css-chevron-left x-bind:class="!open && 'rotate-180'" class="my-3 text-white" />
        </div>

        @php
            $menus = [(object) ['name' => 'Dashboard', 'route' => 'dashboard'], (object) ['name' => 'Data Kriteria', 'route' => 'kriteria.data'], (object) ['name' => 'Data Fuzzy', 'route' => 'fuzzy.data'], (object) ['name' => 'Data Alternatif', 'route' => 'alternatif.data'], (object) ['name' => 'Data Perhitungan', 'route' => 'perhitungan.data'], (object) ['name' => 'Data Hasil', 'route' => 'perankingan.data']];
        @endphp

        <ul class="mt-16">
            @foreach ($menus as $menu)
                <li class="py-3 relative">
                    <a href="{{ route($menu->route) }}">
                        <div
                            class="h-full w-[0.4rem] rounded-r-md bg-blue-500 absolute left-0 top-0 {{ Route::is($menu->route) ? 'visible' : 'invisible' }}">
                        </div>
                        <div
                            class="px-5 flex items-center gap-x-3 {{ Route::is($menu->route) ? 'text-blue-500' : '' }}">
                            {{-- @svg('bi-table') --}}
                            @switch($menu->name)
                                @case('Dashboard')
                                    <x-gmdi-dashboard class="w-5 h-5" />
                                @break

                                @case('Data Kriteria')
                                    <x-bi-layers-fill class="w-5 h-5" />
                                @break

                                @case('Data Fuzzy')
                                    <x-bi-triangle-half class="w-5 h-5" />
                                @break

                                @case('Data Alternatif')
                                    <x-gmdi-pivot-table-chart-o class="w-5 h-5" />
                                @break

                                @case('Data Perhitungan')
                                    <x-gmdi-calculate-r class="w-5 h-5" />
                                @break

                                @default
                                    <x-bi-table class="w-5 h-5" />
                            @endswitch
                            <span x-bind:class="!open && 'hidden'" class="font-semibold">{{ $menu->name }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
