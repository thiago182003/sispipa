<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class IndicadoresController extends Controller
{
    public function totalmilitares(){
        return User::where('level','>','0')->count();
    }
}
