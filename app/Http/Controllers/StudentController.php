<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    public function saveStudent(Request $request){

        $request->validate([
            'name'=>'required|min:5|max:255',
            'email'=>'required|min:5|max:1000',
            'phone'=>'required|min:1',
        ]);

        $student = new Student;
        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;
        $student->save();
        return response()->json($student);
    }

    public function allStudents(){
        $students = Student::paginate(3);
        return response()->json($students);

    }

    public function editStudent($id){
        $student = Student::find($id);
        return response()->json($student);
    }

    public function updateStudent(Request $request){
        $request->validate([
            'name'=>'required|min:5|max:255',
            'email'=>'required|min:5|max:1000',
            'phone'=>'required|min:1',
        ]);

        $student = Student::find(request()->id);
        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;
        $student->update();

        return response()->json($student);
    }

    public function deleteStudent($id){
        $student = Student::find($id);
        $student->delete();
        return response()->json($student);
    }

}
