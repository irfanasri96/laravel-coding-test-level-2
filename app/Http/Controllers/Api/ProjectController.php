<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageIndex = 0;
        $pageSize = 3;
        $sortBy = 'name';
        $sortDirection = 'asc';

        $query = Project::query();

        if($request->has('q')) {
            $query->where('name', 'LIKE', '%' . $request['q'] . '%');
        }

        if($request->has('pageIndex')) {
            $pageIndex = $request['pageIndex'];
        }

        if($request->has('pageSize')) {
            $pageSize = $request['pageSize'];
        }

        if($request->has('sortBy')) {
            $sortBy = $request['sortBy'];
        }

        if($request->has('sortDirection')) {
            $sortDirection = $request['sortDirection'];
        }

        $projects = $query->orderBy($sortBy, $sortDirection)
                          ->paginate($pageSize, ['*'], 'page', $pageIndex);

        return $this->sendResponse(new ProjectCollection($projects), 'Projects retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());

        return $this->sendResponse(new ProjectResource($project), 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return $this->sendResponse(new ProjectResource($project), 'Project retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return $this->sendResponse(new ProjectResource($project), 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return $this->sendResponse([], 'Project deleted successfully.');
    }
}
