<?php

namespace App\Http\Controllers\Apps\Platform\System;

use App\Models\User;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 账户管理
 *
 * @package App\Http\Controllers\Apps\Platform
 */
class UserController extends Controller
{
    use JsonResponse;

    /**
     * 获得用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $query = \request('query');
        $deleted = \request('deleted', 0);
        $uQue = User::where('id', '>', 0);
        if ($deleted) {
            $uQue->withTrashed()->whereNotNull('deleted_at');
        }
        if ($query) {
            $uQue->where(function ($sub) use ($query) {
                $sub->where('name', 'like', "{$query}%")
                    ->orWhere('mobile', 'like', "{$query}%");
            });
        }
        $users = $uQue->paginate();
        return view('apps.platform.system.users.list')
            ->with('users', $users)
            ->with('deleted', $deleted)
            ->with('query', $query);
    }
    /**
     * 保存用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStore(Request $request)
    {
        $id = $request->input('id', 0);
        $rules = [
            'name' => 'required|string',
            'mobile' => 'required|digits:11|unique:users,mobile,' . $id . ',id',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ];
        if ($id <= 0) {
            $rules['password'] = 'required|confirmed|min:6';
        }
        $validator = validator($request->input(), $rules);
        if ($validator->fails()) {
            return self::retErr($validator->errors()->first());
        }

        $pwd = $request->input('password');
        if ($id > 0) {
            $user = User::withTrashed()->find($id);
            if (!$user) {
                $msg = '用户资料不存在！';
            } else {
                if ($pwd) {
                    $user->password = bcrypt($pwd);
                }
                $user->fill($request->input());
            }
        } else {
            $user = new User($request->input());
            $user->password = bcrypt($pwd);
        }
        if ($user && $user->save()) {
            return self::retSuc();
        }

        return self::retErr($msg ?? '用户保存失败！');
    }
    /**
     * 获得用户信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile($id)
    {
        $user = User::withTrashed()->find($id);
        return self::retDat($user);
    }
    /**
     * 禁用用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStop($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->id == 1) {
                $msg = '管理员账户禁止禁用！';
            } else {
                if ($user->delete()) {
                    return back();
                }
            }
        } else {
            $msg = '用户不存在或用户已被禁用！';
        }
        return back()->withErrors($msg ?? '禁用用户失败！');
    }
    /**
     * 恢复用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRecovery($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return back();
        } else {
            $msg = '用户不存在！';
        }
        return back()->withErrors($msg ?? '恢复用户失败！');
    }
    /**
     * 删除用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDestroy($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user && $user->deleted_at) {
            if ($user->id == 1) {
                $msg = '管理员账户禁止删除！';
            } else {
                $user->forceDelete();
                return back();
            }
        } else {
            $msg = '用户不存在或用户正在被使用！';
        }
        return back()->withErrors($msg ?? '删除用户失败！');
    }
}