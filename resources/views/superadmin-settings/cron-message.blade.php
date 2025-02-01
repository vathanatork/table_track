<x-alert type="info">
    <div class="flex flex-col justify-between">
    <h6>Please set the following cron command on your server (Ignore if already done)</h6>
    <code>* * * * * (Every Minute)</code>
    <br>
    <br>
    <div class="flex gap-2 items-center">
        @php
            try {
                $phpPath = PHP_BINDIR.'/php';
            } catch (\Throwable $th) {
                $phpPath = 'php';
            }
            echo '<code  id="cron-command" class="flex items-center gap-2"> ' . $phpPath . ' ' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
        @endphp

        <button type="button" id="copy-cron-command" class="btn text-gray-900 dark:text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
        </button>
    </div>

    <div class="mt-3"><strong>Note:</strong>

        <ins>{{$phpPath}}</ins>
        in the above command is the path of PHP on your server. To ensure it works correctly, please enter the correct PHP path for your server and provide the path to your script. If you're unsure how to set up a cron job, you may want to consult with your server administrator or hosting provider.
    </div>
    </div>
</x-alert>

<script>
    document.getElementById('copy-cron-command').addEventListener('click', async function() {
        const command = document.getElementById('cron-command').textContent;
        try {
            await navigator.clipboard.writeText(command);
            // Optional: Add visual feedback
            this.innerHTML = `Copied`;
            setTimeout(() => {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                    </svg>`;
            }, 2000);
        } catch (err) {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = command;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                textArea.remove();
            } catch (err) {
                console.error('Failed to copy text:', err);
            }
        }
    });
</script>
