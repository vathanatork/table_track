<?php

namespace App\Livewire\Settings;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class GeneralSettings extends Component
{

    use LivewireAlert;

    public $settings;
    public $restaurantName;
    public $restaurantAddress;
    public $restaurantPhoneNumber;
    public $restaurantEmailAddress;

    public function mount()
    {
        $this->restaurantName = $this->settings->name;
        $this->restaurantAddress = $this->settings->address;
        $this->restaurantEmailAddress = $this->settings->email;
        $this->restaurantPhoneNumber = $this->settings->phone_number;
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantName' => 'required',
            'restaurantPhoneNumber' => 'required',
            'restaurantEmailAddress' => 'required|email',
        ]);

        $this->settings->email = $this->restaurantEmailAddress;
        $this->settings->name = $this->restaurantName;
        $this->settings->phone_number = $this->restaurantPhoneNumber;
        $this->settings->address = $this->restaurantAddress;
        $this->settings->save();

        session()->forget(['restaurant', 'timezone', 'currency']);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    public function render()
    {
        return view('livewire.settings.general-settings');
    }

}
