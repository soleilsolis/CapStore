<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingLanguage;
use App\Http\Requests\StoreProgrammingLanguageRequest;
use App\Http\Requests\UpdateProgrammingLanguageRequest;

class ProgrammingLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProgrammingLanguageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgrammingLanguageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function show(ProgrammingLanguage $programmingLanguage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgrammingLanguage $programmingLanguage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgrammingLanguageRequest  $request
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgrammingLanguageRequest $request, ProgrammingLanguage $programmingLanguage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgrammingLanguage $programmingLanguage)
    {
        //
    }
}
