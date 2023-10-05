<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\UserController;

class UserController extends Controller
{
           //Get ---use/index
           public function index()

           {
                $users = User::all(); 
            //    $users = User::where("roles","=","admin")->get();
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'users' => $users],
       
                   200
       
               );
           }
           public function indexcustomer()

           {
       
               $users = User::orderBy('created_at','DESC')->get();
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'users' => $users],
       
                   200
       
               );
           }

           // Get -use/show
           public function show($id)
       
           {
       
               $user = User::find($id);
               if ($user == null){
                return response()->json(
                    ['message'=>'Tải dữ liệu không thành công','success'=>false,'user'=>null],404
                );
            }

               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'user' => $user],
       
                   200
       
               );
           }
           //Post- them store
           public function store(Request $request)
           {
               $user = new User();
               $user->name = $request->name; //form
               $user->email = $request->email; //form
               $user->phone = $request->phone; //form
               $user->username = $request->username; //form
               $user->password=$request->password;
               $user->address=$request->address;   
               //images
               $files = $request->image;
               if ($files != null) {
                   $extension = $files->getClientOriginalExtension();
                   if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                       $filename = $user->username . '.' . $extension;
                       $user->image = $filename;
                       $files->move(public_path('images/user'), $filename);
                   }
               }
       
               $user->roles=$request->roles;           
               $user->created_at = date('Y-m-d H:i:s');
               $user->created_by = 1;
               $user->status = $request->status; //form
               $user->save(); //lưu vào Csdl
               return response()->json(
                   ['success' => true, 'message' => 'Thành công', 'user' => $user],
                   201
               );
           }
           //use-update
           public function update(Request $request, $id)
       
           {
       
               $user = User::find($id);
       
               $user->name = $request->name; //form
               $user->email = $request->email; //form
               $user->phone = $request->phone; //form
               $user->username = $request->username; //form
               $user->password=$request->password;
               $user->address=$request->address;   
               //images
               $files = $request->image;
               if ($files != null) {
                   $extension = $files->getClientOriginalExtension();
                   if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                       $filename = $user->username . '.' . $extension;
                       $user->image = $filename;
                       $files->move(public_path('images/user'), $filename);
                   }
               }
       
               $user->roles=$request->roles;           
               $user->updated_at = date('Y-m-d H:i:s');
       
               $user->updated_by = 1; //takm cho =1
       
               $user->status = $request->status; //form
       
               $user->save(); //Luuu vao CSDL
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Thành công', 'user' => $user],
       
                   200
       
               );
           }
           //xoa
           public function destroy ($id)
           {
               $user = User::find($id);
               if($user == null){
                   return response()->json(
                       ['message'=>'Tai du lieu khong thanh cong','success'=>false,'user'=> null],404
                   );
               }
               $user->delete();
               return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
       
           }
           public function kiemtra(Request $request)
           {
            $args = [
                ['email', '=',$request->email],
                ['password', '=',$request->password],
                ['status','=',1]
            ];
            $user = User::where($args) -> get();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Đăng nhập thành công',
                    'user' => $user
                ],
                200
            );
    
           }

           public function registerhome(Request $request)
        {
            $user = new User();
            $user->name = $request->name; //form
            $user->email = $request->email; //form
            $user->phone = $request->phone; //form
            $user->image = $request->image; //form
            $user->password=$request->password;
            $user->roles = $request->roles; //form
            $user->created_at = date('Y-m-d H:i:s');
            $user->created_by = 1;
            $user->status = $request->status; //form
            $user->save(); //lưu vào Csdl
         return response()->json(
                ['success' => true, 'message' => 'Đăng ký thành công', 'user' => $user],
                200
            );
        }



}