<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BookController extends Controller
{
   	public function postBook(Request $request){
   		$info = [
    		'content.required' => '内容一定要填写',
    	];

	    $validator = \Validator::make($request->all(), [
        	'content' => 'required'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);
        $insert['created_at'] = date('Y-m-d');
        $insert['user_id'] = \Auth::user()->id;

    	$result = \DB::table('books')->insert(
            $insert
		);

    	if($result){
    		return redirect()->back()->withErrors(['errors' => '成功射出~'])->withInput();
    	}

		return redirect()->back();
   	}

    public function index(){
        $books = \DB::table('books')->get();
        return view('admin.book', ['books' => $books]);
    }
}
