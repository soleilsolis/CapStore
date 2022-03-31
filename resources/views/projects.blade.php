<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Projects') }}
		</h2>
	</x-slot>


	<x-container>
		<form class="pt-6 pb-5" action="/project/create" method="GET">
			<x-jet-button>+ New</x-jet-button>
		</form>

		<x-table>
			<thead class="border-b">
				<tr class="bg-white">
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-left rounded-t-lg">
						<strong>#</strong>
					</th>
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-left">
						<strong>Project Name</strong>
					</th>
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-left">
						<strong>Authors</strong>
					</th>
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-right rounded-t-lg">
						<strong>Created</strong>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($projects as $project)
					<x-tr-tbody href="/project/{{ $project->id }}">
						<x-td>{{ $project->id }}</x-td>
						<x-td>{{ $project->name }}</x-td>
						<x-td>
							{{ $project->user->name }}
							@foreach($project->contributor as $contributor)
								{{ ', '.$contributor->user->name }}
							@endforeach
						</x-td>
						<x-td align="right">
							{{ $project->created_at }}
						</x-td>
					</x-tr-tbody>
				@endforeach
			</tbody>
		</x-table>
	</x-container>
	<script>
		const link = document.querySelectorAll(".link");

		for (let i = 0; i < link.length; i++) {
			link[i].addEventListener("click", function() {
				location.href = this.dataset.href;
			});
		}
	</script>
</x-app-layout>
