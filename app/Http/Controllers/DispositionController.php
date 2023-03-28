<?php

namespace App\Http\Controllers;

use App\Services\DispositionService;
use Illuminate\Http\Request;
use App\Services\SchedulesService;

class DispositionController extends Controller
{
    public $Service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->Service = new DispositionService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $authUser = \Session::get('loginUser');
        
        $data = $this->Service->getPagination($request); 
        $layoutData['js_plugin'] = $this->getJsPlugin(["JSP_BOOTSTRAP_BOOTBOX","JSP_SORTABLE"]);
        $layoutData['DispositionType'] = config("dashboard_constant.DISPOSIOTION_TYPE");
        $layoutData['status'] = config("dashboard_constant.DISPOSITION_STATUS");
        $layoutData['title'] = 'Disposition List | '.config("app.name");
        $layoutData['breadcrumb'] = [
            "links" => [
                [
                    "name" => "Disposition",
                    "url" => url("#/disposition-list"),
                    "icon" => "flaticon-user"
                ],
                [
                    "name" => "Disposition List",
                    "url" => url("#/disposition-list"),
                    "icon" => "flaticon-list-1"
                ]
            ],
            "singleButton" =>[
                [
                    "name" => "Add Disposition",
                    "url" => url("#/disposition-add"),
                    "icon" => "la la-plus",
                    "class" => "m-btn--air btn-accent"
                ]
            ]
        ];
        $layoutData['data'] = $data['data']; 
        // pagination meta value
        $layoutData['meta'] = $data['meta'];
        // pagination links
        $layoutData['links'] = $data['links'];
        
        // Return collection of list as a reosurce
		return response()->json($layoutData);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->Service->save($request);
        $responseMsg = $this->Service->processControllerResponse($data[config('msg_label.MSG_RESULT')], $data[config('msg_label.MSG_MESSAGE')]);
        return response()->json($responseMsg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->Service->getDetail($id);
        $layoutData['js_plugin'] = $this->getJsPlugin(["JSP_BOOTSTRAP_BOOTBOX","JSP_SORTABLE"]);
        $layoutData['DispositionType'] = config("dashboard_constant.DISPOSIOTION_TYPE");
        $layoutData['status'] = config("dashboard_constant.DISPOSITION_STATUS");
        $layoutData['title'] = 'Disposition List | '.config("app.name");
        $layoutData['breadcrumb'] = [
            "links" => [
                [
                    "name" => "Disposition",
                    "url" => url("#/disposition-list"),
                    "icon" => "flaticon-user"
                ],
                [
                    "name" => "Disposition List",
                    "url" => url("#/disposition-list"),
                    "icon" => "flaticon-list-1"
                ]
            ],
            "singleButton" =>[
                [
                    "name" => "Add Disposition",
                    "url" => url("#/disposition-add"),
                    "icon" => "la la-plus",
                    "class" => "m-btn--air btn-accent"
                ]
            ]
        ];
        $layoutData['data'] = $data;
        // Return collection of list as a reosurce
        return response()->json($layoutData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $this->Service->updateData($request);
        $responseMsg = $this->Service->processControllerResponse($data[config('msg_label.MSG_RESULT')], $data[config('msg_label.MSG_MESSAGE')]);
        return response()->json($responseMsg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->Service->delete($id);
        $responseMsg = $this->Service->processControllerResponse($data[config('msg_label.MSG_RESULT')], $data[config('msg_label.MSG_MESSAGE')]);
        return response()->json($responseMsg);
    }
}
