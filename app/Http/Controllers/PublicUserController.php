<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;
use App\Http\Requests\MyValidator;
use App\Models\Followers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class PublicUserController extends Controller
{
    //

    public function index()
    {
        return view('publicuser.public_home');
    }


    public function create(MyValidator $request)
    {
        $validated = $request->validated();
        $post = new Post;
        $post->post = $validated['post'];
        $post->user_id = Auth::user()->id;
        $post->save();
        Session::flash('create', "You have posted successfully");
        return redirect()->route('user_index');
    }

    public function feed()
    {
        $followers = Followers::where('user_id', Auth::user()->id)->get();
        $posts = [];
        foreach ($followers as $follower) {
            $post = Post::where('user_id', $follower->follower_id)->orWhere('user_id', auth()->user()->id)->with('comments')->get();
            array_push($posts, $post);
        }
        // dd($posts);
        // $posts = Post::arrange()->with('comments')->get();
        return view('publicuser.feed', ['posts' => $posts]);
    }

    public function comment(Request $request)
    {
        $validated = $request->validate([
            'post' => 'required',
            'post_id' => 'required|integer'
        ]);
        $comment = new Comments();
        $comment->post_id = $validated['post_id'];
        $comment->user_id = Auth::user()->id;
        $comment->comments = $validated['post'];
        $comment->save();
        return redirect()->route('feed');
    }

    public function del_post(Request $request)
    {
        $post = Post::find($request->id);
        $user = Auth::user();
        if (Gate::denies('check_user', $post)) {
            abort(403, 'You do not have the right to delete this post');
        }
        $delete = Post::where('id', $request->id)->delete();
        // dd($delete);
        if ($delete) {
            Session::flash('post_del', 'You have successfully deleted the post');
        }
        return redirect()->route('feed');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'search' => 'string|required'
        ]);
        $userSearch = User::where('name', 'like', "%" . $validated['search'] . "%")->get();
            
        if ($userSearch->count() < 1) {
            $userError = "There is no user like that ";
            return redirect()->back()->with('search', $userError);
        } else {
            return redirect()->back()->with('users', $userSearch);
        }
    }

    public function followAUser(Request $request)
    {

        $check = Followers::where('user_id', Auth::user()->id)->where('follower_id', $request->id)->first();
        $thisUser=Auth::user()->id;
        if ($check) {
            return redirect()->back()->withErrors(['followError' => "You have followed this person before"]);
        }
        if($thisUser==$request->id){
            return redirect()->back()->withErrors(['followError' => "This is your profile"]);
        }
        $follower = new Followers();
        $follower->user_id = Auth::user()->id;
        $follower->follower_id = $request->id;
        $follower->save();
        return redirect()->route('feed');
    }
}
