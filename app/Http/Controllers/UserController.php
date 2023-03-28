<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }
    public function get_user(){
        $user = User::latest()->get();
        return response()->json([
            'users' => $user
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }else{
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->save();
            return response()->json([
                'status' => 200,
                'success' => "User Store Successfully"
            ]);
        }
    }

    public function edit($id){
        $user = User::find($id);
        if($user){
            return response()->json([
                'status' => 200,
                'user' =>  $user
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'errorMsg' => 'User Does not exist'
            ]);
        }

    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }else{
            $user = User::find($id);
            if($user){
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->phone = $request->input('phone');
                $user->update();
                return response()->json([
                    'status' => 200,
                    'success' => "User Updated Successfully"
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'errorMsg' => 'User Does not exist'
                ]);
            }

        }
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => 200,
            'success' => 'User Deleted Successfully'
        ]);
    }

}
