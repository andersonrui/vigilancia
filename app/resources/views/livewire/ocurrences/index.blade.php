<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Ocorrências') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <!-- Formulário de criação -->
            @can('create_ocurrence')
                @if ($create_mode)
                    <div class="h-auto">
                        <div class="grid grid-cols-12">
                            <div class="col-start-1 col-end-13 border-2 border-zinc-600 mr-2 p-3">
                                <div class="grid grid-cols-12">
                                    <div class="mb-2 col-start-1 col-end-13">
                                        <x-mary-input label="Título" wire:model="title" />
                                    </div>
                                    <div class="col-start-1 col-end-13 sm:col-end-3 mb-2">
                                        <x-mary-input type="date" label="Data da ocorrência" wire:model="start_date" />
                                    </div>
                                    <div class="col-start-1 sm:col-start-3 col-end-13 sm:col-end-6 mb-2 sm:ml-2">
                                        <x-mary-select label="Responsável" :options="$responsibles" wire:model="users_id"
                                            placeholder="Selecione um responsável..." />
                                    </div>
                                    <div class="col-start-1 sm:col-start-6 col-end-13 sm:col-end-10 mb-2 sm:ml-2">
                                        <x-mary-select label="Imóvel" :options="$buildings" wire:model="buildings_id"
                                            placeholder="Selecione um imóvel..." />
                                    </div>
                                    <div class="col-start-1 sm:col-start-10 col-end-13 mb-2 sm:ml-2">
                                        <x-mary-select label="Categoria" :options="$categories_ocurrences"
                                            wire:model="categories_ocurrences_id" placeholder="Selecione um imóvel..." />
                                    </div>
                                    <div class="mb-2 col-start-1 col-end-13">
                                        <x-mary-textarea class="h-48" label="Descrição da ocorrência"
                                            wire:model="description" />
                                    </div>
                                    <div class="mb-2">
                                        <x-mary-button class="btn-success"
                                            wire:click="save('create')">Salvar</x-mary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endcan

            <!-- Formulário de edição -->
            @can('edit_ocurrence')
                @if ($edit_mode)
                    <div class="h-auto">
                        <div class="grid grid-cols-12">
                            <div class="col-start-1 col-end-10 border-2 border-zinc-600 mr-2 p-3">
                                <div class="grid grid-cols-12">
                                    <div class="mb-2 col-start-1 col-end-2">
                                        <x-mary-input label="ID" wire:model="ocurrence_id" readonly />
                                    </div>
                                    <div class="mb-2 col-start-2 col-end-13 ml-2">
                                        <x-mary-input label="Título" wire:model="title" />
                                    </div>
                                    <div class="col-start-1 col-end-3 mb-2">
                                        <x-mary-input type="date" label="Data da ocorrência" wire:model="start_date" />
                                    </div>
                                    <div class="col-start-3 col-end-6 mb-2 ml-2">
                                        <x-mary-select label="Responsável" :options="$responsibles" wire:model="users_id"
                                            placeholder="Selecione um responsável..." />
                                    </div>
                                    <div class="col-start-6 col-end-10 mb-2 ml-2">
                                        <x-mary-select label="Imóvel" :options="$buildings" wire:model="buildings_id"
                                            placeholder="Selecione um imóvel..." />
                                    </div>
                                    <div class="col-start-10 col-end-13 mb-2 ml-2">
                                        <x-mary-select label="Categoria" :options="$categories_ocurrences"
                                            wire:model="categories_ocurrences_id" placeholder="Selecione um imóvel..." />
                                    </div>
                                    <div class="mb-2 col-start-1 col-end-13">
                                        <x-mary-textarea class="h-48" label="Descrição da ocorrência"
                                            wire:model="description" />
                                    </div>
                                    <div class="mb-2">
                                        <x-mary-button class="btn-success"
                                            wire:click="save('update')">Salvar</x-mary-button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-start-10 col-end-13 border-2">
                                B
                            </div>
                        </div>
                    </div>
                @endif
            @endcan

            <!-- Exibição da tabela -->
            @if ($show_table)
                <div class="grid sm:grid-cols-12 place-content-end grid-cols-6">
                    <div class="col-start-1 col-end-7 sm:col-end-2">
                        <x-mary-select label="Registros por página" :options="$pageSizes" wire:model.live="perPage" />
                    </div>
                    <div class="col-start-1 col-end-7 sm:col-start-10 sm:col-end-12 sm:mr-3 mb-2">
                        <x-mary-input label="Busca" class="block" wire:model.live="searchInput">
                            <x-slot:prepend>
                                <x-mary-button class="btn-primary btn-square rounded-l-box rounded-r-none"
                                    icon="o-magnifying-glass-circle"></x-mary-button>
                            </x-slot:prepend>
                        </x-mary-input>
                    </div>
                    <div class="col-start-1 col-end-3 sm:col-start-12 sm:col-end-12 mt-7 mb-4">
                        <x-mary-button class="btn btn-block btn-info" wire:click="create">Novo</x-mary-button>
                    </div>
                </div>
                <x-mary-table class="table-sm" :headers="$headers" :rows="$ocurrences" :sort-by="$sortBy" striped
                    with-pagination>
                    @scope('cell_created_at', $ocurrence)
                        {{ $ocurrence->created_at->format('d/m/Y H:i:s') }}
                    @endscope
                    @scope('cell_updated_at', $ocurrence)
                        {{ $ocurrence->updated_at->format('d/m/Y H:i:s') }}
                    @endscope
                    @scope('cell_actions', $ocurrence)
                        <x-mary-button class="btn-accent text-bold btn-sm btn-square sm:w-32 p-1" icon="o-eye"
                            wire:click="view({{ $ocurrence->id }})"><span class="scale-0 sm:scale-100">Visualizar</span>
                        </x-mary-button>
                        <x-mary-button class="btn-warning text-bold btn-sm btn-square sm:w-32 p-1" icon="o-pencil"
                            wire:click="edit({{ $ocurrence->id }})"><span class="scale-0 sm:scale-100">Editar</span>
                        </x-mary-button>
                    @endscope
                </x-mary-table>
            @endif
            <!-- Visualização -->
            @if ($view_mode)
                <div class="h-auto">
                    <div class="grid grid-cols-12">
                        <div class="col-start-1 col-end-13 sm:col-end-10 sm:border-2 border-zinc-200 sm:mr-2 sm:p-3">
                            <div class="mb-2 col-start-2 col-end-13">
                                <x-mary-input label="Título" wire:model="title" readonly />
                            </div>
                            <div class="mb-2 col-start-1 col-end-13">
                                <x-mary-textarea class="h-48" label="Descrição da ocorrência"
                                    wire:model="description" readonly />
                            </div>
                            @foreach($ocurrence->followups as $followup)
                                <div class="mb-2 col-start-1 col-end-13 border-2 rounded-box border-dashed bg-green-100 p-2 px-6 py-4">
                                    <div class="col-start-1 col-end-13">
                                        <small>Por: {{ $followup->responsible->name }} 
                                            em {{ $followup->created_at->format('d/m/Y') }}
                                            às {{ $followup->created_at->format('H:i:s') }}
                                            @if($followup->updated_at)
                                                | Editado em {{ $followup->updated_at->format('d/m/Y') }}
                                                às {{ $followup->updated_at->format('H:i:s') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-start-1 col-end-13">
                                        <pre>{{ $followup->description }}</pre>
                                    </div>
                                </div>
                            @endforeach
                            @can('create_followup')
                                @if($show_form_update)
                                    <div class="col-start-1 col-end-13">
                                        <x-mary-textarea class="h-24" label="Novo acompanhamento" wire:model="update_description"/>
                                    </div>
                                    <div class="col-start-12 col-end-13">
                                        <x-mary-button class="btn-success" icon="o-check" wire:click="saveUpdate('create')">Salvar</x-mary-button>
                                    </div>
                                @endif
                                @if(!$show_form_update)
                                    <div class="col-start-11 col-end-13">
                                        <x-mary-button class="btn-accent" wire:click="newFollowUp('{{ $ocurrence_id }}')">Acompanhamento</x-mary-button>
                                    </div>  
                                @endif
                            @endcan
                        </div>
                        <div class="col-start-1 sm:col-start-10 col-end-13 sm:border-2">
                            <div class="grid grid-cols-12">
                                <div class="mb-2 col-start-1 col-end-13 sm:ml-2 sm:mr-2">
                                    <x-mary-input label="ID" wire:model="ocurrence_id" readonly />
                                </div>
                                <div class="col-start-1 col-end-13 mb-2 sm:ml-2 sm:mr-2">
                                    <x-mary-input type="date" label="Data da ocorrência"
                                        wire:model="start_date" readonly />
                                </div>
                                <div class="col-start-1 col-end-13 mb-2 sm:ml-2 sm:mr-2">
                                    <x-mary-select label="Responsável" :options="$responsibles" wire:model="users_id"
                                        placeholder="Selecione um responsável..." readonly />
                                </div>
                                <div class="col-start-1 col-end-13 mb-2 sm:ml-2 sm:mr-2">
                                    <x-mary-select label="Imóvel" :options="$buildings" wire:model="buildings_id"
                                        placeholder="Selecione um imóvel..." readonly />
                                </div>
                                <div class="col-start-1 col-end-13 mb-2 sm:ml-2 sm:mr-2">
                                    <x-mary-select label="Categoria" :options="$categories_ocurrences"
                                        wire:model="categories_ocurrences_id" placeholder="Selecione um imóvel..." readonly />
                                </div>
                                @can('edit_ocurrence')
                                    <div class="mb-2 col-start-11 col-end-2 btn-block">
                                        <x-mary-button class="btn-warning" icon="o-pencil"
                                            wire:click="edit('{{ $ocurrence_id }}')">Editar</x-mary-button>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
