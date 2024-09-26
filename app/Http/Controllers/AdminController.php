<?php

namespace App\Http\Controllers;

use illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function post_page()
    {
        return view('admin.post_page');
    }

    public function add_post(request $request)
    {

        $user = Auth()->user();

        $user_id = $user->id;

        $name = $user->name;

        $usertype = $user->usertype;

        $post = new Post;

        $post->title = $request->title;

        $post->description = $request->description;

        $post->post_status = 'active';

        $post->user_id = $user_id;

        $post->name = $name;

        $post->usertype = $usertype;

        $image = $request->image;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            $request->image->move('postimage', $imagename);

            $post->image = $imagename;
        }

        $post->save();

        return redirect()->back()->with('message', 'Post Added Successfully');
    }

    public function show_post()
    {
        $post = Post::all();

        return view('admin.show_post', compact('post'));
    }

    public function delete_post($id)
    {

        $post = Post::find($id);

        $post->delete();

        return redirect()->back()->with('message', 'Post Deleted Succesfull');
    }

    public function edit_page($id)
    {
        $post = Post::find($id);

        return view('admin.edit_page', compact('post'));
    }
}
