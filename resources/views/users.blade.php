<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Projects') }}
		</h2>
	</x-slot>


	<x-container>
		<div class="ui secondary menu">
			<div class="fitted item">
				<form  action="/user/create" method="GET">
					<x-jet-button>+ New</x-jet-button>
				</form>
			</div>
			<div class="right menu">
				<div class="item">
					<form action="/user/search" method="POST">
						@csrf
						<div class="ui action input">
							<input name="search" id="search" type="text" placeholder="Search...">
							<button class="ui button">Search</button>
						</div>
					</form>
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
						<strong>Display Name</strong>
					</th>
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-right rounded-t-lg">
						<strong>Type</strong>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($users as $user)
					<x-tr-tbody href="/user/{{ $user->id }}">
						<x-td>{{ $user->id }}</x-td>
						<x-td>{{ $user->name }}</x-td>
						<x-td align="right">
							{{ $user->type }}
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