<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandlers;
use Illuminate\Auth\Access\AuthorizationException;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show']
        ]);
    }

    //
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->author($user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandlers $upload, User $user)
    {
        $this->author($user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $upload->save($request->avatar, 'avatars', $user->id, 362);
            $data['avatar'] = $result['path'];
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料编辑成功！');
    }

    private function author($user)
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e){
            abort(403, '无权访问');
        }
    }
}
