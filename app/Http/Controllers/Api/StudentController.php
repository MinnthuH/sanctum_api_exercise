<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    // REGISTER API
    public function register(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed',
        ]);

        // create data
        $student = new Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone = isset($request->phone) ? $request->phone : '';

        $student->save();

        // send response

        return response()->json([
            'status' => 1,
            'message' => 'Student created successfully',
        ]);
    }

    // LOGIN API
    public function login(Request $request)
    {
        // validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // check student
        $student = Student::where('email', $request->email)->first();

        if (isset($student->id)) {

            if (Hash::check($request->password, $student->password)) {

                // create token
                $token = $student->createToken('auth_token')->plainTextToken;

                // send a respone
                return response()->json([
                    "stauts" => 1,
                    "message" => "Login Successfully",
                    "token" => $token,

                ]);

            } else {
                return response()->json([
                    "status" => 0,
                    "message" => "Password not match",
                ], 404);
            }
            // create token

        } else {
            return response()->json([
                "status" => 0,
                "message" => "Student not fund",
            ], 404);
        }

    }

    // PROFILE API
    public function profile()
    {
        return response()->json([
            "status" => 1,
            "message" => "Porfile information",
            "data" => Auth::user(),
        ]);
    }

    // LOGOUT API
    public function logout()
    {
       Auth::user()->tokens()->delete();

       return response()->json([
        "status" => 1,
        "message" => "Logout Successfully",
       ]);

    }
}
