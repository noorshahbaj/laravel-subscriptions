<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 md:space-y-0 md:grid grid-cols-8 gap-6">
        <div class="col-span-2 space-y-3">
            <ul class="mb-10">
                <li><x-nav-link href="{{ route('account') }}" :active="request()->routeIs('account')">Account</x-nav-link></li>
            </ul>

            <ul>
                <li><x-nav-link href="{{ route('account.subscriptions') }}" :active="request()->routeIs('account.subscriptions')">Subscriptions</x-nav-link>
                </li>
            </ul>

            @if (auth()->user()->subscription() && !auth()->user()->subscription('default')->canceled())
                <ul>
                    <li><x-nav-link href="{{ route('account.subscriptions.cancel') }}" :active="request()->routeIs('account.subscriptions.cancel')">Subscription
                            Cancel</x-nav-link>
                    </li>
                </ul>
            @endif

            @if (auth()->user()->subscription() && auth()->user()->subscription('default')->canceled())
                <ul>
                    <li><x-nav-link href="{{ route('account.subscriptions.resume') }}" :active="request()->routeIs('account.subscriptions.cancel')">Subscription
                            Resume</x-nav-link>
                    </li>
                </ul>
            @endif

        </div>
        <div class="col-span-6">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
