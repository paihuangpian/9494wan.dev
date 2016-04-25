<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LevelController extends Controller
{
    public function index(){
        $levels = \DB::table('levels')->where('status', 1)->orderBy('experience')->get();
        return view('admin.level.index', ['levels' => $levels]);
    }

    public function addLevel(){
        return view('admin.level.addLevel');
    }

    public function postLevel(Request $request){
        $info = [
    		'name.required' => '名称一定要填写',
    		'name.unique' => '名称重复了'
    	];

	    $validator = \Validator::make($request->all(), [
        	'name' => 'required|unique:levels'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('sign')){

            $file = $request->file('sign');

            if ($file->isValid()){
                
                $path = realpath(public_path('images/sign'));

                $filename = $file->getClientOriginalName();
               
                if(! $file->move($path, $filename)){
                    return redirect()->back()->withErrors(['errors' => '文件上传出错']);
                }
            }

        }

        $insert = array_except($request->all(), ['_token']);

        $insert['sign'] = $filename;

    	\DB::table('levels')->insert(
            $insert
		);

		return redirect()->back();
    }

    public function editLevel(){
        $level = \DB::table('levels')->find($_GET['id']);
        return view('admin.level.editLevel', ['level' => $level]);
    }

    public function updateLevel(Request $request){

        $info = [
            'name.required' => '名称一定要填写',
        ];

        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ], $info);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $update = array_except($request->all(), ['_token']);

        if ($request->hasFile('sign')){

            $file = $request->file('sign');

            if ($file->isValid()){
                
                $path = realpath(public_path('images/sign'));
                
                $filename = $file->getClientOriginalName();
               
                if(! $file->move($path, $filename)){
                    return redirect()->back()->withErrors(['errors' => '文件上传出错']);
                }
            }
            $update['sign'] = $filename;
        }

        \DB::table('levels')->where('id', $request->input('id'))->update(
            $update
        );

        return redirect()->back();
    }

    public function delLevel(){
        \DB::table('levels')->delete($_GET['id']);
        return redirect()->back();
    }
}
