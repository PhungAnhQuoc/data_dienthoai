<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class PaginationService
{
    /**
     * Apply pagination and field limiting to query
     */
    public static function paginate($query, $perPage = 15, $page = null, $fields = null)
    {
        // Limit fields if specified
        if ($fields) {
            $query->select($fields);
        }

        // Apply pagination
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Get pagination metadata
     */
    public static function getMeta($paginated)
    {
        return [
            'current_page' => $paginated->currentPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
            'last_page' => $paginated->lastPage(),
            'has_more' => $paginated->hasMorePages(),
        ];
    }
}
