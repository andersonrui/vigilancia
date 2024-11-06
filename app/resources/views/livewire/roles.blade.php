<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Categorias') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <x-mary-tabs wire:model="selectedTab">
                <x-mary-tab name="roles-tab" label="Funções">
                    @if($show_table)
                        <div class="grid grid-cols-12 place-content-end">
                            @can('create_role')
                                <div class="col-start-12 col-end-13">
                                    <x-mary-button class="btn-block btn-success" wire:click="create">Novo</x-mary-button>
                                </div>
                            @endcan
                        </div>
                    @endif
                    <div class="grid grid-cols-12 place-content-end">
                        @if($show_table)
                            <div class="col-start-1 col-end-13">
                                <x-mary-table class="table-sm" :headers="$headers" :rows="$roles" :sort-by="$sortBy" striped >
                                    @scope('cell_actions', $role)
                                        <x-mary-button class="btn-warning text-bold btn-sm ml-2" icon="o-pencil"
                                            wire:click="edit({{ $role->id }})">Editar
                                        </x-mary-button>
                                        <x-mary-button class="btn-info text-bold btn-sm" icon="o-pencil"
                                            wire:click="assignPermissions({{ $role->id }})">Permissões
                                        </x-mary-button>
                                    @endscope
                                </x-mary-table>
                            </div>
                        @endif
                        @can('edit_role')
                            @if($edit_mode)
                                <div class="col-end-2">
                                    <x-mary-input label="ID" wire:model="role_id" readonly />
                                </div>
                                <div class="col-start-2 col-end-9 ml-3 mr-3">
                                    <x-mary-input label="Nome" wire:model="role_name" />
                                </div>
                                <div class="col-start-9 col-end-11 mr-3">
                                    <x-mary-input label="Interface" wire:model="guard_name" />
                                </div>
                                <div class="col-start-11 col-end-12 mt-7">
                                    <x-mary-button class="btn-block btn-success" wire:click="save('update')">Salvar</x-mary-button>
                                </div>
                                <div class="col-start-12 col-end-13 mt-7 ml-2">
                                    <x-mary-button class="btn-block btn-error" wire:click="roleCancel">Cancelar</x-mary-button>
                                </div>
                            @endif
                        @endcan
                        @can('create_role')
                            @if($create_mode)
                                <div class="col-start-1 col-end-9 ml-3 mr-3">
                                    <x-mary-input label="Nome" wire:model="role_name" />
                                </div>
                                <div class="col-start-9 col-end-11 mr-3">
                                    <x-mary-input label="Interface" wire:model="guard_name" />
                                </div>
                                <div class="col-start-11 col-end-12 mt-7">
                                    <x-mary-button class="btn-block btn-success" wire:click="save('create')">Salvar</x-mary-button>
                                </div>
                                <div class="col-start-12 col-end-13 mt-7">
                                    <x-mary-button class="btn-block btn-error" wire:click="roleCancel">Cancelar</x-mary-button>
                                </div>
                            @endif
                        @endcan
                        @can('edit_role')
                            @if($assign_permission)
                                    <div class="col-start-1 col-end-2 place-content-center">
                                        <h1>{{ $role->name }}</h1>
                                    </div>
                                    @foreach($permissions as $permission)
                                        <div class="col-start-2 col-end-4 mt-2">
                                            <x-mary-checkbox 
                                                wire:model.live="selectedPermissions.{{ $permission->name }}" 
                                                label="{{ $permission->name }}"
                                                value="{{ $permission->name }}" 
                                            />                    
                                        </div>
                                    @endforeach
                                    <div class="col-start-2 col-end-3 mt-6">
                                        <x-mary-button class="btn-block btn-success" wire:click="syncPermissions()">Salvar</x-mary-button>
                                    </div>
                                    
                            @endif
                        @endcan
                    </div>
                </x-mary-tab>
                <x-mary-tab name="permissions-tab" label="Permissões">
                    @if($permission_show_table)
                    <div class="grid grid-cols-12 place-content-end">
                        <div class="col-start-12 col-end-13">
                            <x-mary-button class="btn-block btn-success" wire:click="createPermission">Novo</x-mary-button>
                        </div>
                    </div>
                        <div class="col-start-1 col-end-13">
                            <x-mary-table class="table-sm" :headers="$headers" :rows="$permissions" :sort-by="$sortBy" striped >
                                @scope('cell_actions', $permission)
                                    <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil"
                                        wire:click="editPermission({{ $permission->id }})">Editar
                                    </x-mary-button>
                                @endscope
                            </x-mary-table>
                        </div>
                    @endif
                    <div class="grid grid-cols-12 place-content-end">
                        @can('edit_role')
                            @if($permission_edit_mode)
                                <div class="col-end-2">
                                    <x-mary-input label="ID" wire:model="permission_id" readonly />
                                </div>
                                <div class="col-start-2 col-end-9 ml-3 mr-3">
                                    <x-mary-input label="Nome" wire:model="permission_name" />
                                </div>
                                <div class="col-start-9 col-end-11 mr-3">
                                    <x-mary-input label="Interface" wire:model="guard_name" />
                                </div>
                                <div class="col-start-11 col-end-12 mt-7">
                                    <x-mary-button class="btn-block btn-success" wire:click="savePermission('update')">Salvar</x-mary-button>
                                </div>
                                <div class="col-start-12 col-end-13 mt-7 ml-2">
                                    <x-mary-button class="btn-block btn-error" wire:click="cancelRole">Cancelar</x-mary-button>
                                </div>
                            @endif
                        @endcan
                        @can('create_role')
                            @if($permission_create_mode)
                                <div class="col-start-1 col-end-8 ml-3 mr-3">
                                    <x-mary-input label="Nome" wire:model="permission_name" />
                                </div>
                                <div class="col-start-8 col-end-11 mr-3">
                                    <x-mary-input label="Interface" wire:model="guard_name" />
                                </div>
                                <div class="col-start-11 col-end-12 mt-7">
                                    <x-mary-button class="btn-block btn-success" wire:click="savePermission('create')">Salvar</x-mary-button>
                                </div>
                                <div class="col-start-12 col-end-13 mt-7">
                                    <x-mary-button class="btn-block btn-error" wire:click="cancelRole">Cancelar</x-mary-button>
                                </div>
                            @endif    
                        @endcan
                    </div>
                </x-mary-tab>
            </x-mary-tabs>
        </div>
    </div>
</div>
