<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-container>
        <div class="py-12">  
            <h1 class="ui header">Latest Projects</h1>

            <div class="ui stackable relaxed three column grid">
                @foreach ($latest as $project)
                    <a class="column" href="/project/{{ $project->id }}">
                        <div class="ui padded segment">
                            <h2 class="ui header">
                                {{ $project->name }}
                                <span class="sub header">
                                    {{ $project->user->name }}
				    			    @foreach($project->contributor as $contributor)
				    			    	{{ ', '.$contributor->user->name }}
				    			    @endforeach
                                </span>
                            </h2>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="py-12">  
            <h1 class="ui header">Most Liked Projects</h1>

            <div class="ui stackable relaxed three column grid">
                @foreach ($mostLiked as $project)
                    <a class="column" href="/project/{{ $project->id }}">
                        <div class="ui padded segment">
                            <h2 class="ui header">
                                {{ $project->name }}
                                <span class="sub header">
                                    {{ $project->user->name }}
				    			    @foreach($project->contributor as $contributor)
				    			    	{{ ', '.$contributor->user->name }}
				    			    @endforeach
                                </span>
                            </h2>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </x-container>

</x-app-layout>
