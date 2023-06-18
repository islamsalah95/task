<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function show(Request $request)
    {
    if ($request->has('me')) {
        $results = Post::where('user_id', auth()->user()->id)->get();
    } else {
        $results = Post::where('status', 'display')->get();
    }

        return  response()->json($results, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>['required','max:10','string'],
            'content'=>['required','max:10','string'],
            'status' =>['nullable',Rule::in(['hide', 'display'])]
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $result=Post::create([
                'title' => 'Flight 10',
                'content' => 'Flight 10',
                'user_id' => Auth::user()->id,
            ]);
        
        return  response()->json($result, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function showHidePosts()
    {
        $results= Post::where('status','hide')->get();

        return  response()->json($results, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function changeStatusPost(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'status' =>['nullable',Rule::in(['hide', 'display'])]
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $post = Post::find($id);
        $post->status =$request->status;
        $post->save();

        return  response()->json($post, 200);
    }
}
