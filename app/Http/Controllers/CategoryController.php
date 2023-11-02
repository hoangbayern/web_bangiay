<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected Category $category;

    /**
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(StoreRequest $request)
    {
        $category = $this->category->create($request->all());
        return response()->json([
            'data' => $category,
            'message' => 'The category has been created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function listCategory()
    {
        $categories = $this->category->latest()->paginate(10);
        return view('admin.category.list', compact('categories'));
    }
}
