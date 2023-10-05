<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\ProductController;



class ProductController extends Controller
{
    function product_sale( $limit,$type)
    {
        $args = [
            ['type', '=', $type],
            ['status', '=', 1]
        ];
        $products = Product::where($args)
            ->orderBy('created_at', 'DESC')
            -> limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'products' => $products
            ],
            200
        );
    }






    //PRODUCT_HOME
    public function product_home($limit, $category_id = 0)
    {
        $listid = array();
        array_push($listid, $category_id + 0);
        $args_cat1 = [
            ['parent_id', '=', $category_id + 0],
            ['status', '=', 1]
        ];
        $list_category1 = Category::where($args_cat1)->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row1) {
                array_push($listid, $row1->id);
                $args_cat2 = [
                    ['parent_id', '=', $row1->id],
                    ['status', '=', 1]
                ];
                $list_category2 = Category::where($args_cat2)->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row2) {
                        array_push($listid, $row2->id);
                    }
                }
            }
        }
        $products = Product::where('status','=', 1)
            ->whereIn('category_id', $listid)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
            
if(count($products)){
    return response()->json(
        [
            'success' => true,
            'message' => 'Tải dữ liệu thành công',
            'products' => $products
        ],
        200
    );
}
else{
    return response()->json(
        [
            'success' => false,
            'message' => 'Không có dữ liệu',
            'products' => null
        ],
       404
    );
}
}

//TẤT CẢ SẢN PHẨM PRODUCT_ALL
public function product_all($limit)
    {
        $products = Product::where('status','=', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'products' => $products
            ],
            200
        );
    }

//PRODUCT_DETAIL
public function product_detail($slug)
{
    $product =Product::where ([['slug','=',$slug],['status','=',1]])->first();
    if ($product==null){
        return response()->json(
            [
                'success' => false,
                'message' => 'Khong co du lieu',
                'products' =>null
            ],
            404
        );
    }
    $listid = array();
    array_push($listid, $product-> category_id);
    $args_cat1 = [
        ['parent_id', '=',$product->category_id],
        ['status', '=', 1]
    ];
    $list_category1 = Category::where($args_cat1)->get();
    if (count($list_category1) > 0) {
        foreach ($list_category1 as $row1) {
            array_push($listid, $row1->id);
            $args_cat2 = [
                ['parent_id', '=', $row1->id],
                ['status', '=', 1]
            ];
            $list_category2 = Category::where($args_cat2)->get();
            if (count($list_category2) > 0) {
                foreach ($list_category2 as $row2) {
                    array_push($listid, $row2->id);
                }
            }
        }
    }
    $product_order = Product::where([['id','!=',$product->id],['status','=',1]])
        ->whereIn('category_id', $listid)
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'product' => $product,
                'product_order'=>$product_order,
            ],
            200
        );
    }
//PRODUCT_CATEGORY

    public function product_category( $limit,$category_id)
    {
        $listid = array();
        array_push($listid, $category_id + 0);
        $args_cat1 = [
            ['parent_id', '=', $category_id + 0],
            ['status', '=', 1]
        ];
        $list_category1 = Category::where($args_cat1)->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row1) {
                array_push($listid, $row1->id);
                $args_cat2 = [
                    ['parent_id', '=', $row1->id],
                    ['status', '=', 1]
                ];
                $list_category2 = Category::where($args_cat2)->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row2) {
                        array_push($listid, $row2->id);
                    }
                }
            }
        }
        $products = Product::where('status', 1)
            ->whereIn('category_id', $listid)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'products' => $products
            ],
            200
        );
    }
//PRODUCT_BRAND
    public function product_brand($limit,$brand_id)
    {
        $products = Product::where([['brand_id', '=', $brand_id], ['status', '=', 1]])
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'products' => $products
            ],
            200
        );
    }


    


     //Get ---product/index
     public function index()

     {
 
         $products = Product::orderBy('created_at','DESC')->get();
 
         return response()->json(
 
             ['success' => true, 'message' => 'Tải dữ liệu thành công', 'products' => $products],
 
             200
 
         );
     }
     // Get -product/show
     public function show($id)
 
     {
 
         $product = Product::find($id);
         if ($product == null){
            return response()->json(
                ['message'=>'Tải dữ liệu không thành công','success'=>false,'product'=>null],404
            );
        }
     return response()->json(
 
             ['success' => true, 'message' => 'Tải dữ liệu thành công', 'product' => $product],
 
             200
 
         );
     }
     //Post- them store
     public function store(Request $request)
     {
         $product = new Product();
         $product->category_id=$request->category_id;
         $product->brand_id=$request->brand_id;
         $product->name = $request->name; //form
         $product->type = $request->type; //form

         $product->slug = Str::of($request->name)->slug('-');
         $product->price=($request->price);
         $product->pricesale=($request->pricesale);

         //$product->image=$request->name;//xử lý riêng

                 //upload image
        $files = $request->image;
        if ($files != null) {
            $extension = $files->getClientOriginalExtension();
            if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                $filename = $product->slug . '.' . $extension;
                $product->image = $filename;
                $files->move(public_path('images/product'), $filename);
            }
        }
        $product->quality=($request->quality);
        $product->detail=($request->detail);


        //  $product->sort_order = $request->sort_order; //form
         $product->metakey = $request->metakey; //form
         $product->metadesc = $request->metadesc; //form
        //  $product->parent_id=$request->parent_id;
         $product->created_at = date('Y-m-d H:i:s');
         $product->created_by = 1;
         $product->status = $request->status; //form
         $product->save(); //lưu vào Csdl
         return response()->json(
             ['success' => true, 'message' => 'Thành công', 'product' => $product],
             201
         );
     }
     //product-update
     public function update(Request $request, $id)
 
     {
 
         $product = Product::find($id);
         $product->category_id=$request->category_id;
         $product->brand_id=$request->brand_id;
         $product->type = $request->type; //form

         $product->name = $request->name; //form
 
         $product->slug = Str::of($request->name)->slug('-');
         $product->price=($request->price);
         $product->pricesale=($request->pricesale);

         // $product->image = $request->name;
                          //upload image
        $files = $request->image;
        if ($files != null) {
            $extension = $files->getClientOriginalExtension();
            if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                $filename = $product->slug . '.' . $extension;
                $product->image = $filename;
                $files->move(public_path('images/product'), $filename);
            }
        }

        $product->quality=($request->quality);

        $product->detail=($request->detail);

        //  $product->sort_order = $request->sort_order; //form
 
         $product->metakey = $request->metakey; //form
 
         $product->metadesc = $request->metadesc; //form
        //  $product->parent_id=$request->parent_id;
 
 
         $product->updated_at = date('Y-m-d H:i:s');
 
         $product->updated_by = 1; //takm cho =1
 
         $product->status = $request->status; //form
 
         $product->save(); //Luuu vao CSDL
 
         return response()->json(
 
             ['success' => true, 'message' => 'Thành công', 'product' => $product],
 
             200
 
         );
     }
     //xoa
     public function destroy ($id)
     {
         $product = Product::find($id);
         if($product == null){
             return response()->json(
                 ['message'=>'Tai du lieu khong thanh cong','success'=>false,'product'=> null],404
             );
         }
         $product->delete();
         return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
 
     }
     public function search_product($keyword){
     $products=Product::where([['name', 'like','%'.$keyword.'%'],['status','=',1]])
     ->orderBy('created_at','DESC')
     ->get();
     return response()->json(['success'=>true,'message'=>'Tải dữ liệu thành công','products'=>$products],200);
   }

 
}
