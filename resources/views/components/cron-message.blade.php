<div>
     {{-- This message hides instantly the cron job is runned. It then do not show for next 2 days   --}}
     @if (global_setting()->hide_cron_job == 0 || now()->diffInHours(global_setting()->last_cron_run) > 48)
        @include('superadmin-settings.cron-message')
    @endif

</div>