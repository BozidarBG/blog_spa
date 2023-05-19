<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;


class AdminGenreController extends Controller
{
    public function store(GenreRequest $request)
    {
        $genre=new Genre();
        $genre->name=$request->name;
        $genre->description=$request->description;
        $genre->save();

        return successResponse([], 201);
    }

    public function update(Request $request, $id)
    {
        $genre=Genre::find($id);

        if(!$genre){
            return errorResponse(['errors'=>['Requested genre is not found!']],404);
        }

        $this->validate($request, [
            'name'=>['required','string','min:2','max:255',Rule::unique('genres', 'name')->ignore($genre->id)],
            'description'=>'required|string|min:2',
        ]);

        $genre->name=$request->name;
        $genre->description=$request->description;
        $genre->save();

        return successResponse([], 200);
    }

    public function destroy($id)
    {
        $genre=Genre::find($id);

        if(!$genre){
            return errorResponse(['errors'=>['Requested genre is not found!']],404);
        }
        //lets not delete articles if genre is deleted, but just relationship
        foreach($genre->articles as $article){
            $article->pivot->delete();
        }
        $genre->delete();

        return successResponse([],200);
    }

}

