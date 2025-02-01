<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class ShopDesktopNavigation extends Component
{
    protected $listeners = ['setCustomer' => '$refresh'];

    public $orderItemCount = 0;
    public $restaurant;
    public $shopBranch;

    #[On('updateCartCount')]
    public function updateCartCount($count)
    {
        $this->orderItemCount = $count;
    }

    private function getPackageModules($restaurant)
    {
        if (!$restaurant || !$restaurant->package) {
            return [];
        }

        $modules = $restaurant->package->modules->pluck('name')->toArray();
        $additionalFeatures = json_decode($restaurant->package->additional_features ?? '[]', true);

        return array_merge($modules, $additionalFeatures);
    }

    public function render()
    {
        $modules = $this->getPackageModules($this->restaurant);

        return view('livewire.shop-desktop-navigation', ['modules' => $modules]);
    }

}
