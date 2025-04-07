<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $categories = Category::query()->paginate(5);

        return view('pages.categories', compact('categories'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showUpdateForm(Category $category)
    {
        return view('pages.update-category', compact('category'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $v = validator($request->all(), [
            "name" => "required|string|max:15",
            "description" => "nullable|string|max:50",
        ]);

        if($v->fails()) return back()->withInput()->withErrors($v);

        Category::create($v->validated());

        return back();
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $v = validator($request->all(), [
            "name" => "required|string|max:15",
            "description" => "nullable|string|max:50",
        ]);

        if($v->fails()) return back()->withInput()->withErrors($v);

        $category->update($v->validated());

        return back();
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Request $request, Category $category)
    {
        if($category->products()->count() > 0) return back();

        $category->delete();

        return back();
    }
}
