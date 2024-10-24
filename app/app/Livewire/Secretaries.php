<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Secretary;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Secretaries extends Component
{
    use WithPagination;
    use Toast;

    //Variáveis para controle do fluxo do formulário
    public $create_mode = false;
    public $edit_mode = false;  
    public $show_table = true;

    public Secretary $secretary;

    public $secretary_id;

    #[Validate('required|string')]
    public string $name = '';

    public bool $active = TRUE;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'name', 'label' => 'Nome', 'class' => 'w-4/5'],
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

    public function render()
    {
        return view('livewire.secretaries.index', [
            'secretaries' => $this->secretaries()
        ]);
    }

    public function secretaries()
    {
        $secretaries = Secretary::select('*')->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        if ($this->searchInput != ""){
            $secretaries = $secretaries->where('name', 'like', '%' . $this->searchInput . '%');
        }

        return $secretaries->paginate($this->perPage);
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;

        $this->secretary = new Secretary();
    }

    public function edit($id)
    {
        $this->create_mode = false;
        $this->edit_mode = true;
        $this->show_table = false;

        $this->secretary = Secretary::find($id);

        $this->secretary_id = $this->secretary->id;
        $this->name = $this->secretary->name;
    }

    public function save($method)
    {

        $toastMessage = [
            'create' => 'O registro foi salvo com sucesso!',
            'update' => 'O registro foi atualizado com sucesso!'
        ];

        $this->validate();

        $this->secretary->name = $this->name;
        $this->secretary->active = $this->active;
        
        if($this->secretary->save()){
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
    //     $this->secretary = null;
    //     $this->secretary_id = null;
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
        $secretary = Secretary::find($id);
        $secretary->toggleActive();
        $this->secretaries();
    }

    /**
     * Verifica se a propriedade atualizada é uma propriedade de controle.
     * Caso positivo, atualiza a lista de registros automaticamente.
     */
    public function updated($property)
    {
        $controlProperties = ['perPage', 'searchInput'];

        if (in_array($property, $controlProperties)){
            $this->secretaries();
        }
    }
}
