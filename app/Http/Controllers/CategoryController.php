<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
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
        return view('admin.category.list');
    }

    public function search(Request $request)
    {
        $categories = $this->category->search($request->name);
        $view = view('admin.category.table', compact('categories'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function showFormEdit(string $id)
    {
        $category = $this->category->findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $categoryId = $this->category->findOrFail($id);
        $categoryId->update($request->all());
        return redirect()->route('category.list')->withErrors([
           'success' => 'Updated Category Successfully.'
        ]);
    }

    public function deleteCategory(string $id)
    {
        $categoryId = $this->category->findOrFail($id);
        $categoryId->delete();
        return response()->json([
            'message' => 'Deleted Category Successfully.'
        ], Response::HTTP_OK);
    }
}
