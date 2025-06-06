<x-account-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            {{ 'Subscriptions resume' }}
            <form action="{{ route('account.subscriptions.resume') }}" method="POST">
                @csrf
                <x-primary-button type="submit" class="ms-3">
                    {{ __('Resume') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-account-layout>
