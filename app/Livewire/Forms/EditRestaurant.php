<?php

namespace App\Livewire\Forms;

use App\Models\Country;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditRestaurant extends Component
{

    use LivewireAlert;

    public $restaurantName;
    public $fullName;
    public $email;
    public $phone;
    public $address;
    public $country;
    public $facebook;
    public $instagram;
    public $twitter;
    public $countries;
    public $restaurant;
    public $status;

    public function mount()
    {
        $this->countries = Country::all();
        $this->restaurantName = $this->restaurant->name;
        $this->email = $this->restaurant->email;
        $this->phone = $this->restaurant->phone_number;
        $this->address = $this->restaurant->address;
        $this->country = $this->restaurant->country_id;
        $this->facebook = $this->restaurant->facebook_link;
        $this->instagram = $this->restaurant->instagram_link;
        $this->twitter = $this->restaurant->twitter_link;
        $this->status = $this->restaurant->is_active;
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantName' => 'required',
            'email' => 'required',
        ]);

        $this->restaurant->name = $this->restaurantName;
        $this->restaurant->address = $this->address;
        $this->restaurant->email = $this->email;
        $this->restaurant->phone_number = $this->phone;
        $this->restaurant->country_id = $this->country;
        $this->restaurant->facebook_link = $this->facebook;
        $this->restaurant->instagram_link = $this->instagram;
        $this->restaurant->twitter_link = $this->twitter;

        $this->restaurant->is_active = (bool)$this->status;
        $this->restaurant->save();

        $this->dispatch('hideEditStaff');

        $this->alert('success', __('messages.restaurantUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-restaurant');
    }

}
