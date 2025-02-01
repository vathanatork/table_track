<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CustomerSiteSettings extends Component
{

    use LivewireAlert;

    public $settings;
    public bool $customerLoginRequired;
    public bool $allowCustomerOrders;
    public bool $allowCustomerDeliveryOrders;
    public bool $allowCustomerPickupOrders;
    public bool $isWaiterRequestEnabled;
    public string $defaultReservationStatus;
    public $facebook;
    public $instagram;
    public $twitter;
    public bool $tableRequired;

    public function mount()
    {
        $this->defaultReservationStatus = $this->settings->default_table_reservation_status;
        $this->customerLoginRequired = $this->settings->customer_login_required;
        $this->allowCustomerOrders = $this->settings->allow_customer_orders;
        $this->allowCustomerDeliveryOrders = $this->settings->allow_customer_delivery_orders;
        $this->allowCustomerPickupOrders = $this->settings->allow_customer_pickup_orders;
        $this->isWaiterRequestEnabled = $this->settings->is_waiter_request_enabled;
        $this->tableRequired = $this->settings->table_required;
        $this->facebook = $this->settings->facebook_link;
        $this->instagram = $this->settings->instagram_link;
        $this->twitter = $this->settings->twitter_link;
    }

    public function submitForm()
    {
        $this->validate([
            'defaultReservationStatus' => 'required|in:Confirmed,Checked_In,Cancelled,No_Show,Pending',
        ]);

        $this->settings->default_table_reservation_status = $this->defaultReservationStatus;
        $this->settings->customer_login_required = $this->customerLoginRequired;
        $this->settings->allow_customer_orders = $this->allowCustomerOrders;
        $this->settings->allow_customer_delivery_orders = $this->allowCustomerDeliveryOrders;
        $this->settings->allow_customer_pickup_orders = $this->allowCustomerPickupOrders;
        $this->settings->is_waiter_request_enabled = $this->isWaiterRequestEnabled;
        $this->settings->table_required = $this->tableRequired;
        $this->settings->facebook_link = $this->facebook;
        $this->settings->instagram_link = $this->instagram;
        $this->settings->twitter_link = $this->twitter;
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
        return view('livewire.settings.customer-site-settings');
    }
}
