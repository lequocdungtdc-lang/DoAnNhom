<?php

namespace App\Http\Controllers;

use App\Models\Categories;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
   // list
    public function index()
    {
        $data = Categories::all();
        // trả về json 
        return response()->json(
            [
                'data' => $data
            ]
        );
    }

    //Delete
    public function delete($id)
    {
        $data = Categories::find($id);
        $data->delete();
        return response()->json([
            'message' => 'Xóa danh sách thành công!'
        ]);
    }



    // lưu dữ liệu
    public function create(Request $request)
    {
        // id: number;
        // tentheloai: string;
        // nhom?: string;
        // image?: string;
        // description?: string;
        // status: boolean;
        // created_at?: string;
        // updated_at?: string;
        // vue js 
        $data = new Categories();
        $data->tentheloai = $request->tentheloai;
        $data->nhom = $request->nhom;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->save();
        return response()->json([
            'message' => 'Them danh sach thanh cong'
        ]);
    }
    // edit
    public function edit($id)
    {
        $data = Categories::find($id);
        return response()->json([
            'data' => $data
        ]);
    }
    // update
    public function update(Request $request, $id)
    {
        $data = Categories::find($id);
        $data->tentheloai = $request->tentheloai;
        $data->nhom = $request->nhom;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->save();
        return response()->json([
            'message' => 'Sua danh sach thanh cong'
        ]);
    }
}
