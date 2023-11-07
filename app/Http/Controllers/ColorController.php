<?php

namespace App\Http\Controllers;

use App\Http\Requests\Color\StoreRequest;
use App\Http\Requests\Color\UpdateRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ColorController extends Controller
{
    protected Color $color;

    /**
     * @param Color $color
     */
    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function listColor()
    {
        return view('admin.color.list');
    }

    public function search(Request $request)
    {
        $colors = $this->color->search($request->name);
        $view = view('admin.color.table', compact('colors'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function showFormCreate()
    {
        return view('admin.color.create');
    }

    public function store(StoreRequest $request)
    {
        $colorData = $this->color->create($request->all());
        return response()->json([
            'data' => $colorData,
            'message' => 'Color Added Successfully.'
        ], Response::HTTP_CREATED);
    }

    public function showFormEdit(string $id)
    {
        $color = $this->color->findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $color = $this->color->findOrFail($id);
        $color->update($request->all());
        return redirect()->route('color.list')->withErrors([
            'success' => 'Color Updated Successfully.'
        ]);
    }

    public function deleteColor(string $id)
    {
        $colorId = $this->color->findOrFail($id);
        $colorId->delete();
        return response()->json([
            'message' => 'Color Deleted Successfully.'
        ], Response::HTTP_OK);
    }
}
