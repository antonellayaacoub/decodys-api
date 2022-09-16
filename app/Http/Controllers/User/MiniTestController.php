<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MiniTests;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;


class MiniTestController extends Controller
{
    //
    protected $miniTests;
    protected $base_url;


    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->middleware("auth:users");
        $this->base_url = $urlGenerator->to("/");
        $this->miniTests = new MiniTests;
    }

    //this function/end-point is to create a new MiniTest specific to a user
    public function addMiniTests(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [


                "name" => "required|string",
                'grade' => 'required|integer',
                'test_id' => ['required', 'exists:tests,id'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }

        $this->miniTests->test_id = $request->test_id;
        $this->miniTests->name = $request->name;
        $this->miniTests->grade = $request->grade;

        $this->miniTests->save();


        return response()->json([
            "success" => true,
            "message" => "miniTests saved successfully"
        ], 200);
    }



    //getting MiniTests specific to a particular user
    public function getPaginatedData($test_id, $pagination = null)
    {

        if ($pagination == null || $pagination == "") {
            $miniTests = $this->miniTests->where("test_id", $test_id)->orderBy("done", "ASC")->get()->toArray();

            return response()->json([
                "success" => true,
                "data" => $miniTests,

            ], 200);
        } else {
            $miniTests_paginated = $this->miniTests->where("test_id", $test_id)->orderBy("done", "ASC")->paginate($pagination);
            return response()->json([
                "success" => true,
                "data" => $miniTests_paginated,

            ], 200);
        }
    }


    //update MiniTest endpoint/function

    public function editSingleData(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [

                "name" => "required|string",
                'grade' => 'required|integer',
                'done' => 'required|boolean',
                'answers' => 'required',
                'test_id' => ['required', 'exists:tests,id'],
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }


        $findData = $this->miniTests->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }

        $findData->test_id = $request->test_id;
        $findData->name = $request->name;
        $findData->grade = $request->grade;
        $findData->done = $request->done;
        $findData->answers = $request->answers;


        $findData->save();




        return response()->json([
            "success" => true,
            "message" => "miniTests updated successfully",
        ], 200);
    }


    //deleting miniTests endpoint

    public function deleteMiniTests($id)
    {
        $findData = $this->miniTests::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "miniTest with this id doesnt exist"
            ], 500);
        }


        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "miniTests deleted successfully"
            ], 200);
        }
    }

    //end point for getting a single data
    public function getSingleData($id)
    {

        $findData = $this->miniTests::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "miniTest with this id doesnt exist"
            ], 500);
        }
        return response()->json([
            "success" => true,
            "data" => $findData,
        ], 200);
    }
}
