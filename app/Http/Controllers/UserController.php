<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Service\InteresseService;
    use App\Http\Service\UserService;
    use Exception;

    class UserController extends Controller
    {
        private $usuarioService;
        public function __construct()  {
                $this->usuarioService = new UserService();
            }    
        public function autenticar(Request $request)
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
        public function cadastrar(Request $request)
        {
                DB::beginTransaction();
                try {                       
                        $this->usuarioService->validarCamposObrigatorioCadastrar($request);
                        $user = $this->usuarioService->salvar($request);       
                        $interesseService = new InteresseService();                        
                        $interesseService->salvar($user);                       
                        $token = JWTAuth::fromUser($user);                        
                } catch (Exception $exception) {
                        DB::rollBack();
                        return response()->json(['mensagem'=> $exception->getMessage()],500);
                }
                DB::commit();
                return response()->json(compact('user','token'),201);
        }
        public function atualizar(Request $request)
        {
                try {
                        $this->usuarioService->validarCamposObrigatorioAtualizar($request);
                        $this->usuarioService->atualizar($request);                       
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