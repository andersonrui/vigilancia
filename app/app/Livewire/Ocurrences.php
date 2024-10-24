<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Ocurrence;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Ocurrences extends Component
{
    use WithPagination;

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
    public string $start_date = '';

    #[Validate('required|date')]
    public string $solution_date = '';

    #[Validate('required|int')]
    public string $categories_ocurrences_id;

    #[Validate('required|int')]
    public string $ocurrences_id;

    #[Validate('required|int')]
    public string $users_id;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'title', 'label' => 'Título', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'updated_at', 'label' => 'Atualização', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'created_at', 'label' => 'Criação', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'buildings_id', 'label' => 'Imóvel', 'class' => 'w-4/5', 'sortable' => true]
    ];
#
    public $pageSizes = [
        ['id' => 5, 'name' => 5],
        ['id' => 10, 'name' => 10],
    ];

    public $perPage = 5;

    public $searchInput = "";

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function render()
    {
        return view('livewire.ocurrences.index', [
            'ocurrences' => $this->ocurrences()
        ]);
    }

    public function ocurrences()
    {
        $ocurrences = Ocurrence::select('*')->orderBy($this->sortBy['column'], $this->sortBy['direction']);

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

        $this->ocurrence->title = $this->title;
        $this->ocurrence->description = $this->description;
        $this->ocurrence->start_date = $this->start_date;
        $this->ocurrence->solution_date = $this->solution_date;
        $this->ocurrence->categories_ocurrences_id = $this->categories_ocurrences_id;
        $this->ocurrence->buildings_id = $this->buildings_id;
        $this->ocurrence->users_id = $this->users_id;
        
        $this->ocurrence->save();

        $this->reset();
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
}
