<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    // CREATE PROJECT API
    public function crateProject(Request $request)
    {
        // validation
        $request->validate([

            'name' => 'required',
            'description' => 'required',
            'duration' => 'required',
        ]);

        // student_id + create data
        $student_id = auth()->user()->id;

        $project = new Project();

        $project->name = $request->name;
        $project->student_id = $student_id;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Project has been created",
        ]);

    }

    // LIST PROJECT API
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $projects = Project::where('student_id', $student_id)->get();

        return response()->json([
            "status" => 1,
            "message" => "List of projects",
            "data" => $projects,
        ]);
    }

    // SINGLE PROJECT API
    public function singleProject($id)
    {
        // check project id
        $student_id = auth()->user()->id;
        if (Project::where(['id' => $id,
            'student_id' => $student_id]
        )->exists()) {

            $project = Project::where([
                'id' => $id,
                'student_id' => $student_id,
            ])->get();

            return response()->json([
                "status" => 1,
                "message" => "Single project",
                "data" => $project,
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Project not found",

            ], 404);
        }

    }

    // DELETE PROJECT API
    public function deleteProject($id)
    {
        // check student id

        $student_id = auth()->user()->id;


        if(Project::where([
            'id' => $id,
            'student_id' => $student_id,
        ])->exists()){
            $project = Project::where([
                'id' => $id,
                'student_id' => $student_id,
            ])->delete();

            // send response
            return response()->json([
                "status" => 1,
                "message" => "Project have been deleted"
            ]);

        }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not found",

            ], 404);
        }
    }
}
