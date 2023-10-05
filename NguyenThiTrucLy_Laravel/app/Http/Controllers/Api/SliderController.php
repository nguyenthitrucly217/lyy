<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Controllers\Api\SliderController;

class SliderController extends Controller
{
    public function slider_list($position)
    {
        $args = [
            ['position', '=', $position],
            ['status', '=', 1]
        ];
        $sliders = Slider::where($args)
            ->orderBy('sort_order', 'ASC')
            ->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Tải dữ liệu thành công',
                'sliders' => $sliders
            ],
            200
        );
    }

    
    //Get ---slider/index
            public function index()

            {
        
                $sliders = Slider::orderBy('created_at','DESC')->get();
        
                return response()->json(
        
                    ['success' => true, 'message' => 'Tải dữ liệu thành công', 'sliders' => $sliders],
        
                    200
        
                );
            }
            // Get -slider/show
            public function show($id)
        
            {
        
                $slider = Slider::find($id);
                if ($slider == null){
                    return response()->json(
                        ['message'=>'Tải dữ liệu không thành công','success'=>false,'slider'=>null],404
                    );
                }
    
                return response()->json(
        
                    ['success' => true, 'message' => 'Tải dữ liệu thành công', 'slider' => $slider],
        
                    200
        
                );
            }
            //Post- them store
            public function store(Request $request)
            {
                $slider = new Slider();
                $slider->name = $request->name; //form
                $slider->link = $request->link;
                $slider->sort_order = $request->sort_order; //form
                $slider->position = $request->position; //form
                                            //upload image
                    $files = $request->image;
                    if ($files != null) {
                        $extension = $files->getClientOriginalExtension();
                        if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                            $filename = $slider->name . '.' . $extension;
                            $slider->image = $filename;
                            $files->move(public_path('images/slider'), $filename);
                        }
                    }

                $slider->created_at = date('Y-m-d H:i:s');
                $slider->created_by = 1;
                $slider->status = $request->status; //form
                $slider->save(); //lưu vào Csdl
                return response()->json(
                    ['success' => true, 'message' => 'Thành công', 'slider' => $slider],
                    201
                );
            }
            //slider-update
            public function update(Request $request, $id)
            {
                $slider = Slider::find($id);
                $slider->name = $request->name; //form
                $slider->link = $request->link;
                $slider->sort_order = $request->sort_order; //form
                $slider->position = $request->position; //form
                    //upload image
                    $files = $request->image;
                    if ($files != null) {
                        $extension = $files->getClientOriginalExtension();
                        if (in_array($extension, ['jpg', 'png', 'gif', 'webp', 'jpeg'])) {
                            $filename = $slider->name . '.' . $extension;
                            $slider->image = $filename;
                            $files->move(public_path('images/slider'), $filename);
                        }
                    }
                $slider->updated_at = date('Y-m-d H:i:s');
                $slider->updated_by = 1; //takm cho =1
                $slider->status = $request->status; //form
                $slider->save(); //Luuu vao CSDL
                return response()->json(
        
                    ['success' => true, 'message' => 'Thành công', 'slider' => $slider],
        
                    200
        
                );
            }
            //xoa
            public function destroy ($id)
            {
                $slider = Slider::find($id);
                if($slider == null){
                    return response()->json(
                        ['message'=>'Tai du lieu khong thanh cong','success'=>false,'slider'=> null],404
                    );
                }
                $slider->delete();
                return response()->json(['message'=> 'thành công','success'=>true,'id'=>$id],200);
        
            }
    
}
