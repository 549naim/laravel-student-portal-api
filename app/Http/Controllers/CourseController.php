<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function all_level(){
      $all_level = Level::all();
      
      return response ([
        'message' => 'All Levels',
        'level' =>$all_level, 
        'success' => true,
    ]);

    }
    public function all_courses(){
      $all_courses = Courses::all();
      return response ([
        'message' => 'All Courses',
        'courses'=>$all_courses,
        'success' => true,
    ]);

    }

    public function post_courses(Request $request){
        $request->validate([      
            'name'=>'required',   
            'level_id'=>'required',   
        ]);
        $data = new Courses();
        $data->name = $request->name;
        $data->level_id = $request->level_id;
        $data->save();
        return response ([
            'message' => ' Courses Added Succesfully',
            'success' => true,
        ]);
    }
    public function post_level(Request $request){
        $request->validate([      
            'name'=>'required',    
        ]);
        $data = new Level();
        $data->name = $request->name;
        $data->save();
        return response ([
            'message' => ' Level Added Succesfully',
            'success' => true,
        ]);
    }

    public function edit_level(Request $request ,$id ){
        $data = Level::find($id);
        $data->name = $request->name;
        $data->save();
        return response ([
            'message' => ' Level Edited Succesfully',
            'success' => true,
        ]);
      
    }

    public function show_level($id){
        $data = Level::find($id);
        return response ([
            'message' => ' Level Edited Succesfully',
            'data'=>$data,
            'success' => true,
        ]);
    }
}
