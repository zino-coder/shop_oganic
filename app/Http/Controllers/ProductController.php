<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Enums\SortTypeEnum;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $childrenCate = $this->categoryService->getChildrenCategories();
        $products = $this->productService->getProducts($request);

        return view('admin.product.index',
            [
                'products' => $products,
                'childrenCat' => $childrenCate,
                'catSelected' => $request->cat_filter,
                'textSearch' => $request->text_search,
                'sortKey' => $request->sort_key,
                'sortType' => SortTypeEnum::getSortType(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $childrenCategories = $this->categoryService->getChildrenCategories();

        return view('admin.product.create', ['childrenCategories' => $childrenCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->productService->store($request);

        return redirect()->route('products.index')->with('success', 'Store Product Successfully!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->productService->delete($id);

        if (!$delete) {
            return redirect()->route('products.index')->with('success', 'Delete Product Fail!');
        }

        return redirect()->route('products.index')->with('success', 'Delete Product Successfully!');
    }
}
