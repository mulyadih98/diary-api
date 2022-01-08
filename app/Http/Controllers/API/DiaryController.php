<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiaryPost;
use App\Http\Requests\DiaryUpdate;
use App\Services\DiaryServices;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DiaryServices $diaryServices)
    {
        $diary = $diaryServices->getAll();
        if(!count($diary)){
            return response()->json([
                "message" => "anda belum memiliki catatan"
            ]);
        }
        
        return response()->json([
            "data" =>  $diary
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiaryPost $request, DiaryServices $diaryServices)
    {
        $diary = $diaryServices->add($request->all());
        return response()->json([
            "message" => "diary created successfully",
            "data" => $diary
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,DiaryServices $diaryServices)
    {
        return response()->json($diaryServices->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiaryUpdate $request, $id, DiaryServices $diaryServices)
    {
        $diary = $diaryServices->update($id,[
            "title" => $request->title,
            "value" => nl2br($request->value)
        ]);

        return response()->json([
            "message" => "diary updated successfully",
            "data" => $diary
        ]);
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,DiaryServices $diaryServices)
    {
        $diary = $diaryServices->delete($id);
        return response()->json([
            "message" => "diary deleted successfully",
            "data" => $diary->id
        ]);
    }
}
