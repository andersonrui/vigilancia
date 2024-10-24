<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Secretarias') }}
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
                    <div class="columns-1 mt-7">
                        <x-mary-button class="btn-block btn-success" wire:click="save('create')">Salvar</x-mary-button>
                    </div>
                </div>
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
                <x-mary-table class="table-sm" :headers="$headers" :rows="$secretaries" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_actions', $secretary)
                        <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil" wire:click="edit({{$secretary->id}})">Editar
                        </x-mary-button>
                        <x-mary-button class="{{ $secretary->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm"
                            icon="o-arrows-right-left" wire:click="toggle({{ $secretary->id }})">
                            {{ $secretary->active ? 'Desativar' : 'Ativar' }}
                        </x-mary-button>
                    @endscope
                </x-mary-table>
            @endif
        </div>
    </div>
</div>
