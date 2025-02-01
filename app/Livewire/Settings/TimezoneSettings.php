<?php

namespace App\Livewire\Settings;

use App\Models\Country;
use App\Models\Currency;
use DateTimeZone;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TimezoneSettings extends Component
{

    use LivewireAlert;

    public $settings;
    public $restaurantCountry;
    public $restaurantTimezone;
    public $restaurantCurrency;
    public $countries;
    public $timezones;
    public $currencies;

    public function mount()
    {
        $this->restaurantCountry = $this->settings->country_id;
        $this->restaurantTimezone = $this->settings->timezone;
        $this->restaurantCurrency = $this->settings->currency_id;
        $this->countries = Country::all();
        $this->currencies = Currency::all();
        $this->timezones = DateTimeZone::listIdentifiers();
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantCountry' => 'required',
            'restaurantCurrency' => 'required',
            'restaurantTimezone' => 'required'
        ]);

        $this->settings->timezone = $this->restaurantTimezone;
        $this->settings->country_id = $this->restaurantCountry;
        $this->settings->currency_id = $this->restaurantCurrency;
        $this->settings->save();

        $this->dispatch('settingsUpdated');

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    public function render()
    {
        return view('livewire.settings.timezone-settings');
    }

}
