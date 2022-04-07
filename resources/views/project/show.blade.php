@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Project #'.$project->id) }}
            
        </h2>
    </x-slot>

    <x-container>
        <h1 class="font-bold pt-5 text-3xl">
            <form action="/project/edit/{{ $project->id }}" method="GET">
                {{ $project->name }} 
                @if($project->user_id == Auth::id() || User::find(Auth::id()) != 'student')
                    <x-jet-button>Edit</x-jet-button>
                @endif
            </form>
  
            <p class="font-normal pt-1 text-base">
                By: 
                <a href="/user/{{ $project->user->id }}">{{ $project->user->name }}</a>
				@foreach($project->contributor as $contributor)
                    <a href="/user/{{ $contributor->user->id }}">
                        {{ ', '.$contributor->user->name }}
                    </a>
				@endforeach
            </p>

        </h1>

        <div class="ui labeled button" tabindex="0">
            <div class="ui tiny red button submit-form likebutton-" data-id="{{ $project->id }}" data-send="/project/like?id={{ $project->id }}">
              <i class="heart icon"></i> Like
            </div>
            <a class="ui basic red left pointing label like">
                {{ $project->like->count() }}
            </a>
          </div>

        <h3 class="font-bold py-3 text-xl">Description</h3>

        <p>
            {{ $project->description }}
        </p>

        <h3 class="font-bold py-3 text-xl">Document Download</h3>

        <p>
            <a href="/{{ $project->document_path }}">Download</a>
        </p>
    </x-container>
</x-app-layout>

