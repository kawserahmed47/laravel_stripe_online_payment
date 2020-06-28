<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Student as StudentResource;
class StudentController extends BaseController
{
    public function index()

    {

        $students = Student::all();
        return $this->sendResponse(StudentResource::collection($students), 'Students retrieved successfully.');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'roll' => 'required'
        ]);

   

        if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());       
        }

        $student = Student::create($input);
        return $this->sendResponse(new StudentResource($student), 'Student created successfully.');

    } 

   

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $student = Student::find($id);
        if (is_null($student)) {
            return $this->sendError('Student not found.');
        }
        return $this->sendResponse(new StudentResource($student), 'Student retrieved successfully.');
    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Student $student)

    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'roll' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

   

        $student->name = $input['name'];

        $student->roll = $input['roll'];

        $student->save();

   

        return $this->sendResponse(new StudentResource($student), 'Student updated successfully.');

    }

   

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy(Student $student)

    {

        $student->delete();
        return $this->sendResponse([], 'Student deleted successfully.');

    }
}
