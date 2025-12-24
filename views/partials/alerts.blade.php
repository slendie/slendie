@if(count($errors) > 0)
<div class="bg-red-100 border border-red-200 text-gray-800 rounded-lg my-3 px-3 py-2"
     role="alert" tabindex="-1" aria-labelledby="hs-actions-label">
    <div class="flex">
        <div class="shrink-0 mt-0-5">
            <svg class="shrink-0 size-4 mt-1 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="13"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="px-3">
            <div id="hs-actions-label" class="font-normal text-sm text-red-700">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <div class="hidden mt-2 text-sm text-gray-600">
                Notifications may include alerts, sounds and icon badges. These can be configured in Settings.
            </div>
            <div class="hidden mt-4">
                <div class="flex gap-x-3">
                    <button type="button"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                        Don't allow
                    </button>
                    <button type="button"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                        Allow
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(count($form_errors) > 0)
<div class="bg-red-100 border border-red-200 text-gray-800 rounded-lg my-3 px-3 py-2"
     role="alert" tabindex="-1" aria-labelledby="hs-actions-label">
    <div class="flex">
        <div class="shrink-0 mt-0-5">
            <svg class="shrink-0 size-4 mt-1 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="13"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="px-3">
            <div id="hs-actions-label" class="font-normal text-sm text-red-700">
                @foreach($form_errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <div class="hidden mt-2 text-sm text-gray-600">
                Notifications may include alerts, sounds and icon badges. These can be configured in Settings.
            </div>
            <div class="hidden mt-4">
                <div class="flex gap-x-3">
                    <button type="button"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                        Don't allow
                    </button>
                    <button type="button"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                        Allow
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(session('status'))
    <div class="bg-blue-100 border border-blue-200 text-gray-800 rounded-lg my-3 px-3 py-2"
         role="alert" tabindex="-1" aria-labelledby="hs-status-label">
        <div class="flex">
            <div class="shrink-0 mt-0-5">
                <svg class="shrink-0 size-4 mt-1 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="13"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="px-3">
                <p id="hs-status-label" class="font-normal text-sm text-blue-700">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    </div>
@endif
@if(isset($success))
    <div class="bg-green-100 border border-green-200 text-gray-800 rounded-lg my-3 px-3 py-2"
         role="alert" tabindex="-1" aria-labelledby="hs-actions-label">
        <div class="flex">
            <div class="shrink-0 mt-0-5">
                <svg class="shrink-0 size-4 mt-1 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="13"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="px-3">
                <p id="hs-actions-label" class="font-normal text-sm text-green-700">
                    {{ $success }}
                </p>
                <div class="hidden mt-2 text-sm text-gray-600">
                    Notifications may include alerts, sounds and icon badges. These can be configured in
                    Settings.
                </div>
                <div class="hidden mt-4">
                    <div class="flex gap-x-3">
                        <button type="button"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                            Don't allow
                        </button>
                        <button type="button"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                            Allow
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
