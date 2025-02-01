<?php

namespace App\Livewire\Settings;

use App\Helper\Files;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ThemeSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $settings;
    public $themeColor;
    public $themeColorRgb;
    public $photo;

    public function mount()
    {
        $this->themeColor = $this->settings->theme_hex;
        $this->themeColorRgb = $this->settings->theme_rgb;
    }

    public function submitForm()
    {
        $this->validate(['themeColor' => 'required']);

        $this->themeColorRgb = $this->hex2rgba($this->themeColor);

        $this->settings->theme_hex = $this->themeColor;
        $this->settings->theme_rgb = $this->themeColorRgb;
        $this->settings->save();

        if ($this->photo) {
            $this->settings->logo = Files::uploadLocalOrS3($this->photo, 'logo');
        }

        $this->settings->save();

        session()->forget(['restaurant', 'timezone', 'currency']);

        $this->redirect(route('settings.index'), navigate: true);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function hex2rgba($color)
    {

        list($r, $g, $b) = sscanf($color, '#%02x%02x%02x');

        return $r . ', ' . $g . ', ' . $b;
    }

    public function deleteLogo()
    {
        if (is_null($this->settings->logo)) {
            return;
        }

        Files::deleteFile($this->settings->logo, 'logo');

        $this->settings->forceFill([
            'logo' => null,
        ])->save();

        session()->forget(['restaurant']);

        $this->redirect(route('settings.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.settings.theme-settings');
    }

}
