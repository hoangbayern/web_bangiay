<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    protected ProductRating $productRating;

    /**
     * @param ProductRating $productRating
     */
    public function __construct(ProductRating $productRating)
    {
        $this->productRating = $productRating;
    }

    public function listReview()
    {
        return view('admin.review.list');
    }

    public function search(Request $request)
    {
        $reviews = $this->productRating->search($request->name);
        $view = view('admin.review.table', compact('reviews'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function detail(string $id)
    {
        $review = $this->productRating->findOrFail($id);
        return view('admin.review.detail', compact('review'));
    }

    public function changeOrderStatus(string $id, Request $request)
    {
        $review = $this->productRating->findOrFail($id);
        $review->status = $request->status;
        $review->save();

        session()->flash('success', 'Status Updated Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Updated Status Successfully.',
        ]);
    }
}
