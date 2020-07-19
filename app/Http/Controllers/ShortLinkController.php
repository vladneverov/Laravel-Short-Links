<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shortenLink', [
            'shortLinks' => ShortLink::latest()->get()
        ]);
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'link' => 'required|url'
        ]);
   
        ShortLink::create([
            'link' => $request->link,
            'code' => str_random(6)
        ]);
  
        return redirect()->route('generate.shorten.link')
                         ->with('success', 'Короткая ссылка успешно создана!');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();
        $find->count++;
        $find->save();
   
        return redirect($find->link);
    }
}
