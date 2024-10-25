<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Map extends Component
{

    public $latitude = -24.004815652595575;
    public $longitude = -48.34499210836187;
    public $key;

    public function render()
    {
        return view('livewire.map');
    }

    #[On('refresh-map')]
    public function refreshMap($coords)
    {
        $this->key = env('MAPS_KEY');
        $this->latitude = $coords['latitude'];
        $this->longitude = $coords['longitude'];
    }
}
