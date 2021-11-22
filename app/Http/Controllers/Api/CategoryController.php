<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao listar categorias',
            'data' => [
                'categories' => CategoryResource::collection($categories)
            ]
        );

        return response()->json($data);
    }

    public function store(StoreUpdateCategoryRequest $request)
    {

        $category = $this->repository->create($request->validated());

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao adicionar categoria',
            'data' => [
                'category' => new CategoryResource($category)
            ]
        );

        return response()->json($data, 200);
    }

    public function show($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao exibir categoria',
            'data' => [
                'category' => new CategoryResource($category)
            ]
        );

        return response()->json($data, 200);
    }

    public function update(StoreUpdateCategoryRequest $request, $url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->update($request->validated());

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao atualizar categoria'
        );

        return response()->json($data, 200);
    }

    public function destroy($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->delete();

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao remover a categoria'
        );

        return response()->json($data, 200);
    }
}
