<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Mary\Traits\Toast;


class Roles extends Component
{

    use Toast;

    public $show_table = true;
    public $edit_mode = false;
    public $create_mode = false;
    public $assign_permission = false;
    
    public $permission_show_table = true;
    public $permission_edit_mode = false;
    public $permission_create_mode = false;

    public $selectedPermissions = [];

    public $role;

    public $role_id;

    public $assignedPermissions;

    public $role_name;

    public $guard_name = 'web';

    public $selectedTab = 'roles-tab';

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'name', 'label' => 'Nome', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'guard_name', 'label' => 'Interface', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'actions', 'label' => 'Ações', 'class' => 'w-1/5']
    ];

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $permission;

    public $permission_id;

    public $permission_name;

    public function render()
    {
        return view('livewire.roles')->with([
            'roles' => $this->roles(),
            'permissions' => $this->permissions()
        ]);
    }

    public function roles()
    {
        return $roles = Role::all();
    }

    public function permissions()
    {
        return $permissions = Permission::all();
    }

    public function save($method)
    {
        $message = [
            'create' => 'O papel foi criado com sucesso!',
            'update' => 'O papel foi atualizado com sucesso!',
        ];

        $role;

        if($method == 'create')
        {
            $role = new Role();
        } else {
            $role = Role::find($this->role_id);
        }

        $role->name = $this->role_name;
        $role->guard_name = $this->guard_name;

        if($role->save())
        {
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

    public function savePermission($method)
    {
        $message = [
            'create' => 'A permissão foi criada com sucesso!',
            'update' => 'A permissão foi atualizada com sucesso!',
        ];

        $permission;

        if($method == 'create')
        {
            $permission = new Permission();
        } else {
            $permission = Permission::find($this->permission_id);
        }

        $permission->name = $this->permission_name;
        $permission->guard_name = $this->guard_name;

        if($permission->save())
        {
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

    public function assignPermissions($id)
    {
        $this->assign_permission = true;
        $this->create_mode = false;
        $this->edit_mode = false;
        $this->show_table = false;

        $this->role = Role::with(['permissions'])->find($id);

        $this->selectedPermissions = [];
        
        foreach($this->permissions()->toArray() as $permission)
        {
            $this->selectedPermissions[$permission['name']] = false;
        }
        
        foreach($this->role->permissions()->get() as $modelPermission)
        {
            $this->selectedPermissions[$modelPermission->name] = true;
        }
    }  

    public function create()
    {
        $this->create_mode = true;
        $this->edit_mode = false;
        $this->show_table = false;
    }

    public function edit($id)
    {
        $this->edit_mode = true;
        $this->show_table = false;
        $this->create_mode = false;

        $this->role = Role::find($id);
        $this->role_id = $this->role->id;
        $this->role_name = $this->role->name;
    }

    public function createPermission()
    {
        $this->permission_create_mode = true;
        $this->permission_show_table = false;
        $this->permission_edit_mode = false;
    }

    public function editPermission($id)
    {
        $this->permission = Permission::find($id);

        $this->permission_id = $this->permission->id;
        $this->permission_name = $this->permission->name;

        $this->permission_create_mode = false;
        $this->permission_edit_mode = true;
        $this->permission_show_table = false;
    }

    public function roleCancel()
    {
        $this->reset();
    }

    public function syncPermissions()
    {

        $permissions = [];

        foreach($this->selectedPermissions as $name => $selectedPermission)
        {
            if($selectedPermission)
            {
                array_push($permissions, $name);
            }
        }

        if($this->role->syncPermissions($permissions))
        {
            $this->success(
                title:'Sucesso', 
                description: 'Permissões atualizadas com sucesso!', 
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
}
