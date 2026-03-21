<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "product_id" => "required|exists:products,id",
            "rating" => "required|integer|min:1|max:5",
            "comment" => "required|string"
        ]);

        Review::create([
            "user_id" => auth()->id(),
            "product_id" => $request->product_id,
            "rating" => $request->rating,
            "comment" => $request->comment,
            "is_approved" => 1
        ]);

        return back()->with("success", "Review submitted successfully.");
    }
}
