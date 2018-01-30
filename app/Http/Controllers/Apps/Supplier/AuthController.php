<?php

namespace App\Http\Controllers\Apps\Supplier;

use App\Models\Supplier;
use Curl\Curl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 验证规则，由于业务需求，这里我更改了一下登录的用户名，使用手机号码登录
        $rules = [
            'mobile'   => [
                'required',
                'exists:users',
            ],
            'password' => 'required|string|min:6|max:20'
        ];

        // 验证参数，如果验证失败，则会抛出 ValidationException 的异常
        $params = $this->validate($request, $rules);

        if (app()->isLocal()) {
            if ($token = Auth::guard('supplier')->attempt($params)) {
                // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token
                return response(['token' => 'bearer ' . $token, 'ttl' => env('JWT_TTL', 60)], 201);
            }

            // 如果登录失败则返回
            return response(['error' => '账号或密码错误'], 400);
        }

        // 用微信AuthCode换取open_id、session_key
        $wxCode = $request->get('wx_code');
        $curl = new Curl();
        $appId = env('WX_MINI_APP_ID');
        $appSecret = env('WX_MINI_APP_SECRET');
        $curl->get('https://api.weixin.qq.com/sns/jscode2session?appid=' . $appId . '&secret=' . $appSecret .
            '&js_code=' . $wxCode . '&grant_type=authorization_code');
        $wxRet = json_decode($curl->response);
        if (isset($wxRet->openid) && $wxRet->openid && isset($wxRet->session_key) && $wxRet->session_key &&
            ($token = Auth::guard('supplier')->attempt($params))) {
            \DB::table('sc_supplier')
                ->where('mobile', $request->get('mobile'))
                ->update([
                    'openid' => $wxRet->openid
                ]);
            // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token
            return response(['token' => 'bearer ' . $token, 'ttl' => env('JWT_TTL', 60)], 201);
        }

        // 如果登录失败则返回
        return response(['error' => '账号或密码错误'], 400);
    }

    /**
     * 处理用户登出逻辑
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        \auth('supplier')->logout();

        return response(['message' => '退出成功']);
    }

    /**
     * 获得当前供应商信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getSupplier(Request $request)
    {
        $supplier = $request->user('supplier');

        return response($supplier, 200);
    }
}
