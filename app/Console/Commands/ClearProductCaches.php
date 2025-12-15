<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class ClearProductCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:products {--all : Clear all product-related caches}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Clear product-related caches for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            CacheService::clearProductCaches();
            $this->info('✓ Tất cả caches sản phẩm đã được xóa');
        } else {
            \Illuminate\Support\Facades\Cache::forget('categories:all');
            \Illuminate\Support\Facades\Cache::forget('brands:all');
            $this->info('✓ Đã xóa caches categories và brands');
        }
    }
}
