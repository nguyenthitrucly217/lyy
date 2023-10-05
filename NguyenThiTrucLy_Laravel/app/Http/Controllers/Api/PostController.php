<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\PostController;

class PostController extends Controller
{


    function post_list( $limit,$type)
    {
        $args = [
            ['type', '=', $type],
            ['status', '=', 1]
        ];
        $posts = Post::where($args)
            ->orderBy('created_at', 'DESC')
            -> limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'posts' => $posts
            ],
            200
        );
    }


    function post_listPa($slug)
    {
        $args = [
            // ['slug','=',$slug],
            ['type', '=', $type],
            ['status', '=', 1]
        ];
        $posts = Post::where($args)
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'posts' => $posts
            ],
            200
        );
    }


//     function post_list( $limit,$topic_id=0)
//     {
//         $listid = array();
//         array_push($listid, $topic_id + 0);
//         $args_top1 = [
//             ['parent_id', '=', $topic_id + 0],
//             ['status', '=', 1]
//         ];
//         $list_topic1 = Topic::where($args_top1)->get();
//         if (count($list_topic1) > 0) {
//             foreach ($list_topic1 as $row1) {
//                 array_push($listid, $row1->id);
//                 $args_top2 = [
//                     ['parent_id', '=', $row1->id],
//                     ['status', '=', 1]
//                 ];
//                 $list_topic2 = Topic::where($args_top2)->get();
//                 if (count($list_topic2) > 0) {
//                     foreach ($list_topic2 as $row2) {
//                         array_push($listid, $row2->id);
//                     }
//                 }
//             }
//         }
//         $posts = Post::where('status','=', 1)
//             ->whereIn('topic_id', $listid)
//             ->orderBy('created_at', 'DESC')
//             ->limit($limit)
//             ->get();
            
// if(count($posts)){
//     return response()->json(
//         [
//             'success' => true,
//             'message' => 'Tải dữ liệu thành công',
//             'posts' => $posts
//         ],
//         200
//     );
// }
// else{
//     return response()->json(
//         [
//             'success' => false,
//             'message' => 'Không có dữ liệu',
//             'posts' => null
//         ],
//        404
//     );
// }
// }

//POST_TOPIC

public function post_topic( $limit,$topic_id)
{
    $listid = array();
            array_push($listid, $topic_id + 0);
            $args_top1 = [
                ['parent_id', '=', $topic_id + 0],
                ['status', '=', 1]
            ];
            $list_topic1 = Topic::where($args_top1)->get();
            if (count($list_topic1) > 0) {
                foreach ($list_topic1 as $row1) {
                    array_push($listid, $row1->id);
                    $args_top2 = [
                        ['parent_id', '=', $row1->id],
                        ['status', '=', 1]
                    ];
                    $list_topic2 = Topic::where($args_top2)->get();
                    if (count($list_topic2) > 0) {
                        foreach ($list_topic2 as $row2) {
                            array_push($listid, $row2->id);
                        }
                    }
                }
            }
    $posts = Post::where('status', 1)
        ->whereIn('topic_id', $listid)
        ->orderBy('created_at', 'DESC')
        ->limit($limit)
        ->get();
    return response()->json(
        [
            'success' => true,
            'message' => 'Tải dữ liệu thành công',
            'posts' => $posts
        ],
        200
    );
}


//POST_ALL
    public function post_all($limit)
    {
        $post = Post::where('status','=', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'post' => $post
            ],
            200
        );
    }


//POST_DETAIL
    public function post_detail($id)
{
    $post =Post::where ([['id','=',$id],['status','=',1]])->first();
    if ($post==null){
        return response()->json(
            [
                'success' => false,
                'message' => 'Khong co du lieu',
                'post' =>null
            ],
            404
        );
    }
    $listid = array();
    array_push($listid, $post->topic_id);
    $args_top1 = [
        ['parent_id', '=',$post->topic_id],
        ['status', '=', 1]
    ];
    $list_topic1 = Topic::where($args_top1)->get();
    if (count($list_topic1) > 0) {
        foreach ($list_topic1 as $row1) {
            array_push($listid, $row1->id);
            $args_top2 = [
                ['parent_id', '=', $row1->id],
                ['status', '=', 1]
            ];
            $list_topic2 = Topic::where($args_top2)->get();
            if (count($list_topic2) > 0) {
                foreach ($list_topic2 as $row2) {
                    array_push($listid, $row2->id);
                }
            }
        }
    }
    $post_order = Post::where([['id','!=',$post->id],['status','=',1]])
        ->whereIn('topic_id', $listid)
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'post' => $post,
                'post_order'=>$post_order,
            ],
            200
        );
    }
    
           //Get ---post/index
           public function index()

           {
       
               $posts = Post::orderBy('created_at','DESC')->get();
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'posts' => $posts],
       
                   200
       
               );
           }

                      //Get ---post/index
                      public function indexPa()

                      {
                  
                          $posts = Post::where("type","=","page")->get();
                  
                          return response()->json(
                  
                              ['success' => true, 'message' => 'Tải dữ liệu thành công', 'posts' => $posts],
                  
                              200
                  
                          );
                      }
           
           // Get -post/show
           public function show($id)
       
           {
       
               $post = Post::find($id);
               if ($post == null){
                return response()->json(
                    ['message'=>'Tải dữ liệu không thành công','success'=>false,'post'=>null],404
                );
            }

               return response()->json(
       
                   ['success' => true, 'message' => 'Tải dữ liệu thành công', 'post' => $post],
       
                   200
       
               );
           }
           //Post- them store
           public function store(Request $request)
           {
               $post = new Post();
            //    $post->name = $request->name; //form
               $post->topic_id = $request->topic_id; //form
               $post->title = $request->title; //form
               $post->slug = Str::of($request->title)->slug('-');
               $post->detail = $request->detail; //form
               //$post->image=$request->name;//xử lý riêng
               $files = $request->image;
               if ($files != null) {
                   $extension = $files->getClientOriginalExtension();
                   if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                       $filename = $post->title . '.' . $extension;
                       $post->image = $filename;
                       $files->move(public_path('images/post'), $filename);
                   }
               }
       
               $post->type = $request->type; //form
               $post->metakey = $request->metakey; //form
               $post->metadesc = $request->metadesc; //form
               
               $post->created_at = date('Y-m-d H:i:s');
               $post->created_by = 1;
               $post->status = $request->status; //form
               $post->save(); //lưu vào Csdl
               return response()->json(
                   ['success' => true, 'message' => 'Thành công', 'post' => $post],
                   201
               );
           }
           //post-update
           public function update(Request $request, $id)
       
           {
       
               $post = Post::find($id);
            //    $post->name = $request->name; //form

               $post->topic_id = $request->topic_id; //form
               $post->title = $request->title; //form
               $post->slug = Str::of($request->title)->slug('-');
               $post->detail = $request->detail; //form
               //$post->image=$request->name;//xử lý riêng
               $files = $request->image;
               if ($files != null) {
                   $extension = $files->getClientOriginalExtension();
                   if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                       $filename = $post->detail . '.' . $extension;
                       $post->image = $filename;
                       $files->move(public_path('images/post'), $filegetname);
                   }
               }
       
               $post->type = $request->type; //form
               $post->metakey = $request->metakey; //form
               $post->metadesc = $request->metadesc; //form
       
               $post->updated_at = date('Y-m-d H:i:s');
       
               $post->updated_by = 1; //tạm cho =1
       
               $post->status = $request->status; //form
       
               $post->save(); //Luuu vao CSDL
       
               return response()->json(
       
                   ['success' => true, 'message' => 'Thành công', 'post' => $post],
       
                   200
       
               );
           }
           //xoa
           public function destroy ($id)
           {
               $post = Post::find($id);
               if($post == null){ 
                   return response()->json(
                       ['message'=>'Tai du lieu khong thanh cong','success'=>false,'post'=> null],404
                   );
               }
               $post->delete();
               return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
       
           }
   
}
