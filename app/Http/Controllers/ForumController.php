<?php

namespace App\Http\Controllers;

use Auth;
use Purifier;
use App\Brand;
use App\Forum;
use App\Comment;
use App\Marketing;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['show','index','brand']]);
    }

    public function index(){
    	$threads   = Forum::latest()->paginate(3);
    	return view('forums.index', compact('threads'));
    }

    public function create(){
		$brands		  = Brand::orderBy('brand')->get();
		return view('forums.create', compact('brands'));
    }

    public function store(Request $request){
        $this->validate($request, [
                'title' => 'required|unique:forums|min:3|max:255',
                'body' => 'required|min:3',
                'brand_id' => 'required',
            ]);
        $brand = Brand::whereId($request->brand_id)->first();
        Auth::user()->forums()->create([
    		'title' => Purifier::clean($request->title),
    		'slug' => $slug = str_slug($request->title),
    		'img' => $request->img,
    		'body' => Purifier::clean($request->body),
    		'brand_id' => $request->brand_id,
    	]);
    	return redirect("/forum/{$brand->slug}/{$slug}");
    }

    public function show($brand, $slug){
        $brand      = Brand::whereSlug($brand)->first();
        $thread     = Forum::whereSlug($slug)->first();
        if (!$thread) {
            return view('errors.404');
        }
        $comments   = $thread->comments()->latest()->paginate(5);
        if ($thread && $brand) {
            return view('forums.show', compact('thread','comments','brand'));
        }
            return redirect('/forum');
    }

    public function edit($id){
    	$thread   = Forum::whereId($id)->first();
    	$brands	  = Brand::orderBy('brand')->get();
    	return view('forums.edit', compact('thread', 'brands'));
    }
    
    public function update(Request $request, $id){
        $this->validate($request, [
                'title' => 'required|min:3|max:255',
                'body' => 'required|min:3',
                'brand_id' => 'required',
            ]);
    	$thread = Forum::find($id);
        $brand = Brand::whereId($request->brand_id)->first();
    	$thread->update([
    	    		'title' => Purifier::clean($request->title),
    	    		'slug' => $slug = str_slug($request->title),
    	    		'img' => $request->img,
    	    		'body' => Purifier::clean($request->body),
    	    		'brand_id' => $request->brand_id,
    	    	]);
    	return redirect("/forum/{$brand->slug}/{$slug}");
    }

    public function brand($brand){
        $brand      = Brand::whereSlug($brand)->first();
        if ($brand) {
            $threads   = Forum::where('brand_id',$brand->id)->latest()->paginate(5);
            return view('forums.index', compact('threads'));
        }
            return redirect('/forum');
    }

}
