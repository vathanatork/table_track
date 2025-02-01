<?php

namespace App\Livewire\Settings;

use App\Models\PaymentGatewayCredential;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PaymentSettings extends Component
{

    use LivewireAlert;

    public $razorpaySecret;
    public $razorpayKey;
    public $razorpayStatus;
    public $isRazorpayEnabled;
    public $isStripeEnabled;
    public $paymentGateway;
    public $stripeSecret;
    public $activePaymentSetting = 'razorpay';
    public $stripeKey;
    public $stripeStatus;
    public bool $enableForDineIn;
    public bool $enableForDelivery;
    public bool $enableForPickup;

    public function mount()
    {
        $this->paymentGateway = PaymentGatewayCredential::first();
        $this->setCredentials();
    }

    public function activeSetting($tab)
    {
        $this->activePaymentSetting = $tab;
        $this->setCredentials();
    }

    private function setCredentials()
    {
        $this->razorpayKey = $this->paymentGateway->razorpay_key;
        $this->razorpaySecret = $this->paymentGateway->razorpay_secret;
        $this->razorpayStatus = (bool) $this->paymentGateway->razorpay_status;

        $this->stripeKey = $this->paymentGateway->stripe_key;
        $this->stripeSecret = $this->paymentGateway->stripe_secret;
        $this->stripeStatus = (bool) $this->paymentGateway->stripe_status;

        $this->isRazorpayEnabled = $this->paymentGateway->razorpay_status;
        $this->isStripeEnabled = $this->paymentGateway->stripe_status;

        $this->enableForDineIn = $this->paymentGateway->is_dine_in_payment_enabled;
        $this->enableForDelivery = $this->paymentGateway->is_delivery_payment_enabled;
        $this->enableForPickup = $this->paymentGateway->is_pickup_payment_enabled;
    }


    public function submitFormServiceSpecific()
    {
        $this->paymentGateway->update([
            'is_dine_in_payment_enabled' => $this->enableForDineIn,
            'is_delivery_payment_enabled' => $this->enableForDelivery,
            'is_pickup_payment_enabled' => $this->enableForPickup,
        ]);
        $this->updatePaymentStatus();
        $this->alertSuccess();
    }

    public function submitFormRazorpay()
    {
        $this->validate([
            'razorpaySecret' => 'required_if:razorpayStatus,true',
            'razorpayKey' => 'required_if:razorpayStatus,true',
        ]);

        if ($this->saveRazorpaySettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }
    }

    public function submitFormStripe()
    {
        $this->validate([
            'stripeSecret' => 'required_if:stripeStatus,true',
            'stripeKey' => 'required_if:stripeStatus,true',
        ]);

        if ($this->saveStripeSettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }
    }


    private function saveRazorpaySettings()
    {
        try {
            $response = Http::withBasicAuth($this->razorpayKey, $this->razorpaySecret)
                ->get('https://api.razorpay.com/v1/contacts');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'razorpay_key' => $this->razorpayKey,
                    'razorpay_secret' => $this->razorpaySecret,
                    'razorpay_status' => $this->razorpayStatus,
                ]);
                return 0;
            }

            $this->addError('razorpayKey', 'Invalid Razorpay key or secret.');
        } catch (\Exception $e) {
            $this->addError('razorpayKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    private function saveStripeSettings()
    {
        try {
            $response = Http::withToken($this->stripeSecret)
                ->get('https://api.stripe.com/v1/customers');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'stripe_key' => $this->stripeKey,
                    'stripe_secret' => $this->stripeSecret,
                    'stripe_status' => $this->stripeStatus,
                ]);
                return 0;
            }

            $this->addError('stripeKey', 'Invalid Stripe key or secret.');
        } catch (\Exception $e) {
            $this->addError('stripeKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    public function updatePaymentStatus()
    {
        $this->setCredentials();
        $this->dispatch('settingsUpdated');
        session()->forget('paymentGateway');
    }

    public function alertSuccess()
    {
        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close'),
        ]);
    }

    public function render()
    {
        return view('livewire.settings.payment-settings');
    }
}
