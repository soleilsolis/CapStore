<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Contributor;
use App\Models\User;
use App\Models\ProgrammingLanguage;
use App\Models\Like;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ErrorMessages;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Faker\Generator as Faker;

use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request, ErrorMessages $errorMessages)
    {
        $validator = Validator::make($request->all(),[
            'from' => 'required_with:to',
            'to' => 'required_with:from',
        ]);
        
        if($validator->fails())
        {
            return $errorMessages->errors($validator->errors());
        } 

        if(Carbon::parse($request->from)->gt($request->to))
        {
            return $errorMessages->customAlert('The "To" date is greater than the "From" date ',0,'error');

        }
        //if($request)

        return $errorMessages->redirect("/projects?page=1&name={$request->name}&description={$request->description}&to={$request->to}&from={$request->from}");
    }

    public function index(Project $project, Request $request)
    {
        if(!$request->page)
        {
            return redirect('/projects?page=1');
        }

        $skip = 0;

        $projects = new Project;

        if($request->page > 1)
        {
            $request->page--;
            $skip = 10;
            $skip * $request->page;
        }
        $s_to = $request->from;
        $s_from = $request->to;

        if(!$request->from || !$request->to)
        {
            $request->from = '1900-01-01';
            $request->to = Carbon::now()->isoFormat('YYYY-MM-DD');
        }

        /*if(!isset($projects[0]))
        {
            abort(404);
        }*/
        
        return view('projects',[
            'projects' => $projects->where('name', 'like', "%{$request->name}%")
                ->where('description', 'like', "%{$request->description}%")
                ->where(DB::raw('date(created_at)'), '>=', "{$request->from}")
                ->where(DB::raw('date(created_at)'), '<=', "{$request->to}")
                ->skip($skip)->take(10)->get(),
            'count' => Project::where('name', 'like', "%{$request->name}%")
                ->where('description', 'like', "%{$request->description}%")
                ->where(DB::raw('date(created_at)'), '>=', "{$request->from}")
                ->where(DB::raw('date(created_at)'), '<=', "{$request->to}")
                ->skip($skip)->take(10)->count()/10,
            'page' => $request->page,
            's_name' => $request->name ?? null,
            's_description' => $request->description ?? null,
            's_to' => $s_to,
            's_from' => $s_from 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create',[
            'user' => new User,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ErrorMessages $errorMessages, Request $request, Faker $faker)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'file' => 'required|mimes:pdf|max:52428800',
        ]);
        
        if($validator->fails())
        {
            return $errorMessages->errors($validator->errors());
        } 

        $name = $faker->regexify('[A-Za-z0-9]{20}').'.'.$request->file->getClientOriginalExtension();
        $directory = 'storage/files/';

        $project = Project::create([
            'user_id' => Auth::id(),
            'name'=> htmlspecialchars($request->name),
            'description'=> htmlspecialchars($request->description),
            'programming_languages'=> json_encode([]),
            'document_path' => $directory.$name
        ]);

        if($request->contributors)
        {
            foreach($request->contributors as $contributor_id)
            {
                $contributor = Contributor::create([
                    'user_id' => $contributor_id,
                    'project_id' => $project->id
                ]);
            }
        }
        
        $request->file->move($directory, $name); 

        return $errorMessages->redirect("/project/{$project->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Project $project)
    {
        return view('project.show',[
            'project' =>  $project->find($request->id),
            'user' => new User,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Project $project)
    {
        $user = User::find(Auth::id());
        $project = $project->find($request->id);

        if($user->type == 'student')
        {
            if($user->id != $project->user->id)
            {
                return abort(403);
            }
        }
        
        return view('project.edit',[
            'project' => $project,
            'user' => new User,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ErrorMessages $errorMessages, Faker $faker)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'file' => 'mimes:pdf|max:52428800',
        ]);
        
        if($validator->fails())
        {
            return $errorMessages->errors($validator->errors());
        } 

        $project = Project::find($request->id);

        $project->name = htmlspecialchars($request->name);
        $project->description = htmlspecialchars($request->description);
        $project->programming_languages = json_encode([]);

        
        if($request->hasFile('file'))
        {    
            $name = $faker->regexify('[A-Za-z0-9]{20}').'.'.$request->file->getClientOriginalExtension();
            $directory = 'storage/files/';

            $project->document_path= $directory.$name;
            $request->file->move($directory, $name); 
        }

        $contributor = Contributor::where('project_id','=',$project->id)->delete();

        if($request->contributors)
        {
            foreach($request->contributors as $contributor_id)
            {
                Contributor::create([
                    'user_id' => $contributor_id,
                    'project_id' => $project->id
                ]);
            }
        }

        $project->save();

        return $errorMessages->redirect("/project/{$project->id}");

    }

    public function like(Request $request, ErrorMessages $errorMessages)
    {
        $like = Like::where([
            ['user_id','=',Auth::id()],
            ['project_id','=',$request->id]
        ])->first();

        if($like)
        {
            $like->delete();
            $message = "Removed like from project";
        }
        else
        {
            Like::create([
                'user_id' => Auth::id(),
                'project_id' => $request->id
            ]);
            $message = "Project Liked";
        }

        return $errorMessages->data([
            'like'=> Like::where('project_id','=',$request->id)->count(),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(ErrorMessages $errorMessages, Request $request)
    {
        $project = Project::find($request->id);
        $project->delete();
        return $errorMessages->redirect('/projects');
    }
}
