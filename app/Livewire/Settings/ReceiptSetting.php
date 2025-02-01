<?php

namespace App\Livewire\Settings;

use App\Models\ReceiptSetting as ModelsReceiptSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ReceiptSetting extends Component
{
    use LivewireAlert;
    public $settings;
    public bool $customerName;
    public bool $customerAddress;
    public bool $tableNumber;
    public bool $paymentQrCode;
    public bool $waiter;
    public bool $totalGuest;
    public bool $restaurantLogo;
    public $receiptSetting;

    public function mount()
    {
        $this->receiptSetting = restaurant()->receiptSetting;
        $this->customerName = $this->receiptSetting->show_customer_name == '1' ? true : false;
        $this->customerAddress = $this->receiptSetting->show_customer_address == '1' ? true : false;
        $this->tableNumber = $this->receiptSetting->show_table_number == '1' ? true : false;
        $this->paymentQrCode = $this->receiptSetting->show_payment_qr_code == '1' ? true : false;
        $this->waiter = $this->receiptSetting->show_waiter == '1' ? true : false;
        $this->totalGuest = $this->receiptSetting->show_total_guest == '1' ? true : false;
        $this->restaurantLogo = $this->receiptSetting->show_restaurant_logo == '1' ? true : false;
    }

    public function submitForm()
    {
        $this->receiptSetting->update([
            'show_customer_name' => $this->customerName,
            'show_customer_address' => $this->customerAddress,
            'show_table_number' => $this->tableNumber,
            'show_payment_qr_code' => $this->paymentQrCode,
            'show_waiter' => $this->waiter,
            'show_total_guest' => $this->totalGuest,
            'show_restaurant_logo' => $this->restaurantLogo,
        ]);

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
        return view('livewire.settings.receipt-setting');
    }
}
