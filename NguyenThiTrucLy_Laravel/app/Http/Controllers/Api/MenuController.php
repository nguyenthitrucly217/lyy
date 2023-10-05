<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\MenuController;

class MenuController extends Controller
{
    public function menu_list($position, $parent_id = 0)
    {
        $args = [
            ['position', '=', $position],
            ['parent_id', '=', $parent_id],
            ['status', '=', 1]
        ];
        $menus = Menu::where($args)
            ->orderBy('sort_order', 'ASC')
            ->get();

            if(count($menus)){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Tải dữ liệu thành công',
                        'menus' => $menus
                    ],
                    200
                );        
            }
            else
            {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Không có dữ liệu',
                        'menus' => null
                    ],
                    200
                );
        
            }
    }


         //Get ---menu/index
         public function index()

         {
     
             $menus = Menu::orderBy('created_at','DESC')->get();
     
             return response()->json(
     
                 ['success' => true, 'message' => 'Tải dữ liệu thành công', 'menus' => $menus],
     
                 200
     
             );
         }
         // Get -menu/show
         public function show($id)
     
         {
     
             $menu = Menu::find($id);
             if ($menu == null){
                return response()->json(
                    ['message'=>'Tải dữ liệu không thành công','success'=>false,'menu'=>null],404
                );
            }

             return response()->json(
     
                 ['success' => true, 'message' => 'Tải dữ liệu thành công', 'menu' => $menu],
     
                 200
     
             );
         }
         //Post- them store
         public function store(Request $request)
         {
             $menu = new Menu();
             $menu->name = $request->name; //form
             $menu->link = $request->link;
             $menu->user_id = $request->user_id;
             $menu->table_id = $request->table_id;

             $menu->sort_order = $request->sort_order; //form
             //$menu->image=$request->name;//xử lý riêng
             $menu->parent_id = $request->parent_id; //form
             $menu->position = $request->position; //form
             $menu->type = $request->type; //form
             
             $menu->created_at = date('Y-m-d H:i:s');
             $menu->created_by = 1;
             $menu->status = $request->status; //form
             $menu->save(); //lưu vào Csdl
             return response()->json(
                 ['success' => true, 'message' => 'Thành công', 'menu' => $menu],
                 201
             );
         }
         //menu-update
         public function update(Request $request, $id)
     
         {
     
             $menu = Menu::find($id);

             $menu->name = $request->name; //form
             $menu->link = $request->link;
             $menu->user_id = $request->user_id;
             $menu->table_id = $request->table_id;

             $menu->sort_order = $request->sort_order; //form
             //$menu->image=$request->name;//xử lý riêng
             $menu->parent_id = $request->parent_id; //form
             $menu->position = $request->position; //form
             $menu->type = $request->type; //form
                 
             $menu->updated_at = date('Y-m-d H:i:s');
     
             $menu->updated_by = 1; //takm cho =1
     
             $menu->status = $request->status; //form
     
             $menu->save(); //Luuu vao CSDL
     
             return response()->json(
     
                 ['success' => true, 'message' => 'Thành công', 'menu' => $menu],
     
                 200
     
             );
         }
         //xoa
         public function destroy ($id)
         {
             $menu = Menu::find($id);
             if($menu == null){
                 return response()->json(
                     ['message'=>'Tai du lieu khong thanh cong','success'=>false,'menu'=> null],404
                 );
             }
             $menu->delete();
             return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
     
         }
 
}
