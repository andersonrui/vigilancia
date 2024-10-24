<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Building;
use App\Models\CategoryOcurrence;
use App\Models\Ocurrence;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Mary\Traits\Toast;

class Ocurrences extends Component
{
    use WithPagination;
    use Toast;

    //Variáveis para controle do fluxo do formulário
    public $create_mode = false;
    public $edit_mode = false;  
    public $show_table = true;

    public Ocurrence $ocurrence;

    public $ocurrence_id;

    #[Validate('required|string')]
    public string $title = '';

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('required|date')]
    public $start_date;

    #[Validate('nullable|date')]
    public $solution_date;

    #[Validate('required|int')]
    public int $categories_ocurrences_id;

    public int $ocurrences_id;

    #[Validate('required|int')]
    public int $users_id;

    #[Validate('required|int')]
    public int $buildings_id;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'title', 'label' => 'Título', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'updated_at', 'label' => 'Atualização', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'created_at', 'label' => 'Criação', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'building.name', 'label' => 'Imóvel', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'categoryOcurrence.name', 'label' => 'Categoria', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Ações', 'class' => 'w-4/5', 'sortable' => false]
    ];

    public $pageSizes = [
        ['id' => 5, 'name' => 5],
        ['id' => 10, 'name' => 10],
    ];

    public $perPage = 5;

    public $searchInput = "";

    public array $sortBy = ['column' => 'updated_at', 'direction' => 'desc'];

    public Collection $responsibles;

    public Collection $buildings;

    public Collection $categories_ocurrences;

    public function render()
    {

        $this->responsibles = User::where('active', true)->orderBy('name', 'asc')->get();

        $this->buildings = Building::where('active', true)->orderBy('name', 'asc')->get();

        $this->categories_ocurrences = CategoryOcurrence::where('active', true)->orderBy('name', 'asc')->get();

        return view('livewire.ocurrences.index', [
            'ocurrences' => $this->ocurrences(),
            'responsibles' => $this->responsibles,
            'categories_ocurrences' => $this->categories_ocurrences,
            'buildings' => $this->buildings
        ]);
    }

    public function ocurrences()
    {
        $ocurrences = Ocurrence::select('*')
            ->with(['responsible', 'categoryOcurrence', 'building'])
            ->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        if ($this->searchInput != ""){
            $ocurrences = $ocurrences->where('description', 'like', '%' . $this->searchInput . '%')
            ->orWhere('title', 'like', '%' . $this->searchInput . '%');
        }

        return $ocurrences->paginate($this->perPage);
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;

        $this->ocurrence = new Ocurrence();
    }

    public function edit($id)
    {
        $this->create_mode = false;
        $this->edit_mode = true;
        $this->show_table = false;

        $this->ocurrence = Ocurrence::find($id);

        $this->ocurrence_id = $this->ocurrence->id;
        $this->title = $this->ocurrence->title;
        $this->description = $this->ocurrence->description;
        $this->start_date = $this->ocurrence->start_date;
        $this->solution_date = $this->ocurrence->solution_date;
        $this->categories_ocurrences_id = $this->ocurrence->categories_ocurrences_id;
        $this->buildings_id = $this->ocurrence->buildings_id;
        $this->users_id = $this->ocurrence->users_id;
        
    }

    public function save($method)
    {
        $this->validate();
        
        $toastMessage = [
            'create' => 'O registro foi salvo com sucesso!',
            'update' => 'O registro foi atualizado com sucesso!'
        ];

        $this->ocurrence->title = $this->title;
        $this->ocurrence->description = $this->description;
        $this->ocurrence->start_date = $this->start_date;

        if(isset($this->solution_date)){
            $this->ocurrence->solution_date = $this->solution_date;
        }

        $this->ocurrence->categories_ocurrences_id = $this->categories_ocurrences_id;
        $this->ocurrence->buildings_id = $this->buildings_id;
        $this->ocurrence->users_id = $this->users_id;
        
        if($this->ocurrence->save()){
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
    //     $this->ocurrence = null;
    //     $this->ocurrence_id = null;
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

    /**
     * Verifica se a propriedade atualizada é uma propriedade de controle.
     * Caso positivo, atualiza a lista de registros automaticamente.
     */
    public function updated($property)
    {
        $controlProperties = ['perPage', 'searchInput'];

        if (in_array($property, $controlProperties)){
            $this->ocurrences();
        }
    }

    public function refreshResponsibles()
    {
        $this->responsibles = User::where('active', true)->orderBy('name', 'asc')->get();        
    }

    public function refreshBuildings()
    {
        $this->buildings = Building::where('active', true)->orderBy('name', 'asc')->get();        
    }

    public function refreshCategoriesOcurrences()
    {
        $this->categories_ocurrences = CategoryOcurrence::where('active', true)->orderBy('name', 'asc')->get();        
    }
}
