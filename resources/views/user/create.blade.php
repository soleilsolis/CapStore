<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("New Project") }}
        </h2>
    </x-slot>

    <x-container>
        <x-jet-form-section submit="userCreate">
            <x-slot name="title">
                {{ __('Information') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Name, description and other information of your project') }}
            </x-slot>
        
            <x-slot name="form">
                @csrf
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Display Name') }}" />
                    <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                    <x-jet-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
                    <x-jet-input-error for="first_name" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" />
                    <x-jet-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" wire:model.defer="state.middle_name" autocomplete="middle_name" />
                    <x-jet-input-error for="middle_name" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
                    <x-jet-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
        
                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" name="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
                
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="password" value="{{ __('New Password') }}" />
                    <x-jet-input id="password" name="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>
        </x-jet-form-section>

        <div class="text-right pt-6">
            <x-jet-button class="submit-form" data-form="userCreate" data-send="/user/store">Create</x-jet-button>
        </div>
    </x-container>

    <script>
        $('.dropdown').dropdown();
    </script>
</x-app-layout>

