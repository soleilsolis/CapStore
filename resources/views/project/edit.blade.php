<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ __("$project->name") }}
        </h2>
    </x-slot>

    <x-container>
        <x-jet-form-section submit="projectUpdate">
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
                    <x-jet-input id="name" name="name" :value="$project->name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" name="description" type="text" 
                        class="mt-1 block w-full h-36 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                        wire:model.defer="state.description" 
                        autocomplete="description">{{ $project->description }}</textarea>
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
                    <div class="ui form">
                        <div class="field">
                            <label for="" style="font-weight: normal">Written In</label>
                            <div class="ui dropdown selection multiple" tabindex="0">
                                <select name="programming_languages[]" id="programming_languages" multiple="" class="noselection">
                                    @foreach ($programmingLanguages->all() as $programmingLanguage)
                                        <option value="{{ $programmingLanguage->id }}">
                                            {{ $programmingLanguage->name }}
                                        </option>
                                    @endforeach
                                    
                                </select>
                                <i class="dropdown icon"></i>
                                <div class="text"></div>
                                <div class="menu" tabindex="-1">
                                    @foreach ($programmingLanguages->all() as $programmingLanguage)
                                        <div class="item programmingLanguage" data-value="{{ $programmingLanguage->id }}" data-text="{{ $programmingLanguage->name }}">                                            
                                            {{ $programmingLanguage->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-jet-input-error for="programming_languages" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="file" value="{{ __('File') }}" />
                    <x-jet-input id="file" name="file" type="file" class="mt-1 block w-full" wire:model.defer="state.file" autocomplete="file" />
                    <x-jet-label value="{{ __("Current File:") }}" />
                    <x-jet-input-error for="file" class="mt-2" />
                </div>
            </x-slot>
        </x-jet-form-section>

        <div class="text-right pt-6">
            <x-jet-button class="bg-red-800 delete-project">Delete</x-jet-button>
            <x-jet-button class="submit-form" data-form="projectUpdate" data-send="/project/update/{{ $project->id }}">Update</x-jet-button>
        </div>
    </x-container>

    <div class="ui mini modal" id="delete">
        <div class="header">Delete Project</div>
        <div class="content">
            THIS ACTION CANNOT BE UNDONE!
        </div>
        <div class="actions">
            <x-jet-button class="submit-form bg-red-800 mb-2" data-form="projectUpdate" data-send="/project/delete/{{ $project->id }}">Delete</x-jet-button>

        </div>
    </div>

    <script>
        $('.dropdown').dropdown();
        $('.delete-project').click(function(){
            $('#delete').modal('show');
        });
        
    </script>

    @foreach($project->contributor as $contributor)
    
        <script>
            $(".contributor[data-value={{ $contributor->user->id }}]").click();
        </script>
    @endforeach

    @foreach(json_decode($project->programming_languages ?? []) as $programming_language)
    
    <script>
        $(".programmingLanguage[data-value={{ $programming_language }}]").click();
    </script>
    @endforeach
</x-app-layout>

