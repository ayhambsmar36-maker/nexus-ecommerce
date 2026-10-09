<?php

namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Services\ProductVariant\VariantGenerate;

class GenerateProductVariants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 60;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(private Product $product) {

    }

    /**
     * Execute the job.
     */
    public function handle(VariantGenerate $service): void {
       $service->generateFor($this->product);
    }
}
