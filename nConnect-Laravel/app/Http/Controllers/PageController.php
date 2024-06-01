<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:pages|max:255',
            'content' => 'required'
        ]);

        $page = new Page($data);
        $page->save();
        return response()->json("Page Created");
    }

    public function update(Request $request,$id){
        $page = Page::find($id);

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('pages')->ignore($page),
            ],
            'content' => 'required'
        ]);

        $page->update($data);
        return response()->json("Page Updated");
    }


    public function index(){
        $page = Page::all();
        return response()->json($page);
    }
    public function getCurrentPage($id){
        $page=Page::find($id);
        return response()->json($page);
    }
    public function destroy($id){
        $page=Page::find($id);
        $page->delete();
        return response()->json("Page Deleted");
    }

}
