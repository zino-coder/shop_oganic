<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService extends BaseService
{
    public function getProducts($request)
    {
        $query = Product::query();

        $query->with([
            'thumbnail',
            'category'
        ]);

        if ($request->cat_filter) {
            $query->whereHas('category', function ($sql) use ($request) {
                return $sql->where('id', $request->cat_filter);
            });
        }

        if ($request->text_search) {
            $query->where('name', 'like', "%$request->text_search%");
        }

        if ($request->sort_key == 'az') {
            $query->orderBy('name', 'ASC');
        }
        if ($request->sort_key == 'za') {
            $query->orderBy('name', 'DESC');
        }
        if ($request->sort_key == 'price_up') {
            $query->orderBy('price', 'ASC');
        }
        if ($request->sort_key == 'price_down') {
            $query->orderBy('price', 'DESC');
        }

        return $query->paginate(10);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'stock' => $request->stock ?? 0,
                'price' => $request->input('price') ?? 0,
                'sale_price' => $request->sale_price ?? 0,
                'category_id' => $request->category_id,
                'is_active' => $request->is_active ? 1 : 0,
                'is_hot' => $request->is_hot ? 1 : 0,
                'is_featured' => $request->is_featured ? 1 : 0,
                'content' => $request->content,
                'description' => $request->description,
            ]);

            if ($request->hasFile('thumbnail')) {
                $fileName = Carbon::now() . '-' . $request->file('thumbnail')->getClientOriginalName();
                Media::create([
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                    'type' => 'thumbnail',
                    'name' => $fileName,
                ]);

                $request->file('thumbnail')->storeAs('public/thumbnail', $fileName);
            }

            if (is_array($request->images)) {
                foreach ($request->images as $image) {
                    $fileName = Carbon::now() . '-' . $image->getClientOriginalName();
                    Media::create([
                        'mediable_type' => Product::class,
                        'mediable_id' => $product->id,
                        'type' => 'images',
                        'name' => $fileName,
                    ]);

                    $image->storeAs('public/images', $fileName);
                }
            }
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);

            Storage::disk('public')->delete('thumbnail/' . $product->thumbnail->name);
            $product->thumbnail->delete();

            if (isset($product->images)) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete('images/' . $image->name);
                    $image->delete();
                }
            }

            $product->delete();
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
