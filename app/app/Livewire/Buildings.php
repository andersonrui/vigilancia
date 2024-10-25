<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Building;
use App\Models\Secretary;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Mary\Traits\Toast;
use Koossaayy\LaravelMapbox\Components\Mapbox;

class Buildings extends Component
{
    use WithPagination;
    use Toast;

    //Variáveis para controle do fluxo do formulário
    public $create_mode = false;
    public $edit_mode = false;  
    public $show_table = true;

    public Building $building;

    public $building_id;

    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string')]
    public string $address = '';

    public string $number = '';

    #[Validate('required|string')]
    public string $neighborhood = '';

    #[Validate('required|string')]
    public string $postal_code = '';

    #[Validate('required|string')]
    public string $latitude;

    #[Validate('required|string')]
    public string $longitude;

    public bool $active = TRUE;

    #[Validate('required|int')]
    public string $responsible;

    #[Validate('required|int')]
    public string $secretary_id;

    public Collection $secretaries;

    public Collection $responsibles;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'name', 'label' => 'Nome', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'address', 'label' => 'Endereço', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'neighborhood', 'label' => 'Bairro', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'map', 'label' => 'Visualizar', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'secretary.name', 'label' => 'Secretaria', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Ações', 'class' => 'w-1/5']
    ];
#
    public $pageSizes = [
        ['id' => 5, 'name' => 5],
        ['id' => 10, 'name' => 10],
    ];

    public $perPage = 5;

    public $searchInput = "";

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $mapBoxContainer;

    public $show_map_box = false;

    public $current;

    public bool $myModal1;

    public $showDrawer2 = false;

    public function render()
    {

        $this->secretaries = Secretary::where('active', true)->get();
        $this->responsibles = User::where('active', true)->get();

        return view('livewire.buildings.index', [
            'buildings' => $this->buildings(),
            'secretaries' => $this->secretaries,
            'responsibles' => $this->responsibles
        ]);
    }

    public function buildings()
    {
        $buildings = Building::select('*')
            ->with(['secretary'])
            ->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        if ($this->searchInput != ""){
            $buildings = $buildings->where('name', 'like', '%' . $this->searchInput . '%')
                ->orWhere('address', 'like', '%' . $this->searchInput . '%')
                ->orWhere('neighborhood', 'like', '%' . $this->searchInput . '%');
        }

        return $buildings->paginate($this->perPage);
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;

        $this->building = new Building();
    }

    public function edit($id)
    {
        $this->create_mode = false;
        $this->edit_mode = true;
        $this->show_table = false;

        $this->building = Building::find($id);

        $this->building_id = $this->building->id;
        $this->name = $this->building->name;
        $this->address = $this->building->address;
        $this->number = $this->building->number;
        $this->neighborhood = $this->building->neighborhood;
        $this->postal_code = $this->building->postal_code;
        $this->latitude = $this->building->latitude;
        $this->longitude = $this->building->longitude;
        $this->responsible = $this->building->responsible;
        $this->secretary_id = $this->building->secretary_id;
    }

    public function save($method)
    {
        $this->validate();

        $toastMessage = [
            'create' => 'O registro foi salvo com sucesso!',
            'update' => 'O registro foi atualizado com sucesso!'
        ];

        $this->building->name = $this->name;
        $this->building->address = $this->address;
        $this->building->number = $this->number;
        $this->building->neighborhood = $this->neighborhood;
        $this->building->postal_code = $this->postal_code;
        $this->building->latitude = $this->latitude;
        $this->building->longitude = $this->longitude;
        $this->building->responsible = $this->responsible;
        $this->building->secretary_id = $this->secretary_id;
        $this->building->active = $this->active;
        
        if($this->building->save()){
            $this->success(
                title:'Sucesso', 
                description: $toastMessage[$method], 
                position:'toast-top toast-end',
                timeout:2000
            );
            $this->reset();
        } else {
            $this->error(
                title:'Erro', 
                description: 'Ocorreu um erro ao tentar salvar o registro.<br> Se o problema continuar, contacte o administrador do sistema.', 
                position:'toast-top toast-end',
                timeout:2000
            );
        }
    }

    // public function reset()
    // {
    //     $this->building = null;
    //     $this->building_id = null;
    //     $this->name = null;
    //     $this->active = TRUE;
    // }

    public function cancelConfirmation()
    {
        $this->dispatch('cancelConfirmation');
    }

    #[On('cancel:confirm')]
    public function cancel()
    {
        $this->reset();
    }

    public function toggle($id)
    {
        $building = Building::find($id);
        $building->toggleActive();
        $this->buildings();
    }

    /**
     * Verifica se a propriedade atualizada é uma propriedade de controle.
     * Caso positivo, atualiza a lista de registros automaticamente.
     */
    public function updated($property)
    {
        $controlProperties = ['perPage', 'searchInput'];

        if (in_array($property, $controlProperties)){
            $this->buildings();
        }
    }

    public function refreshSecretaries()
    {
        $this->secretaries = Secretary::where('active')->get();
    }

    public function refreshResponsibles()
    {
        $this->responsibles = User::where('active')->get();
    }

    public function viewMap($id)
    {
        $this->building = Building::find($id);

        $this->dispatch('refresh-map', ['latitude' => $this->building->latitude, 'longitude' => $this->building->longitude]);
        // $this->myModal1 = true;

        $this->showDrawer2 = true;
    }
}
