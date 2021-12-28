<?php
namespace App\Services;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserServices {
    public function getById($id): User {
        $user = User::find($id);
        if(!$user){
            throw new NotFoundHttpException('User tidak ditemukan');
        }
        return $user;
    }

    public function getByEmail(string $email): User {
        $user =  User::where('email', $email)->first();
        if(!$user){
            throw new NotFoundHttpException('Email belum terdaftar');
        }
        return $user;
    }

    public function getAll() {
        return User::all();
    }

    public function add(array $user){
        $user = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => bcrypt($user['password'])
        ];
        $user = User::create($user);
        return $user;
    }

}