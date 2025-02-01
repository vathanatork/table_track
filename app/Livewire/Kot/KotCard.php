<?php

namespace App\Livewire\Kot;

use App\Models\Kot;
use Livewire\Component;

class KotCard extends Component
{
    public $kot;
    public $confirmDeleteKotModal = false;

    public function changeKotStatus($status)
    {
        Kot::where('id', $this->kot->id)->update([
            'status' => $status
        ]);

        $this->dispatch('refreshKots');
    }

    public function deleteKot($id)
    {
        Kot::destroy($id);
        $this->confirmDeleteKotModal = false;
        
        $this->dispatch('refreshKots');
    }

    public function render()
    {
        return view('livewire.kot.kot-card');
    }

}
