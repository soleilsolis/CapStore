<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Project #'.$project->id) }}
        </h2>
    </x-slot>

    <x-container>
        <h1 class="font-bold py-5 text-3xl">{{ $project->name }}</h1>
        <h3 class="font-bold py-5 text-xl">Description</h3>

        <p>
            {{ $project->description }}
        </p>
    </x-container>
</x-app-layout>
