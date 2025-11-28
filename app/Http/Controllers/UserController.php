<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'avatars/';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($user)
    {
        $user = User::findOrFail($user);

        if (Auth::id() === $user->id) {
            $posts = $user->posts()->latest()->get();
        } else {
            $posts = $user->posts()->where('visibility', 'public')->latest()->get();
        }

        return view('users.show')
            ->with('user', $user)
            ->with('posts', $posts);
    }


    public function edit()
    {
        return view('users.edit')->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'about' => 'nullable|string|max:1000'
        ]);
        //unique:table,column,exceptID

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;

        #If there is a new image
        if ($request->avatar) {
            #delete the previous avatar from the local storage
            if ($user->avatar) {
                $this->deleteAvatar($user->avatar);
            }
            #save the new avatar
            $user->avatar = $this->saveAvatar($request->avatar);
        }
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function saveAvatar($avatar)
    {
        //Change the name of the avatar to CURRENT TIME to avoid overwriting
        $avatar_name = time() . "." . $avatar->extension();
        // Example: 1710012345.png

        //Save the avatar to storage/app/public/avatars/
        $avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    public function deleteAvatar($avatar)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar;
        //Sample: $avatar_past = 'avatars/1723643947.jpg'

        if (Storage::disk('public')->exists($avatar_path)) {
            Storage::disk('public')->delete($avatar_path);
        }
    }
}
