<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tests;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;



class TestController extends Controller
{
    //
    protected $tests;
    protected $base_url;


    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->middleware("auth:users");
        $this->base_url = $urlGenerator->to("/");
        $this->tests = new Tests;
    }

    //this function/end-point is to create a new Test specific to a user
    public function addTests(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'grade' => 'required|integer',
                'patient_id' => ['required', 'exists:patients,id'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }





        $this->tests->patient_id = $request->patient_id;
        $this->tests->grade = $request->grade;




        $this->tests->save();


        return response()->json([
            "success" => true,
            "message" => "tests saved successfully",
            "test_id"=> $this->tests->id,
        ], 200);
    }



    //getting Tests specific to a particular user
    public function getPaginatedData($patient_id, $pagination = null)
    {

        if ($pagination == null || $pagination == "") {
            $tests = $this->tests->where("patient_id", $patient_id)->orderBy("id", "DESC")->get()->toArray();

            return response()->json([
                "success" => true,
                "data" => $tests,

            ], 200);
        } else {

            $tests_paginated = $this->tests->where("patient_id", $patient_id)->orderBy("id", "DESC")->paginate($pagination);
            return response()->json([
                "success" => true,
                "data" => $tests_paginated,

            ], 200);
        }
    }


    //update Test endpoint/function

    public function editSingleData(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'grade' => 'required|integer',
                'patient_id' => ['required', 'exists:patients,id'],
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }


        $findData = $this->tests->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





        $findData->patient_id = $request->patient_id;
        if ($request->grade) {
            $findData->grade = $request->grade;
        }


        $findData->save();





        return response()->json([
            "success" => true,
            "message" => "tests updated successfully",
        ], 200);
    }


    //deleting tests endpoint

    public function deleteTests($id)
    {
        $findData = $this->tests::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "test with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {
           

            return response()->json([
                "success" => true,
                "message" => "tests deleted successfully"
            ], 200);
        }
    }

    //end point for getting a single data
    public function getSingleData($id)
    {

        $findData = $this->tests::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "test with this id doesnt exist"
            ], 500);
        }
        return response()->json([
            "success" => true,
            "data" => $findData,
        ], 200);
    }
}
