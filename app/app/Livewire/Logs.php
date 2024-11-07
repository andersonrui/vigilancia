<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class Logs extends Component
{

    public $search;
    public $activity;

    public $perPage = 25;

    public $pageSizes = [
        ['id' => 25, 'name' => 25],
        ['id' => 50, 'name' => 50],
    ];

    public $searchInput = "";

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1/5'],
        ['key' => 'description', 'label' => 'Ação', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'subject_type', 'label' => 'Modificado', 'class' => 'w-4/5', 'sortable' => true],
        ['key' => 'causer_type', 'label' => 'Modificador', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'causer.name', 'label' => 'ID_Modificador', 'class' => 'w-4/5', 'sortable' => false],
        ['key' => 'properties', 'label' => 'Alterações', 'class' => 'w-1/5'],
    ];

    public $models = [
        ['id' => 'Building', 'name' => 'Building'],
        ['id' => 'CategoryOcurrence', 'name' => 'CategoryOcurrence'],
        ['id' => 'Ocurrence', 'name' => 'Ocurrence'],
        ['id' => 'OcurrenceUpdate', 'name' => 'OcurrenceUpdate'],
        ['id' => 'Secretary', 'name' => 'Secretary'],
        ['id' => 'User', 'name' => 'User']
    ];

    public $model;

    public $user;

    public function render()
    {
        return view('livewire.logs')->with([
            'activities' => $this->activities(),
            'users' => $this->users()
        ]);
    }

    public function activities()
    {
        $activities = Activity::select('*');

        if($this->searchInput != "")
        {
            $activities = $activities->where('properties', 'like', '%'. $this->searchInput . '%');
        }

        if($this->model)
        {
            $activities = $activities->where('subject_type', 'like', '%' . $this->model . '%');
        }

        if($this->user)
        {
            $activities = $activities->where('causer_id', $this->user);
        }
        
        return $activities->with(['causer'])->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    public function users()
    {
        return User::all();
    }
}
