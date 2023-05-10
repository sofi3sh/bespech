<?php
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return response()->json($categories, 200); 
    }

}
