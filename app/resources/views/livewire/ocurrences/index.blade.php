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
                <div class="h-auto">
                    <div class="grid grid-cols-12">
                        <div class="col-start-1 col-end-10 border-2 border-zinc-600 mr-2 p-3">
                            <div class="grid grid-cols-12">
                                <div class="mb-2 col-start-1 col-end-13">
                                    <x-mary-input label="Título" wire:model="title" />
                                </div>
                                <div class="col-start-1 col-end-3 mb-2">
                                    <x-mary-input type="date" label="Data de abertura" wire:model="start_date" />
                                </div>
                                <div class="col-start-3 col-end-13 mb-2 ml-2">
                                    <x-mary-input label="Responsável" wire:model="users_id" />
                                </div>
                                <div class="mb-2 col-start-1 col-end-13">
                                    <x-mary-input class="h-48" label="Descrição da ocorrência" wire:model="description" />
                                </div>
                                <div class="mb-2">
                                    <x-mary-button class="btn-success">Salvar</x-mary-button>
                                </div>
                            </div>
                        </div>
                        <div class="col-start-10 col-end-13 border-2">
                            B
                        </div>
                    </div>
                </div>

                {{-- <div class="grid grid-cols-12 place-content-end">
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
                        <x-mary-input label="Responsavel" wire:model="responsible" />
                    </div>
                    <div class="col-start-3 col-end-5 mr-3">
                        <x-mary-input label="Secretaria" wire:model="secretary_id" />
                    </div>
                    <div class="columns-1 mt-7">
                        <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                    </div>
                </div> --}}
            @endif

            <!-- Formulário de edição -->
            @if ($edit_mode)
                <div class="grid grid-cols-12 place-content-end">
                    <div class="col-end-2">
                        <x-mary-input label="ID" wire:model="secretary_id" readonly/>
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
                <x-mary-table class="table-sm" :headers="$headers" :rows="$ocurrences" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_actions', $ocurrence)
                        <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil" wire:click="edit({{$ocurrence->id}})">Editar
                        </x-mary-button>
                        <x-mary-button class="{{ $ocurrence->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm"
                            icon="o-arrows-right-left" wire:click="toggle({{ $ocurrence->id }})">
                            {{ $ocurrence->active ? 'Desativar' : 'Ativar' }}
                        </x-mary-button>
                    @endscope
                </x-mary-table>
            @endif
        </div>
    </div>
</div>
