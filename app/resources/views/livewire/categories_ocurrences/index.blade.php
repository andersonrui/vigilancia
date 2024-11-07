<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Categorias') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <!-- Formulário de criação -->
            @can('create_ocurrence_category')
                @if ($create_mode)
                    <div class="grid grid-cols-12 place-content-end">
                        <div class="col-start-1 col-end-13 sm:col-end-12 sm:mr-3">
                            <x-mary-input label="Nome" wire:model="name" />
                        </div>
                        <div class="col-start-1 col-end-4 sm:col-start-12 sm:col-end-13 sm:mt-7 mt-2">
                            <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                        </div>
                    </div>
                @endif
            @endcan

            <!-- Formulário de edição -->
            @can('edit_ocurrence_category')
                @if ($edit_mode)
                    <div class="grid grid-cols-12 place-content-end">
                        <div class="col-start-1 col-end-3 sm:col-end-2">
                            <x-mary-input label="ID" wire:model="category_ocurrence_id" readonly/>
                        </div>
                        <div class="col-start-1 col-end-13 sm:col-end-12 sm:mr-3">
                            <x-mary-input label="Nome" wire:model="name" />
                        </div>
                        <div class="col-start-1 col-end-4 sm:col-start-12 sm:col-end-13 mt-2 sm:mt-7">
                            <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                        </div>
                    </div>
                @endif
            @endcan

            <!-- Exibição da tabela -->
            @if ($show_table)
                <div class="grid grid-cols-12 place-content-end">
                    <div class="col-start-1 col-end-13 sm:col-end-2">
                        <x-mary-select label="Registros por página" :options="$pageSizes" wire:model.live="perPage" />
                    </div>
                    <div class="col-start-1 col-end-13 sm:col-start-10 sm:col-end-12 sm:mr-3">
                        <x-mary-input label="Busca" class="block" wire:model.live="searchInput">
                            <x-slot:prepend>
                                <x-mary-button class="btn-primary btn-square rounded-l-box rounded-r-none"
                                    icon="o-magnifying-glass-circle"></x-mary-button>
                            </x-slot:prepend>
                        </x-mary-input>
                    </div>
                    @can('create_ocurrence_category')
                        <div class="col-start-10 col-end-13 sm:col-start-12 sm:col-end-13 mt-7">
                            <x-mary-button class="btn btn-block btn-info" wire:click="create">Novo</x-mary-button>
                        </div>
                    @endcan
                </div>
                <x-mary-table class="table-sm" :headers="$headers" :rows="$categoriesOcurrences" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_actions', $categoryOcurrence)
                        @can('edit_ocurrence_category')
                            <x-mary-button class="btn-warning text-bold btn-sm btn-square sm:w-32 pt-1 sm:pt-0" icon="o-pencil" wire:click="edit({{$categoryOcurrence->id}})"><span class="scale-0 sm:scale-100">Editar</span>
                            </x-mary-button>
                            <x-mary-button class="{{ $categoryOcurrence->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm btn-square sm:w-32 pt-1 sm:pt-0"
                                icon="o-arrows-right-left" wire:click="toggle({{ $categoryOcurrence->id }})">
                                <span class="scale-0 sm:scale-100">{{ $categoryOcurrence->active ? 'Desativar' : 'Ativar' }}</span>
                            </x-mary-button>
                        @endcan
                    @endscope
                </x-mary-table>
            @endif
        </div>
    </div>
</div>
