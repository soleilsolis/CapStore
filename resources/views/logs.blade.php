<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Logs') }}
		</h2>
	</x-slot>

	<x-container>

		<x-table>
			<thead class="border-b">
				<tr class="bg-white">
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-left rounded-t-lg">
						<strong>Username</strong>
					</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-left">
						<strong>Message</strong>
					</th>
					<th scope="col" class="text-sm font-medium text-gray-900 px-6 py-3 text-right rounded-t-lg">
						<strong>Date</strong>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($logs as $log)
					<x-tr-tbody>
						<x-td>{{ $log->user->name }}</x-td>
						<x-td>{{ $log->message }}</x-td>
						<x-td align="right">
							{{ $log->created_at }}
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
	</x-container>
</x-app-layout>
