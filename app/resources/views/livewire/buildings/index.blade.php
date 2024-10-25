<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Categorias') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <!-- Formulário de criação -->
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
                </div>
            @endif

            <!-- Formulário de edição -->
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
                        <x-mary-input label="Responsavel" wire:model="responsible" />
                    </div>
                    <div class="col-start-3 col-end-5 mr-3">
                        <x-mary-input label="Secretaria" wire:model="secretary_id" />
                    </div>
                    <div class="columns-1 mt-7">
                        <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                    </div>
                </div>
            @endif

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
                    <div class="col-start-12 col-end-12 mt-7">
                        <x-mary-button class="btn btn-block btn-info" wire:click="create">Novo</x-mary-button>
                    </div>
                </div>
                <x-mary-table class="table-sm" :headers="$headers" :rows="$buildings" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_map', $building)
                        <x-mary-button class="btn-sm" wire:click="viewMap({{ $building->id }})">Mapa</x-mary-button>
                    @endscope
                    @scope('cell_actions', $building)
                        <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil"
                            wire:click="edit({{ $building->id }})">Editar
                        </x-mary-button>
                        <x-mary-button class="{{ $building->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm"
                            icon="o-arrows-right-left" wire:click="toggle({{ $building->id }})">
                            {{ $building->active ? 'Desativar' : 'Ativar' }}
                        </x-mary-button>
                    @endscope
                </x-mary-table>
            @endif
        </div>
    </div>

    {{-- <x-mary-modal wire:model="myModal1" class="backdrop-blur h-auto w-full">

        <div class="h-96 relative w-2/3">
            <livewire:map />
        </div>
        <x-mary-button label="Cancel" @click="$wire.myModal1 = false" />
    </x-mary-modal> --}}
    {{-- Right --}}
    <x-mary-drawer wire:model="showDrawer2" class="w-11/12 lg:w-1/3" right>
        <livewire:map />
        <x-mary-button label="Close" @click="$wire.showDrawer2 = false" />
    </x-mary-drawer>


</div>
