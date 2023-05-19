<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;


class AdminUserController extends Controller
{
    public function index(Request $request){


        $per_page=10;

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page=$request->per_page;
        }

        $users=User::withCount(['banned', 'articles', 'comments'])->paginate($per_page);



        return successResponse($users, 200);
    }
}
