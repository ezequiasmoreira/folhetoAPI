<?php

    namespace App\Http\Controllers;

    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Service\InteresseService;
    use App\Http\Service\UserService;
    use Exception;

    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }
        /*{
                "name": "Test Man"
                "email": "test@email.com"
                "password": "secret"
                "password_confirmation": "secret"
        }
         */
        public function cadastrar(Request $request)
        {
                try {
                        $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6|confirmed',
                        ]);

                        if($validator->fails()){
                                return response()->json($validator->errors()->toJson(), 400);
                        }
                        $user = User::create([
                                'name' => $request->get('name'),
                                'email' => $request->get('email'),
                                'password' => Hash::make($request->get('password')),
                                'perfil' => $request->get('perfil') ? $request->get('perfil') : 'usuario',
                        ]);

                        $interesseService = new InteresseService();                        
                        $interesseService->salvar($user);                       
                        $token = JWTAuth::fromUser($user);

                        return response()->json(compact('user','token'),201);
                } catch (Exception $e) {
                        return response()->json(['mensagem'=> $e->getMessage()],500);
                }
        }
        public function atualizar(Request $request)
        {
                try {
                        $userService = new UserService();
                        $validator = Validator::make($request->all(), [
                                'id' =>  'required',
                                'name' => 'required|string|max:255'
                        ]);

                        if($validator->fails()){
                                return response()->json($validator->errors()->toJson(), 400);
                        }
                        $userService->atualizar($request);                       
                } catch (Exception $e) {
                        return response()->json(['mensagem'=> $e->getMessage()],500);
                }
               return response()->json(['mensagem'=> 'Atualizado com sucesso'],200);
        }

        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }
    }