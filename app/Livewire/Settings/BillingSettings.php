<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Models\GlobalInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OfflinePlanChange;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BillingSettings extends Component
{
    use WithPagination, LivewireAlert;

    public $currentTab;
    public $activeSetting;
    public $currentPackageName;
    public $currentPackageType;
    public $licenseExpireOn;

    public function mount()
    {
        $this->showTab('planDetails');
        $restaurant = Restaurant::where('id', restaurant()->id)->first();
        $this->currentPackageName = $restaurant->package->package_name;
        $this->currentPackageType = ucfirst($restaurant->package->package_type->value);
        $this->licenseExpireOn = ($restaurant?->license_expire_on) ? $restaurant?->license_expire_on->format('d F, Y') : __('modules.package.lifetime');
        if ($restaurant->package_type) {
            $this->currentPackageType .= ' (' . ucfirst($restaurant->package_type) . ')';
        }

    }

    public function showTab($tab)
    {
        $this->currentTab = $tab;
        $this->activeSetting = $this->currentTab;
    }

    public function downloadFile($id)
    {
        $invoice = GlobalInvoice::findOrFail($id);

        if (!$invoice) {

            $this->alert('error', __('messages.noInvoiceFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

            return;
        }


        $pdf = Pdf::loadView('billing.billing-receipt', ['invoice' => $invoice]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'billing-receipt-' . uniqid() . '.pdf');
    }

    public function render()
    {
        $invoices = GlobalInvoice::where('restaurant_id', restaurant()->id)
            ->orderByDesc('id')
            ->paginate(10);

        $offlinePaymentRequest = OfflinePlanChange::where('restaurant_id', restaurant()->id)->paginate(10);

        return view('livewire.settings.billing-settings', [
            'offlinePaymentRequest' => $offlinePaymentRequest,
            'invoices' => $invoices
        ]);
    }
}
