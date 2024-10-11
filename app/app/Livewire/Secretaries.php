<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Secretary;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Secretaries extends Component
{
    use WithPagination;

    //Variáveis para controle do fluxo do formulário
    public $create_mode = false;
    public $edit_mode = false;  

    public Secretary $secretary;

    public $secretary_id;

    #[Validate('required|string|email')]
    public string $name = '';

    public bool $active;

    public function render()
    {
        return view('livewire.secretaries.form');
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;

        $this->secretary = new Secretary();
    }

    public function edit()
    {
        $this->create_mode = false;
        $this->edit_mode = true;

        $this->secretary = Secretary::find($this->secretary_id);
    }

    public function save($method)
    {
        $this->validate();

        $this->secretary->name = $this->name;
        $this->secretary->active = $this->active;
        
        $this->secretary->save();

        //gerar código para uso do toast

        $this->reset();
    }

    // public function reset()
    // {
    //     $this->secretary = null;
    //     $this->secretary_id = null;
    //     $this->name = null;
    //     $this->active = null;
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
}
