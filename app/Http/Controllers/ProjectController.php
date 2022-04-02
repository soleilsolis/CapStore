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
use Faker\Generator as Faker;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index(Project $project, Request $request)
    {
        if(!$request->page)
        {
            return redirect('/projects?page=1');
        }

        $skip = 0;

        if($request->page > 1)
        {
            $request->page--;
            $skip = 10;
            $skip * $request->page;
        }
        
        return view('projects',[
            'projects' => Project::skip($skip)->take(10)->get(),
            'count' => Project::count()
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
            'programmingLanguages' => new ProgrammingLanguage,
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
            'programming_languages' => 'required',
        ],[
            'programming_languages.required' => 'Please choose at least one programming language'
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
            'programming_languages'=> json_encode($request->programming_languages),
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
            'programmingLanguages' => new ProgrammingLanguage,
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
            'programmingLanguages' => new ProgrammingLanguage,
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
            'programming_languages' => 'required',
        ],[
            'programming_languages.required' => 'Please choose at least one programming language'
        ]);
        
        if($validator->fails())
        {
            return $errorMessages->errors($validator->errors());
        } 

        $project = Project::find($request->id);

        $project->name = htmlspecialchars($request->name);
        $project->description = htmlspecialchars($request->description);
        $project->programming_languages = json_encode($request->programming_languages);

        
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
