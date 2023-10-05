<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\OrderController;
class OrderController extends Controller
{
        //Get ---order/index
        public function index()

        {
    
            $orders = Order::orderBy('created_at','DESC')->get();
    
            return response()->json(
    
                ['success' => true, 'message' => 'Tải dữ liệu thành công', 'orders' => $orders],
    
                200
    
            );
        }
        // Get -order/show
        public function show($id)
    
        {
    
            $order = Order::find($id);
            if ($order == null){
                return response()->json(
                    ['message'=>'Tải dữ liệu không thành công','success'=>false,'order'=>null],404
                );
            }

            return response()->json(
    
                ['success' => true, 'message' => 'Tải dữ liệu thành công', 'order' => $order],
    
                200
    
            );
        }
        //Post- them store
        public function store(Request $request)
        {
            $order = new Order();
            $order->user_id=$request->user_id;
            $order->name = $request->name; //form
            $order->phone =$request->phone;
            //$order->image=$request->name;//xử lý riêng

            $order->email = $request->email; //form
            $order->address = $request->address; //form
            $order->note = $request->note; //form
            
            $order->created_at = date('Y-m-d H:i:s');
            $order->created_by = 1;
            $order->status = $request->status; //form
            $order->save(); //lưu vào Csdl
            return response()->json(
                ['success' => true, 'message' => 'Thành công', 'order' => $order],
                201
            );
        }
        //order-update
        public function update(Request $request, $id)
    
        {
    
            $order = Order::find($id);
    
            $order->user_id=$request->user_id;
            $order->name = $request->name; //form
            $order->phone =$request->phone;
            //$order->image=$request->name;//xử lý riêng

            $order->email = $request->email; //form
            $order->address = $request->address; //form
            $order->note = $request->note; //form
            
    
            $order->updated_at = date('Y-m-d H:i:s');
    
            $order->updated_by = 1; //takm cho =1
    
            $order->status = $request->status; //form
    
            $order->save(); //Luuu vao CSDL
    
            return response()->json(
    
                ['success' => true, 'message' => 'Thành công', 'order' => $order],
    
                200
    
            );
        }
        //xoa
        public function destroy ($id)
        {
            $order = Order::find($id);
            if($order == null){
                return response()->json(
                    ['message'=>'Tai du lieu khong thanh cong','success'=>false,'order'=> null],404
                );
            }
            $order->delete();
            return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
    
        }

}
