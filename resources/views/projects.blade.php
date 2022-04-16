<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Projects') }}
		</h2>
	</x-slot>

	<x-container>
		<div class="ui secondary menu">
			<div class="fitted item">
				<form  action="/project/create" method="GET">
					<x-jet-button>+ New</x-jet-button>
				</form>
			</div>
			<div class="right menu">
				@if(\App\Models\User::find(Auth::id())->type != 'student')
					<div class="item">											
						<a class="ui black button" href="/csv" target="_blank">
							<i class="print icon"></i>
							Download File Record
						</a>					
					</div>
				@endif

				@if($s_name != null || $s_description != null || $s_to != null || $s_from != null) 
					<div class="item">											
						<a class="ui black button" href="/projects">
							Reset Search
						</a>					
					</div>
				@endif
				<div class="item">											
					<button class="ui black icon button" onclick="$('.modal').modal('show')">
						<i class="search icon"></i>
					</button>					
				</div>
			</div>
		</div>

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

			<tfoot>
				<tr>
					<td class="text-sm font-medium text-gray-900 px-6 py-3 text-left rounded-b-lg"></td>
				</tr>
			</tfoot>
		</x-table>
		
		<div class="ui right floated pagination menu">
			@for($i = 1; $i < $count+1; $i++)
				<a class="item " href="/projects?page={{ $i }}&name={{ $s_name }}&description={{ $s_description }}&to={{ $s_to }}&from={{ $s_from }}" >{{ $i }}</a>
			@endfor
		</div>
	</x-container>

	<div class="ui small modal">
		<div class="header">Search</div>
		<div class="content">
			<form id="search" name="search" class="ui form"  method="POST">
				@csrf
				<div class="field">
					<label for="name">Name</label>
					<input id="name" name="name" type="text">
				</div>
				<div class="field">
					<label for="description">Description</label>
					<textarea name="description" id="description"></textarea>
				</div>

				<div class="equal width fields">
					<div class="field">
						<label for="from">From:</label>
						<input id="from" name="from" type="date">
					</div>
					<div class="field">
						<label for="to">To:</label>
						<input id="to" name="to" type="date">
					</div>
				</div>
				
			</form>
		</div>
		<div class="actions">
			<button class="ui black button submit-form" data-form="search" data-send="/project/search">Search</button>
		</div>
	</div>
	<script>
		const link = document.querySelectorAll(".link");

		for (let i = 0; i < link.length; i++) {
			link[i].addEventListener("click", function() {
				location.href = this.dataset.href;
			});
		}
	</script>
</x-app-layout>
