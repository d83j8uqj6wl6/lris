<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = Auth::guard()->attempt($credentials)) {
            return response()->json(['error' => '密碼錯誤'], 201);
        }
        return $this->respondWithToken($token);
    }

    /**
     * 註冊使用者
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {

        $rules = [
            'name' => 'required|max:16|alpha_dash',
            'password' => 'required|regex:/[0-9a-zA-Z]{6}/',
            'email' => 'required|email|unique:users',
        ];
        $messages = [
            'name.required' => '用戶名不能為空. ',
            'name.max' => '名稱不能超過 16 個字符. ',
            'name.alpha_dash' => '名稱只有字母數字字符 . ',
            'password.regex' => '密碼應超過 6 個字符且僅 0-9、a-z、A-Z. ',
            'password.required' => '密碼應超過  6 個字符且僅 0-9、a-z、A-Z. ',
            'email.email' => '電子郵件必須是有效的電子郵件地址. ',
            'email.unique' => '電子郵件重複. ',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'error' => $error], 201);
        }


        $name = Arr::get($data, 'name');
        $email = Arr::get($data, 'email');
        $password = Arr::get($data, 'password');

        User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        return response()->json(['status' => true, 'error' => '建立成功'], 200);
    }

    // public function resetpassword123(Request $request)
    // {

    //     $data = $request->all();
    //     $rules = [
    //         'oldpassword'=>'required|between:6,20',
    //         'password'=>'required|between:6,20|confirmed',
    //     ];
    //     $messages = [
    //         'required' => '密碼不為空',
    //         'between' => '密碼必須是6~12之間',
    //         'confirmed' => '新密碼和確認密碼不匹配'
    //     ];
    //     $validator = Validator::make($data, $rules, $messages);
    //     if ($validator->fails()) {
    //         $error = $validator->errors()->first();
    //         return response()->json(['status' => false, 'error' => $error], 400);
    //     }
    //     return response()->json(['status' => true, 'error' => '更新成功'], 200);

    // }

    public function resetpassword(Request $request)
    {
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'password'=>'required|between:6,20',
        ];
        $messages = [
            'required' => '密碼不為空',
            'between' => '密碼必須是6~12之間',
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'error' => $error], 201);
        }
        $user->password = Hash::make($password);
        $user->save();
        Auth::logout();  //更改完这次密码后，退出这个用户
        return response()->json(['status' => true, 'error' => '更新成功'], 200);
    }
    /**
     * Get a authenticated User.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard()->user());
    }

    /**
     * Log the user out(Invalidate the Token).
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard()->logout();
        return response()->json(['message'=>'成功登出']);
    }

    /**
     * 刷新 Token.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard()->refresh());
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            // 'access_token'=>$token,
            'token'=>"bearer $token",
            // 'expires_in'=>Auth::guard()->factory()->getTTL()*60
            
        ]);
    }

}
