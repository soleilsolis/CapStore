<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("New Project") }}
        </h2>
    </x-slot>

    <x-container>
        <x-jet-form-section submit="projectCreate">
            <x-slot name="title">
                {{ __('Information') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Name, description and other information of your project') }}
            </x-slot>
        
            <x-slot name="form">
                @csrf
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" name="description" type="text" class="mt-1 block w-full h-36 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.description" autocomplete="description"></textarea>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="ui form">
                        <div class="field">
                            <label for="" style="font-weight: normal">Contributors</label>
                            <div class="ui dropdown selection multiple" tabindex="0">
                                <select name="contributors[]" id="contributors" multiple="" class="noselection">
                                    @foreach($user->where('id','!=', Illuminate\Support\Facades\Auth::id())->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                
                                <i class="dropdown icon"></i>
                                <div class="text"></div>
                                <div class="menu" tabindex="-1">
                                    @foreach($user->where('id','!=', Illuminate\Support\Facades\Auth::id())->get() as $user)
                                        <div class="item contributor" data-value="{{ $user->id }}" data-text="{{ $user->name }}">{{ $user->name }}</div>

                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <x-jet-input-error for="contributors" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="file" value="{{ __('File') }}" />
                    <x-jet-input id="file" name="file" type="file" class="mt-1 block w-full" wire:model.defer="state.file" autocomplete="file" />
                    <x-jet-input-error for="file" class="mt-2" />
                </div>
            </x-slot>
        </x-jet-form-section>

        <div class="text-right pt-6">
            <x-jet-button class="submit-form" data-form="projectCreate" data-send="/project/store">Submit</x-jet-button>
        </div>
    </x-container>

    <script>
        $('.dropdown').dropdown();
    </script>
</x-app-layout>

