<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\Api\CategoryCollection;
use App\Http\Resources\Api\CategoryResource;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('filter')->paginate();
        return CategoryResource::collection($categories) ;
    }


    public function detail($id)
    {
        $categories = Category::findOrFail($id) ->load('filter');
        return (new CategoryResource($categories)) ;
    }
}
