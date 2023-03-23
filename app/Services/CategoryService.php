<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryService extends BaseService
{
    public function getAllCategory()
    {
        return Category::with(['parentCategory'])->paginate(3);
    }

    function getAllParentCategory()
    {
        return Category::where('parent_id', 0)->get();
    }

    public function store($request)
    {
        $category = Category::create([
            'name' => $request->name ?? '',
            'slug' => Str::slug($request->name),
            'is_active' => $request->is_active ? 1 : 0,
            'parent_id' => $request->parent_id,
        ]);

        return $category;
    }

    public function getCategory($id)
    {
        return Category::where('id', $id)->first();
    }

    public function update($id, $request)
    {
        $category = Category::find($id);

        try {
            DB::beginTransaction();
            $category->update([
                'name' => $request->name ?? '',
                'slug' => Str::slug($request->name),
                'is_active' => $request->is_active ? 1 : 0,
                'parent_id' => $request->parent_id,
            ]);
            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public function changeStatus($id, $request)
    {
        $category = Category::find($id);

        $category->update([
            'is_active' => $request->is_active ? 1 : 0,
        ]);

        return true;
    }
}
