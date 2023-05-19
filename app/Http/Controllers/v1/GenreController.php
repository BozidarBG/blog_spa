<?php

namespace App\Http\Controllers\v1;

use App\Http\Resources\v1\GenreResource;
use App\Models\Genre;
use App\Http\Resources\v1\GenreCollection;
use App\Http\Controllers\Controller;


class GenreController extends Controller
{

    public function index()
    {
        $genres=Genre::withCount(['articles'])->get();
        return successResponse(new GenreCollection($genres), 200);
    }

    public function show($id)
    {
        $genre=Genre::where('id', $id)->withCount(['articles'])->first();
        if(!$genre){
            return errorResponse(['genre'=>['This genre does not exist']], 404);


        }
        return successResponse(new GenreResource($genre), 200);

    }




}
