<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Categorias') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-4/5 mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid grid-cols-12 place-content-end">
                <div class="col-end-2">
                    <x-mary-select label="Registros por página" :options="$pageSizes" wire:model.live="perPage" />
                </div>
                <div class="col-start-2 col-end-5 ml-2">
                    <x-mary-select label="Modelo" :options="$models" wire:model.live="model" placeholder="Selecione um modelo..." wire:change="activities()"/>
                </div>
                <div class="col-start-5 col-end-8 ml-2">
                    <x-mary-select label="Usuário" :options="$users" wire:model.live="user" placeholder="Selecione um usuário..."/>
                </div>
                <div class="col-start-11 col-end-13 mr-3">
                    <x-mary-input label="Busca" class="block" wire:model.live="searchInput">
                        <x-slot:prepend>
                            <x-mary-button class="btn-primary btn-square rounded-l-box rounded-r-none"
                                icon="o-magnifying-glass-circle"></x-mary-button>
                        </x-slot:prepend>
                    </x-mary-input>
                </div>
            </div>
            <x-mary-table class="table-sm" :headers="$headers" :rows="$activities" :sort-by="$sortBy" striped
                with-pagination>
                @scope('cell_properties', $activity)
                    @php
                        $propriedades = json_decode($activity->properties, true);
                        if(isset($propriedades['old']))
                        {
                            $old = $propriedades['old'];
                        }
                        
                        if(isset($propriedades['attributes']))
                        {
                            $new = $propriedades['attributes'];
                        }
                    @endphp
                    @if(isset($old))
                        @foreach($old as $key => $value)
                            @if(strval($value) != strval($new[$key]))
                                @if($key == 'password')
                                    Changed Password </br>
                                @else
                                    {{ $key }}: {{ $value }} => {{ $new[$key] }} </br>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endscope
                @scope('cell_actions', $activity)
                    {{-- @can('edit_building')
                        <x-mary-button class="btn-warning text-bold btn-sm" icon="o-pencil"
                            wire:click="edit({{ $building->id }})">Editar
                        </x-mary-button>
                        <x-mary-button class="{{ $building->active ? 'btn-error' : 'btn-success' }} text-bold btn-sm"
                            icon="o-arrows-right-left" wire:click="toggle({{ $building->id }})">
                            {{ $building->active ? 'Desativar' : 'Ativar' }}
                        </x-mary-button>
                    @endcan --}}
                @endscope
            </x-mary-table>
        </div>
    </div>
</div>
