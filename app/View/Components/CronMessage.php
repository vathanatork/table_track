<?php

namespace App\View\Components;

use App\Models\GlobalSetting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CronMessage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private $modal = false)
    {
        $this->modal = $modal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $globalSetting = GlobalSetting::select(['id', 'hide_cron_job', 'last_cron_run'])->first();

        $modal = $this->modal;

        return view('components.cron-message', compact('globalSetting', 'modal'));
    }
}
