<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review_details' => 'required|string|max:1000',
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();

        $review = Review::create([
            'review_details' => $request->review_details,
            'product_id' => $request->product_id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.',
            'review' => $review,
        ], 201);
    }

    public function getByProduct($productId)
    {
        $reviews = Review::with([
            'user:id,name',
            'reply.admin:id,name'
        ])
            ->where('product_id', $productId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'product_id' => (int) $productId,
            'reviews' => $reviews,
        ], 200);
    }


    public function index()
    {
        $reviews = Review::with(['product:id,name', 'user:id,name'])->latest()->paginate(10);

        return view('dashboard.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    public function replyToReview(Request $request, $reviewId)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($reviewId);

        $reply = ReviewReply::updateOrCreate(
            ['review_id' => $reviewId],
            ['reply' => $request->reply, 'admin_id' => auth()->id()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Reply saved successfully.',
            'reply' => $reply,
        ]);
    }

}
