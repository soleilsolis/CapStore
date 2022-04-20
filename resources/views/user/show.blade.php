
@php
use Illuminate\Support\Facades\Auth;
use App\Models\User;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("$user->name") }}
        </h2>
    </x-slot>

    <x-container>
       <div class="ui stackable grid">
            <div class="five wide column">
                 <img x-show="! photoPreview" src="@if(!$user->profile_photo_path ) https://ui-avatars.com/api/?name=d&color=7F9CF5&background=EBF4FF @else /storage/{{ $user->profile_photo_path }} @endif" alt="{{ $user->name }}" class="rounded-full h-60 w-60 object-cover">
                 <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                     {{ __("$user->name") }}
                 </h2>
                 <p class="text-base text-gray-400 leading-tight">
                     {{ $user->first_name }} {{ $user->last_name }}
                 </p>

                 <p class="text-base text-gray-800 leading-tight">
                     {{ $user->description }} 
                 </p>

                 <form action="/user/edit/{{ $user->id }}" method="GET">
                    @if($user->id == Auth::id() || User::find(Auth::id()) != 'student')
                        <x-jet-button>Edit</x-jet-button>
                    @endif
                </form>
            </div>
            <div class="eleven wide column">
                 <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    Projects
                 </h2>
                <div class="ui stackable three column grid">
                    @foreach($user->project as $project)
                        <a class="column" href="/project/{{ $project->id }}">
                            <div class="ui segment">
                                <div class="ui header">
                                    {{ $project->name }}
                                    <div class="sub header">Created {{ $project->created_at }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @foreach($user->contributor as $contributor)
                        @if($contributor->project)
                            <a class="column" href="/project/{{ $contributor->project->id }}">
                                <div class="ui segment">
                                    <div class="ui header">
                                        {{ $contributor->project->name }}
                                        <div class="sub header">Created {{ $contributor->project->created_at }}</div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
       </div>
    </x-container>

    <script>
        $('.dropdown').dropdown();
    </script>
</x-app-layout>