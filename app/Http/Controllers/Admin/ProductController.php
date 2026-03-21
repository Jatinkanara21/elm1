<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with("category")->paginate(10);
        return view("admin.products.index", compact("products"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.products.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "category_id" => "required|exists:categories,id",
            "price" => "required|numeric",
            "stock" => "required|integer",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:20480",
            "brand" => "nullable|string"
        ]);

        $data = $request->except("image");
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("products", "public");
        }

        $product = Product::create($data);

        // Notify Customers
        $users = \App\Models\User::where('is_admin', 0)->get();
        foreach ($users as $user) {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\NewProductMail($product));
        }

        return redirect()->route("admin.products.index")->with("success", "Product created and notifications sent.");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view("admin.products.edit", compact("product", "categories"));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "category_id" => "required|exists:categories,id",
            "price" => "required|numeric",
            "stock" => "required|integer",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:20480"
        ]);

        $data = $request->except("image");
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("products", "public");
        }

        $oldStock = $product->stock;
        $product->update($data);

        // Notify Wishlist owners if Restored (Replenished from 0)
        if ($oldStock == 0 && $product->stock > 0) {
            $wishlists = \App\Models\Wishlist::where('product_id', $product->id)->with('user')->get();
            foreach ($wishlists as $wishlist) {
                if ($wishlist->user) {
                    \Illuminate\Support\Facades\Mail::to($wishlist->user->email)->send(new \App\Mail\ProductBackInStockMail($product));
                }
            }
        }

        return redirect()->route("admin.products.index")->with("success", "Product updated.");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("admin.products.index")->with("success", "Product deleted.");
    }
}
