<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-container>
        <div class="py-12"> 
            <div class="ui stackable two column grid">
                <div class="column">
                    <div class="ui padded segment">
                        <div class="ui large horizontal statistic">
                            <div class="value">
                                {{ $projectCount }}
                            </div>
                            <div class="label">
                              Total Capstones
                            </div>
                        </div>
                        
                    </div>
                    <div class="ui hidden divider"></div>

                        <h2 class="ui header">Logs</h2>
                        <table class="ui unstackable selectable table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th class="right aligned">Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>User</td>
                                    <td class="right aligned">10-11-2020 12:00:00</td>
                                </tr>
                            </tbody>
                        </table>
                   
                </div>
                <div class="column">
                    <canvas id="bar-chart" width="800" height="450"></canvas>
                </div>
                <div class="column">
                
                </div>
            </div>
        </div>
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

<script>
    new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: [
            @foreach($monthly as $m) 
                "{{ $m->date }}",
            @endforeach
        ],
      datasets: [
        {
          label: "Projects per month",
          backgroundColor: "#4183c4",
          data: [
            @foreach($monthly as $m) 
                {{ $m->projects }},
            @endforeach
          ]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Projects per month'
      }
    }
});
</script>
