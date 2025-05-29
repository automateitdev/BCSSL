<?php

namespace App\Http\Controllers\Admin\CoreSetting;

use App\Http\Controllers\Controller;
use App\Services\Utils\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public $fileUploadService;
    public function __construct( FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_page_meta('Organization Info');
        return view('pages.admin.core-setting.organization-info.index');
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
        try {
            DB::beginTransaction();

            $settings = $request->except(['_token','_method']);

            if(isset($settings['image'])){

                $old_image_path = !is_null(getSetting('image')) ? 'setting'.'/'.getSetting('image'): NULL;
                $settings['image'] =  $this->fileUploadService->uploadFile($settings['image'], 'public/'.'setting',$old_image_path,null);
            }else{
                $settings['site_image'] = getSetting('site_image');
            }

            foreach($settings as $key => $value){
                if(is_null($value)){
                    $value = null;
                }
                setSetting($key, $value);
                DB::commit();
            }
            return back()->with('success','Setting store successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Something is worng!!');

        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
