<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\TopicController;

class TopicController extends Controller
{
           //Get ---topic/index
           public function index()

           {
       
               $topics = Topic::orderBy('created_at','DESC')->get();
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'topics' => $topics],
       
                   200
       
               );
           }
           // Get -topic/show
           public function show($id)
       
           {
       
               $topic = Topic::find($id);
               if ($topic == null){
                return response()->json(
                    ['message'=>'Tải dữ liệu không thành công','success'=>false,'topic'=>null],404
                );
            }

               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'topic' => $topic],
       
                   200
       
               );
           }
           //Post- them store
           public function store(Request $request)
           {
               $topic = new Topic();
               $topic->name = $request->name; //form
               $topic->slug = Str::of($request->name)->slug('-');
               $topic->metakey = $request->metakey; //form
               $topic->metadesc = $request->metadesc; //form
               $topic->parent_id=$request->parent_id;
               
               $topic->created_at = date('Y-m-d H:i:s');
               $topic->created_by = 1;
               $topic->status = $request->status; //form
               $topic->save(); //lưu vào Csdl
               return response()->json(
                   ['success' => true, 'message' => 'Thành công', 'topic' => $topic],
                   201
               );
           }
           //topic-update
           public function update(Request $request, $id)
       
           {
       
               $topic = Topic::find($id);
       
               $topic->name = $request->name; //form
       
               $topic->slug = Str::of($request->name)->slug('-');
              
               $topic->metakey = $request->metakey; //form
       
               $topic->metadesc = $request->metadesc; //form
               $topic->parent_id=$request->parent_id;
       
       
               $topic->updated_at = date('Y-m-d H:i:s');
       
               $topic->updated_by = 1; //takm cho =1
       
               $topic->status = $request->status; //form
       
               $topic->save(); //Luuu vao CSDL
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Thành công', 'topic' => $topic],
       
                   200
       
               );
           }
           //xoa
           public function destroy ($id)
           {
               $topic = Topic::find($id);
               if($topic == null){
                   return response()->json(
                       ['message'=>'Tai du lieu khong thanh cong','success'=>false,'topic'=> null],404
                   );
               }
               $topic->delete();
               return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
       
           }
   
}
