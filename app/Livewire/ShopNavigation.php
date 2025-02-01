<?php

namespace App\Livewire;

use Livewire\Component;

class ShopNavigation extends Component
{

    public $restaurant;
    public $shopBranch;
    public function render()
    {
        return view('livewire.shop-navigation');
    }

}
