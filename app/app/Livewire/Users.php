<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{

    use Toast;

    public $create_mode = false;
    public $edit_mode = false;
    public $show_table = true;
    public $password_form = false;

    public $user_id;

    public $name;

    public $email;

    public $role;

    public $user;

    #[Validate('nullable|confirmed')]
    public $password;

    public $password_confirmation;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'name', 'label' => 'Nome', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'email', 'label' => 'E-mail', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'active', 'label' => 'Ativo', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'roles', 'label' => 'Papel', 'class' => 'w-4/5', 'sortable' => false],
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
        return view('livewire.users')->with([
            'users' => $this->users(),
            'roles' => $this->roles()
        ]);
    }

    public function users()
    {
        return User::select('*')->with(['roles'])->paginate($this->perPage);
    }

    public function roles()
    {
        return Role::all();
    }

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;
        $this->password_form = false;
    }

    public function save($method)
    {
        $this->validate();

        $message = [
            'create' => 'Usuário criado com sucesso!',
            'update' => 'Usuário atualizado com sucesso!',
            'password' => 'Senha alterada com sucesso!'
        ];

        $user;

        if($method == 'create')
        {
            $user = new User();
        } else {
            $user = User::find($this->user_id);
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);

        if($user->save())
        {
            if($method != "password")
            {
                $role = Role::find($this->role);
                $user->syncRoles($role->name);
            }
            
            $this->success(
                title:'Sucesso', 
                description: $message[$method], 
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

    public function edit($id)
    {
        $this->user = User::with(['roles'])->find($id);

        $this->user_id = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->roles[0]->id;

        $this->edit_mode = true;
        $this->create_mode = false;
        $this->show_table = false;
        $this->password_form = false;
    }

    public function toggle($id)
    {
        $user = User::find($id);
        $user->toggleActive();
        $this->users();
    }

    public function changePassword($id)
    {
        $this->password_form = true;
        $this->edit_mode = false;
        $this->create_mode = false;
        $this->show_table = false;

        $this->user = User::find($id);

        $this->user_id = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        
    }
}
