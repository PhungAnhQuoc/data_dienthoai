<?php

if (!function_exists('optimized_image')) {
    /**
     * Generate optimized image URL with size parameter
     * 
     * @param string $path Image path
     * @param string $size Size: 'thumb' (150x150), 'medium' (500x500), 'large' (800x800)
     * @param bool $webp Use WebP format if available
     * @return string
     */
    function optimized_image($path, $size = 'medium', $webp = true)
    {
        if (!$path) {
            return asset('images/no-image.png');
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $path_without_ext = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);

        // Check if WebP version exists
        if ($webp && file_exists(public_path("storage/{$path_without_ext}-{$size}.webp"))) {
            return asset("storage/{$path_without_ext}-{$size}.webp");
        }

        // Return resized version
        if (file_exists(public_path("storage/{$path_without_ext}-{$size}.{$extension}"))) {
            return asset("storage/{$path_without_ext}-{$size}.{$extension}");
        }

        // Return original if resized doesn't exist
        return asset("storage/{$path}");
    }
}

if (!function_exists('image_srcset')) {
    /**
     * Generate srcset for responsive images
     * 
     * @param string $path Image path
     * @return string
     */
    function image_srcset($path)
    {
        $thumb = optimized_image($path, 'thumb');
        $medium = optimized_image($path, 'medium');
        $large = optimized_image($path, 'large');

        return "{$thumb} 150w, {$medium} 500w, {$large} 800w";
    }
}

if (!function_exists('image_sizes')) {
    /**
     * Generate sizes attribute for responsive images
     * 
     * @return string
     */
    function image_sizes()
    {
        return "(max-width: 600px) 100vw, (max-width: 1200px) 50vw, 33vw";
    }
}
