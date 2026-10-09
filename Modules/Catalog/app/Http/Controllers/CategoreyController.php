<?php

namespace Modules\Catalog\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Modules\Catalog\Services\Category\CategoryQueryService;
use Modules\Catalog\Transformers\Category\CategoryResource;
use Illuminate\Http\Request;

class CategoreyController extends Controller
{
    use ApiResponse;
   public function __construct(private CategoryQueryService  $service)
    {
        
    }

    public function index()
    {
        $categorys = $this->service->getTreeCategories();
        return $categorys ? $this->successResponse(CategoryResource::collection($this->service->getTreeCategories()), 'Categories retrieved successfully'):
        $this->successResponse([], 'No categories found',204 );
    }

  
    /**
     * Show the specified resource.
     */
    public function show( int $id)
    {
        $category = $this->service->getCategoryById($id);
        return $category ? $this->successResponse(new CategoryResource($this->service->getCategoryById($id)), 'Category retrieved successfully') : $this->errorResponse('Category not found', 404);
    }

}
