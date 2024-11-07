<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Categorias') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <!-- Formulário de criação -->
            @can('create_building')
                @if ($create_mode)
                    <div class="grid grid-cols-12 place-content-end">
                        <div class="col-start-1 col-end-12 mr-3">
                            <x-mary-input label="Nome" wire:model="name" />
                        </div>
                        <div class="col-start-1 col-end-7 mr-3">
                            <x-mary-input label="Endereço" wire:model="address" />
                        </div>
                        <div class="col-start-7 col-end-8 mr-3">
                            <x-mary-input label="Número" wire:model="number" />
                        </div>
                        <div class="col-start-8 col-end-11 mr-3">
                            <x-mary-input label="Bairro" wire:model="neighborhood" />
                        </div>
                        <div class="col-start-11 mr-3">
                            <x-mary-input label="CEP" wire:model="postal_code" />
                        </div>
                        <div class="col-start-1 col-end-3 mr-3">
                            <x-mary-input label="Latitude" wire:model.live="latitude" wire:change="test"/>
                        </div>
                        <div class="col-start-3 col-end-5 mr-3">
                            <x-mary-input label="Longitude" wire:model.live="longitude" />
                        </div>
                        <div class="col-start-1 col-end-3 mr-3">
                            <x-mary-select label="Responsavel" :options="$responsibles" wire:model="responsible"
                                placeholder="Selecione um responsável..." />
                        </div>
                        <div class="col-start-3 col-end-5 mr-3">
                            <x-mary-select label="Secretaria" :options="$secretaries" wire:model="secretary_id"
                                placeholder="Selecione uma secretaria..." />
                        </div>
                        <div class="columns-1 mt-7">
                            <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                        </div>
                        <div class="col-start-1 col-end-13 mt-7 h-96" id="mapDiv" wire:ignore>

                        </div>
                    </div>
                @endif
            @endcan

            <!-- Formulário de edição -->
            @can('edit_building')
                @if ($edit_mode)
                    <div class="grid grid-cols-12 place-content-end">
                        <div class="col-end-2">
                            <x-mary-input label="ID" wire:model="secretary_id" readonly />
                        </div>
                        <div class="col-start-2 col-end-12 ml-3 mr-3">
                            <x-mary-input label="Nome" wire:model="name" />
                        </div>
                        <div class="col-start-1 col-end-7 mr-3">
                            <x-mary-input label="Endereço" wire:model="address" />
                        </div>
                        <div class="col-start-7 col-end-8 mr-3">
                            <x-mary-input label="Número" wire:model="number" />
                        </div>
                        <div class="col-start-8 col-end-11 mr-3">
                            <x-mary-input label="Bairro" wire:model="neighborhood" />
                        </div>
                        <div class="col-start-11 mr-3">
                            <x-mary-input label="CEP" wire:model="postal_code" />
                        </div>
                        <div class="col-start-1 col-end-3 mr-3">
                            <x-mary-input label="Latitude" wire:model="latitude" />
                        </div>
                        <div class="col-start-3 col-end-5 mr-3">
                            <x-mary-input label="Longitude" wire:model="longitude" />
                        </div>
                        <div class="col-start-1 col-end-3 mr-3">
                            <x-mary-select label="Responsavel" :options="$responsibles" wire:model="responsible"
                                placeholder="Selecione um responsável..." />
                        </div>
                        <div class="col-start-3 col-end-5 mr-3">
                            <x-mary-select label="Secretaria" :options="$secretaries" wire:model="secretary_id"
                                placeholder="Selecione uma secretaria..." />
                        </div>
                        <div class="columns-1 mt-7">
                            <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                        </div>
                        <div class="col-start-1 col-end-13 mt-7 h-96" id="mapDiv" wire:ignore>

                        </div>

                    </div>
                @endif
            @endcan

            <!-- Exibição da tabela -->
            @if ($show_table)
                <div class="grid grid-cols-12 place-content-end">
                    <div class="col-end-2">
                        <x-mary-select label="Registros por página" :options="$pageSizes" wire:model.live="perPage" />
                    </div>
                    <div class="col-start-10 col-end-12 mr-3">
                        <x-mary-input label="Busca" class="block" wire:model.live="searchInput">
                            <x-slot:prepend>
                                <x-mary-button class="btn-primary btn-square rounded-l-box rounded-r-none"
                                    icon="o-magnifying-glass-circle"></x-mary-button>
                            </x-slot:prepend>
                        </x-mary-input>
                    </div>
                    @can('create_building')
                        <div class="col-start-12 col-end-12 mt-7">
                            <x-mary-button class="btn btn-block btn-info" wire:click="create">Novo</x-mary-button>
                        </div>
                    @endcan
                </div>
                <x-mary-table class="table-sm" :headers="$headers" :rows="$buildings" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_map', $building)
                        <x-mary-button class="btn-sm" wire:click="viewMap({{ $building->id }})">Mapa</x-mary-button>
                    @endscope
                    @scope('cell_actions', $building)
                        @can('edit_building')
                            <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil"
                                wire:click="edit({{ $building->id }})">Editar
                            </x-mary-button>
                            <x-mary-button class="{{ $building->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm"
                                icon="o-arrows-right-left" wire:click="toggle({{ $building->id }})">
                                {{ $building->active ? 'Desativar' : 'Ativar' }}
                            </x-mary-button>
                        @endcan
                    @endscope
                </x-mary-table>
            @endif
        </div>
    </div>
    <x-mary-drawer wire:model="showDrawer2" class="w-11/12 lg:w-1/3" right>
        <livewire:map />
        <x-mary-button label="Close" @click="$wire.showDrawer2 = false"></x-mary-button>
    </x-mary-drawer>

    @script
        <script>
            (g => {
                var h, a, k, p = 'The Google Maps JavaScript API',
                    c = 'google',
                    l = 'importLibrary',
                    q = '__ib__',
                    m = document,
                    b = window;
                b = b[c] || (b[c] = {});
                var d = b.maps || (b.maps = {}),
                    r = new Set,
                    e = new URLSearchParams,
                    u = () => h || (h = new Promise(async (f, n) => {
                        await (a = m.createElement('script'));
                        e.set('libraries', [...r] + '');
                        for (k in g) e.set(k.replace(/[A-Z]/g, t => '_' + t[0].toLowerCase()), g[k]);
                        e.set('callback', c + '.maps.' + q);
                        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                        d[q] = f;
                        a.onerror = () => h = n(Error(p + ' could not load.'));
                        a.nonce = m.querySelector('script[nonce]')?.nonce || '';
                        m.head.append(a)
                    }));
                d[l] ? console.warn(p + ' only loads once. Ignoring:', g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                    d[l](f, ...n))
            })({
                key: 'AIzaSyDec4JQ5-Lmct9btLJS2C9Ny9aBPQmZ9yQ',
                v: 'weekly',
                // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
                // Add other bootstrap parameters as needed, using camel case.
            });

            let map;

            async function initMap(longitude, latitude, title) {
                // The location of Uluru
                position = {
                    lat: parseFloat(latitude),
                    lng: parseFloat(longitude)
                };
                // Request needed libraries.
                //@ts-ignore
                const {
                    Map
                } = await google.maps.importLibrary("maps");
                const {
                    AdvancedMarkerElement, PinElement
                } = await google.maps.importLibrary("marker");

                // The map, centered at Uluru
                map = new Map(document.getElementById("mapDiv"), {
                    zoom: 18,
                    center: position,
                    mapId: "id_vig",
                });

                const pin = new PinElement({
                    scale: 1.5
                });

                // The marker, positioned at Uluru
                const marker = new AdvancedMarkerElement({
                    map: map,
                    content: pin.element,
                    position: position,
                    title: "Uluru",
                    gmpDraggable: true,
                    title: title,
                });               

                marker.addListener("dragend", (event) => {
                     const new_position = marker.position;
                     window.Livewire.dispatch('coordinates',[new_position]);
                });

            }

            window.Livewire.on('refreshMap', function(data) {
                initMap(data[0]['longitude'], data[0]['latitude'], data[0]['title']);
            });
        </script>
    @endscript
</div>
