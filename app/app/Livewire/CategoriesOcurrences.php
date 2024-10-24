<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\CategoryOcurrence;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class CategoriesOcurrences extends Component
{
    use WithPagination;
    use Toast;

    //Variáveis para controle do fluxo do formulário
    public $create_mode = false;
    public $edit_mode = false;  
    public $show_table = true;

    public CategoryOcurrence $categoryOcurrence;

    public $category_ocurrence_id;

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
        return view('livewire.categories_ocurrences.index', [
            'categoriesOcurrences' => $this->categoryOcurrences()
        ]);
    }

    public function categoryOcurrences()
    {
        $categoriesOcurrences = CategoryOcurrence::select('*')->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        if ($this->searchInput != ""){
            $categoriesOcurrences = $categoriesOcurrences->where('name', 'like', '%' . $this->searchInput . '%');
        }

        return $categoriesOcurrences->paginate($this->perPage);
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;

        $this->categoryOcurrence = new CategoryOcurrence();
    }

    public function edit($id)
    {
        $this->create_mode = false;
        $this->edit_mode = true;
        $this->show_table = false;

        $this->categoryOcurrence = CategoryOcurrence::find($id);

        $this->category_ocurrence_id = $this->categoryOcurrence->id;
        $this->name = $this->categoryOcurrence->name;
    }

    public function save($method)
    {
        $this->validate();

        $toastMessage = [
            'create' => 'O registro foi salvo com sucesso!',
            'update' => 'O registro foi atualizado com sucesso!'
        ];

        $this->categoryOcurrence->name = $this->name;
        $this->categoryOcurrence->active = $this->active;
        
        if($this->categoryOcurrence->save()){
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
    //     $this->categoryOcurrence = null;
    //     $this->category_ocurrence_id = null;
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
        $categoryOcurrence = CategoryOcurrence::find($id);
        $categoryOcurrence->toggleActive();
        $this->categoryOcurrences();
    }

    /**
     * Verifica se a propriedade atualizada é uma propriedade de controle.
     * Caso positivo, atualiza a lista de registros automaticamente.
     */
    public function updated($property)
    {
        $controlProperties = ['perPage', 'searchInput'];

        if (in_array($property, $controlProperties)){
            $this->categoryOcurrences();
        }
    }
}
