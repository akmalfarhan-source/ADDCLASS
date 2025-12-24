<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // User validation
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // UMKM validation
            'umkm_nama' => ['required', 'string', 'max:255'],
            'umkm_alamat' => ['required', 'string'],
            'umkm_telepon' => ['required', 'string', 'max:20'],
            'umkm_email' => ['nullable', 'email', 'max:255'],
            'umkm_deskripsi' => ['nullable', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Create user with umkm_owner role
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'umkm_owner',
        ]);

        // Create UMKM for this user
        Umkm::create([
            'user_id' => $user->id,
            'nama' => $data['umkm_nama'],
            'alamat' => $data['umkm_alamat'],
            'telepon' => $data['umkm_telepon'],
            'email' => $data['umkm_email'] ?? null,
            'deskripsi' => $data['umkm_deskripsi'] ?? null,
            'is_active' => true,
        ]);

        return $user;
    }
}
