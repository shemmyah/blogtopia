<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\Notification;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'images/';
    //const - constant value that cannot be change (image will always be saved in 'images/')
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function index()
    {
        $all_posts = $this->post->where('visibility', 'public')->latest()->get();
        return view('posts.index')->with('all_posts', $all_posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function userPost($user_id)
    {
        $user = $this->user->findOrFail($user_id);

        // if (Auth::id() === $user_id) {
        $posts = $user->posts()->latest()->get();
        // } else {
        //     $posts = $user->posts()->where('visibility', 'public')->latest()->get();
        // }

        return view('posts.user-post')->with('posts', $posts)->with('user', $user);
    }




    public function store(Request $request)
    {
        #1. Validate the request
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048',
            'visibility' => 'required|in:public,private'
        ]);
        // mimes - multipurpose internet mail extensions
        #2. Save the form data to posts table in database
        $this->post->user_id = Auth::user()->id;
        $this->post->title = $request->title;
        $this->post->body = $request->body;
        $this->post->image = $this->saveImage($request->image);
        $this->post->visibility = $request->visibility;
        $this->post->save();

        #3. Send notification
        $otherUsers = User::where('id', '!=', auth()->id())->get();

        Notification::send($otherUsers, new PostCreated($this->post));


        #4. Redirect to homepage
        return redirect()->route('post.show', $this->post->id);
    }

    public function saveImage($image)
    {
        //Change the name of the image to CURRENT TIME to avoid overwriting
        $image_name = time() . "." . $image->extension();
        // Example: 1710012345.png

        //Save the image to storage/app/public/images/
        $image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        if (Auth::check()) {
            Auth::user()->unreadNotifications
                ->where('type', 'PostCreated')
                ->where('data.post_id', $post->id)
                ->markAsRead();
        }

        return view('posts.show')->with('post', $post);
    }


    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if ($post->user->id != Auth::user()->id) {
            return redirect()->back();
        }

        return view('posts.edit')->with('post', $post);
    }

    public function update(Request $request, $id)
    {
        #1. Validate the request
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'visibility' => 'required|in:public,private'
        ]);
        // mimes - multipurpose internet mail extensions
        #2. Save the form data to posts table in database
        $post = $this->post->findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->visibility = $request->visibility;

        #If there is a new image
        if ($request->image) {
            #delete the previous image from the local storage
            $this->deleteImage($post->image);

            #save the new image
            $post->image = $this->saveImage($request->image);
        }
        $post->save();

        return redirect()->route('post.show', $id);
    }

    public function deleteImage($image)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image;
        //Sample: $image_past = 'images/1723643947.jpg'

        if (Storage::disk('public')->exists($image_path)) {
            Storage::disk('public')->delete($image_path);
        }
    }

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        $post->delete();

        return redirect()->back();
    }
}
