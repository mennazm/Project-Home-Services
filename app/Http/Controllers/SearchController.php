<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Service;

class SearchController extends Controller
{
    public function autocomplete(Request $req)
    {
        $data = Service::select('name')->where("name","LIKE","%{$req->input('query')}%")->get();
        return response()->json($data);
    }

    public function searchService(Request $req)
    {
        $service_slug = str::slug($req->q,'-');
        if($service_slug)
        {
            return redirect('/service/'.$service_slug);
        }
        else
        {
            return back();
        }
    }
}
