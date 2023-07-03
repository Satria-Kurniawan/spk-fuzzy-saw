@props(['headers', 'headers2' => []])

<div x-data="{ sidebarOpen: true }" x-on:sidebar-open.window="sidebarOpen = $event.detail;">
    <div class="border-x border-t rounded-md overflow-auto" x-bind:class="sidebarOpen ? 'w-[75vw]' : 'w-full'">
        <table class="w-full table-auto rounded-md">
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th
                            class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                    @if (count($headers2) > 0)
                        @foreach ($headers2 as $header2)
                            <th
                                class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                                {{ str_replace('_', ' ', $header2) }}
                            </th>
                        @endforeach
                        <th
                            class="py-3 px-6 bg-gray-50 border-b font-medium text-gray-500 text-xs uppercase tracking-wider">
                            Opsi
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
