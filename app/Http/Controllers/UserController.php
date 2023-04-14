<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function getAllRoles(){
        return Role::all();
    }


    //FUNCTION FOR LOGIN USER
    public function loginUser(Request $request){
        $validator =Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6']]);

        if ($validator->fails()) {
           return response()->json([
            'error'=>implode(' ',$validator->errors()->all()),
            'data'=>[]
           ]);
        }else{
            $userInfo=User::where('email','=', $request->email)->first();
           
            if(!$userInfo){
                return response()->json(['error'=>'We do not recognize your email address.']);
            }else{
                if (Hash::check( $request->password,$userInfo->password)) {

                    if ($userInfo->role=='admin') {
                        $this->scope=$userInfo->role;
                        // $token=$userInfo->createToken($userInfo->name.'-'.now(), $userInfo->role)->accessToken;
                        $token=$userInfo->createToken('MyToken',[$this->scope])->accessToken;
                    }else{
                        $token=$userInfo->createToken('MyToken')->accessToken;
                    }

                   

                    $success['jwtToken']=  $token;
                    // ---------SEND THROUGH COOKIES B/C IT IS THE BEST WAY-------
                    $cookie=cookie('jwt', $token, 60*24);  //----FOR ONE DAY------
                    $success['name']=$userInfo->name;
                    $success['role']=$userInfo->role;
                    return response()->json(['success'=>$success])->withCookie($cookie);
                    // return response(['message'=>'Success'])->withCookie($token);
                }else{
                    return response()->json(['error'=>'Incorrect password.']);
                }
            }

        }
    }

    // register user
    public function registerUser(Request $request){

        $validator =Validator::make($request->all(), [
            'username'=> ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:6']
        ]);

        if($validator->fails()) {
           return response()->json([
            'error'=>implode(' ',$validator->errors()->all()),
            'data'=>[]
           ]);
        }else{
            $save= User::create([
                'name' =>$request->username,
                'email' =>$request->email,
                'password' => Hash::make($request->password)
    
            ]);
             if($save) {
                // $success['jwtToken']= $save->createToken('MyApp')->accessToken;
                // $success['name']=$save->name;
                $success['status']=200;
                $success['message']='You have registered successfully, please contact with admin to approve you';
                return response()->json(['success'=>$success]);
            }
            else{
                return response()->json(['error'=>'Something went wrong. try again later']);
            }

        }
    }

    // GETTING ALL THE USERS INFORMATION
    public function getAllUsers(){
        return User::orderBy('id','desc')->get();
        // return Response::json(array(
        //     'status' => 'success',
        //     'pages' =>  $allUser->toArray()),
        //     200
        // );

    }

    // ---DELETE USER RECORD--------------
    public function deleteUser($id){
        return User::find($id)->delete();
    }

    // ------GET USER BY ID-----------
    public function getUserByID($id){
        return User::where('id',$id)->first();

    }

     // ------GET USER BY ID-----------
     public function updateUserData(Request $request){
        $validator =Validator::make($request->all(), [
            'userid'=> ['required'],
            'role' => ['required', 'string'],
            'isActive' => ['required']
        ]);

        if($validator->fails()) {
           return response()->json([
            'error'=>implode(' ',$validator->errors()->all()),
            'data'=>[]
           ]);
        }else{
            $save= User::where('id',$request->userid)->update([
                'role' => $request->role,
                'isActive' => $request->isActive
    
            ]);
             if($save) {
                $success['status']=200;
                $success['message']='your data is updated successfully';
                return response()->json(['success'=>$success]);
            }
            else{
                return response()->json(['error'=>'Something went wrong. try again later']);
            }

        }


    }
    

}
