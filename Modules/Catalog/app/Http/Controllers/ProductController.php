<?php

namespace Modules\Catalog\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Modules\Catalog\Transformers\ProductResource;
use Modules\Catalog\Services\Product\ProductQueryService;
use Modules\Catalog\Transformers\ProductVariantResource;
use Modules\Catalog\Services\ProductVariant\ProductVariantQueryService;

class ProductController extends Controller
{
    use ApiResponse;
   public function __construct(private ProductQueryService  $productService ,private ProductVariantQueryService $variantService)
    {
        
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return $products ? $this->successResponse(ProductResource::collection($this->productService->getAllProducts()), 'Products retrieved successfully') : $this->successResponse([], 'No products found', 204);
    }

  
    /**
     * Show the specified resource.
     */
    public function show(int $id)
    {
        $product=$this->variantService->getProductById($id);

        return $product ? $this->successResponse(new ProductResource($this->variantService->getProductById($id)), 'Product retrieved successfully') : $this->errorResponse( 'Product not found', 404);
    }
}
