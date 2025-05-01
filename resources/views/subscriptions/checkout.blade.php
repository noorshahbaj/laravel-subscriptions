<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('subscriptions.store') }}" id="card-form" method="post">
                        @csrf

                        <input type="hidden" name="plan" id="plan" value="{{ request('plan') }}">

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name Of Card')" />
                            <x-text-input id="card-holder-name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Card Details -->
                        <div class="mt-4">
                            <x-input-label for="card_details" :value="__('Card Details')" />
                            <div id="card-element"></div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button id="card-button" class="ms-4"
                                data-secret="{{ $intent->client_secret }}">
                                {{ __('Pay') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");

        const elements = stripe.elements();

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                lineHeight: '24px',
                padding: '10px',
                '::placeholder': {
                    color: '#aab7c4'
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const cardElement = elements.create('card', {
            style: style
        });

        cardElement.mount('#card-element');


        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();

            cardButton.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                cardButton.disabled = false;
            } else {
                const form = document.getElementById('card-form');

                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'token');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);
                form.submit();
            }
        })
    </script>
</x-app-layout>
