<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 
            'email', 
            'password',
            'perfil'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        public function funcionario() 
        {
           return $this->hasOne(Funcionario::class,'usuario_id');
        }

        public function empresa() 
        {
            return $this->hasOne(Empresa::class,'usuario_id');
        }

        public function interesses()
        {
            return $this->hasMany(Interesse::class,'usuario_id');
        }

        public function getJWTIdentifier(){
            return $this->getKey();
        }
        public function getJWTCustomClaims(){
            return [];
        }
    }