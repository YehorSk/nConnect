<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

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

}
