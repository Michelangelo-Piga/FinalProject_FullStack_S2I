<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Email;

class PersonalAreaController extends Controller
{
    public function show($id)
    {
        return User::find($id);
    }
}
