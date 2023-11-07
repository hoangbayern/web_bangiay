<?php

namespace App\Http\Controllers;

use App\Http\Requests\Size\StoreRequest;
use App\Http\Requests\Size\UpdateRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SizeController extends Controller
{
    protected Size $size;

    /**
     * @param Size $size
     */
    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function listSize()
    {
        return view('admin.size.list');
    }

    public function search(Request $request)
    {
        $sizes = $this->size->search($request->name);
        $view = view('admin.size.table', compact('sizes'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function showFormCreate()
    {
        return view('admin.size.create');
    }

    public function store(StoreRequest $request)
    {
        $sizeData = $this->size->create($request->all());
        return response()->json([
            'data' => $sizeData,
            'message' => 'Size Added Successfully.',
        ], Response::HTTP_CREATED);
    }

    public function showFormEdit(string $id)
    {
        $size = $this->size->findOrFail($id);
        return view('admin.size.edit', compact('size'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $size = $this->size->findOrFail($id);
        $size->update($request->all());
        return redirect()->route('size.list')->withErrors([
            'success' => 'Size Updated Successfully.'
        ]);
    }

    public function deleteSize(string $id)
    {
        $sizeId = $this->size->findOrFail($id);
        $sizeId->delete();
        return response()->json([
            'message' => 'Size Deleted Successfully.',
        ], Response::HTTP_OK);
    }
}
