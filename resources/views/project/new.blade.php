<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("New Project") }}
        </h2>
    </x-slot>

    <x-container>
        <x-jet-form-section submit="updatePassword">
            <x-slot name="title">
                {{ __('Basic Information') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Name and description of your project') }}
            </x-slot>
        
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" type="text" class="mt-1 block w-full h-36 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.description" autocomplete="description"></textarea>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </x-slot>
        </x-jet-form-section>

        <x-jet-section-border />

        <x-jet-form-section submit="updatePassword">
            <x-slot name="title">
                {{ __('Contributors') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add your group to this project') }}
            </x-slot>
        
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </x-slot>
        </x-jet-form-section>

        <div class="text-right pt-6">
            <x-jet-button>Create</x-jet-button>
        </div>
    </x-container>
</x-app-layout>
