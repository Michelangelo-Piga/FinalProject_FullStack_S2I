<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if($user){
            $response['status'] = 0;
            $response['message'] = 'Email Already Exists';
            $response['code'] = 409;
        }else{
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' =>$request->password,
            ]);
    
            $response['status'] = 1;
            $response['message'] = 'User Registered Successfully';
            $response['code'] = 200;
        }

        
        return response()->json($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }

//CONTROLO QUERY PER LA PASSWORD PURE
    public function checkUserExists(Request $request)
    {
        // $hash = DB::select("
        //     select password from users where email= '{$request->email}'
        // ");

        // var_dump($hash);
        // && password_verify($request->password, $hash)

        $idUser = DB::select("select id, username from users where email= '{$request->email}' and password= '{$request->password}'");
        
        if (DB::select("select * from users where email= '{$request->email}' and password= '{$request->password}'") == null ) {
            return false;
        } else {

            return [true, $idUser];
        }
    }

}
