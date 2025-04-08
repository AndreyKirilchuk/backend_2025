<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('pages.products', compact('products', 'categories'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $v = validator($request->all(), [
            "name" => "required|string|max:20",
            "description" => "nullable|string|max:50",
            "price" => "required|numeric|min:10",
            "preview" => "required|image|mimes:jpeg|max:2048",
            "category_id" => "required|integer|exists:categories,id",
        ]);

        if($v->fails()) return back()->withInput()->withErrors($v);

        $image = $request->preview;

        $image = imagecreatefromjpeg($image);

        $size = 300;
        $width = imagesx($image);
        $height = imagesy($image);

        $scale = min($size / $width, $size / $height);
        $newWidth = (int)($scale * $width);
        $newHeight = (int)($scale * $height);

        $newImg = imagecreatetruecolor($newWidth, $newHeight);

        imagesavealpha($newImg, true);
        imagealphablending($newImg, false);

        $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        imagefill($newImg, 0, 0, $transparent);

        $black = imagecolorallocate($newImg, 0, 0, 0);
        $white = imagecolorallocate($newImg, 255, 255, 255);

        imagecopyresampled($newImg, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        imagefilledrectangle($newImg, 0, $newHeight - 25,  45, $newHeight, $black);
        imagettftext($newImg, 12, 0,  5, $newHeight - 7, $white,  public_path('/assets/fonts/arial.ttf'), 'Shop');

        $path = "previews/" . Str::uuid() . ".png";
        imagepng($newImg, public_path($path));

        $data = $v->validated();
        $data['preview'] = $path;

        Product::create($data);

        return back();
    }

    /**
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showUpdateForm(Product $product)
    {
        $categories = Category::all();
        return view('pages.update-product', compact('product', 'categories'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Product $product)
    {
        $v = validator($request->all(), [
            "name" => "required|string|max:20",
            "description" => "nullable|string|max:50",
            "price" => "required|numeric|min:10",
            "category_id" => "required|integer|exists:categories,id",
            "preview" => "sometimes|image|mimes:jpeg|max:2048"
        ]);

        if($v->fails()) return back()->withInput()->withErrors($v);

        $data = $v->validated();

        $image = $request->preview;

        if($image)
        {
            $image = imagecreatefromjpeg($image);

            $black = imagecolorallocate($image, 0, 0, 0);
            $white = imagecolorallocate($image, 255, 255, 255);

            imagefilledrectangle($image, 20, 20, 100, 50, $black);
            imagettftext($image, 20, 0, 60, 35, $white, public_path('/assets/fonts/arial.ttf'), 'Shop');

            $path = "previews/" . Str::uuid() . ".jpg";
            imagejpeg($image, public_path($path));


            $data['preview'] = $path;
        }

        $product->update($data);

        return back();
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }
}
