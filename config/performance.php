<?php

/**
 * Performance Configuration
 * Handles caching, optimization settings
 */

return [
    // Cache duration in seconds
    'cache_duration' => env('CACHE_DURATION', 3600),

    // Enable/disable caching
    'enable_caching' => env('ENABLE_CACHING', true),

    // Products per page
    'products_per_page' => 12,

    // Orders per page
    'orders_per_page' => 20,

    // Reviews per page
    'reviews_per_page' => 5,

    // Image sizes for optimization (width x height)
    'image_sizes' => [
        'thumb' => '150x150',
        'medium' => '500x500',
        'large' => '800x800',
    ],

    // Rate limiting
    'rate_limit' => [
        'payment_attempts' => 5,   // per minute
        'coupon_attempts' => 10,   // per minute
        'search_attempts' => 30,   // per minute
    ],

    // Enable/disable features
    'features' => [
        'newsletter' => true,
        'user_addresses' => true,
        'advanced_search' => true,
        'product_reviews' => true,
        'wishlist' => true,
    ],
];
