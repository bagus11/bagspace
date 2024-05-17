<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\updateCategoryRequest;
use App\Models\Timeline\MasterTimelineCategory as Model;
use Illuminate\Http\Request;

class MasterTimelineCategory extends Controller
{
    function index() {
        return view('timeline.master_category.master_category-index');
    }
    function getTimelineCategory() {
        $data = Model::with(['typeRelation'])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function saveTimelineCategory(Request $request, StoreCategoryRequest $storeCategoryRequest) {
        try {
            $storeCategoryRequest->validated();
            $post =[
                'name'          =>$request->name,
                'description'   =>$request->description,
                'type_id'       =>$request->type_id,
                'status'        =>0,
            ];
            // dd($request);
          
            Model ::create($post);
            return ResponseFormatter::success(
               $post,
                'Category successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to add',
                500
            );
        }
    }
    function updateTimelineCategory(Request $request, updateCategoryRequest $updateCategoryRequest) {
        // try {
            $updateCategoryRequest->validated();
            $post =[
                'name'          =>$request->name_edit,
                'description'   =>$request->description_edit,
                'type_id'       =>$request->type_id_edit,
            ];
            // dd($request);
          
            Model ::find($request->id)->update($post);
            return ResponseFormatter::success(
               $post,
                'Category successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Category failed to update',
        //         500
        //     );
        // }
    }
    function updateStatusCategory(Request $request) {
        try {
            $header = Model::find($request->id);
            $post =[
                'status'    => $header->status == 0 ?1 : 0
            ];
            $header->update($post);
            return ResponseFormatter::success(
               $post,
                'Category successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to update',
                500
            );
        }
    }
}
