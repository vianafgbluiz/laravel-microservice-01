<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(Category $model)
    {
        $this->repository = $model;
    }

    public function index()
    {
        $categories = $this->repository->get();

        return CategoryResource::collection($categories);
    }

    public function store(StoreUpdateCategoryRequest $request)
    {
        $category = $this->repository->create($request->validated());

        return new CategoryResource($category);
    }

    public function show($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        return new CategoryResource($category);
    }

    public function update(StoreUpdateCategoryRequest $request, $url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function destroy($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->delete();

        return response()->json([], 204);
    }
}
