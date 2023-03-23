<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategory();

        return view('admin.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategory = $this->categoryService->getAllParentCategory();

        return view('admin.category.create', compact('parentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->categoryService->store($request);

        return redirect()->route('categories.index')->with('success', 'Create Category Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parentCategory = $this->categoryService->getAllParentCategory();
        $category = $this->categoryService->getCategory($id);

        return view('admin.category.edit', compact('parentCategory', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if ($request->ajax()) {
            $this->categoryService->changeStatus($id, $request);

            return response()->json([
                'success' => 'Change Status Successfully!',
            ]);
        }

        $category = $this->categoryService->update($id, $request);

        if ($category) {
            return redirect()->route('categories.index')->with('success', 'Update Category Successfully!');
        }

        return redirect()->route('categories.index')->withErrors('update', 'Update Failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryService->getCategory($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Delete Category Successfully!');
    }
}
