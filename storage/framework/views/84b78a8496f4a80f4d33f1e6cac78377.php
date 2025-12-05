<?php $__env->startSection('content'); ?>
<style>
:root {
    --primary: #0066ff;
    --secondary: #667eea;
    --light: #f8f9fa;
    --dark: #1f2937;
    --text-muted: #6b7280;
    --border: #e5e7eb;
}

.blog-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 60px 0;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.blog-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.blog-header .container {
    position: relative;
    z-index: 1;
}

.blog-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.blog-header p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin: 0;
}

.blog-container {
    margin-bottom: 50px;
}

/* Blog Cards */
.blog-posts {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.blog-card {
    background: white;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 102, 255, 0.15);
}

.blog-card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: var(--light);
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-card-image img {
    transform: scale(1.05);
}

.blog-card-image.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 3rem;
}

.blog-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 12px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-card-excerpt {
    font-size: 0.95rem;
    color: var(--text-muted);
    margin-bottom: 16px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.blog-card-date {
    font-size: 0.85rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

.blog-card-date::before {
    content: '📅';
    font-size: 1rem;
}

.blog-card-link {
    color: var(--primary);
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
}

.blog-card:hover .blog-card-link {
    gap: 10px;
}

.blog-card-link::after {
    content: '→';
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-muted);
    font-size: 1rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid var(--border);
}

.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    display: flex;
}

.pagination a,
.pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 6px;
    border: 1px solid var(--border);
    color: var(--dark);
    text-decoration: none;
    transition: all 0.2s;
    font-weight: 500;
    font-size: 0.95rem;
}

.pagination a:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.pagination .active span {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.pagination .disabled span {
    color: var(--border);
    cursor: not-allowed;
}

.pagination li:first-child a,
.pagination li:last-child a {
    width: auto;
    padding: 0 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .blog-header {
        padding: 40px 0;
    }

    .blog-header h1 {
        font-size: 2rem;
    }

    .blog-header p {
        font-size: 1rem;
    }

    .blog-posts {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .pagination a,
    .pagination span {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .blog-header h1 {
        font-size: 1.5rem;
    }

    .blog-card-body {
        padding: 16px;
    }

    .pagination a,
    .pagination span {
        width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
}
</style>

<!-- Blog Header -->
<div class="blog-header">
    <div class="container">
        <h1>Tin Tức & Bài Viết</h1>
        <p>Cập nhật những thông tin mới nhất về công nghệ và mobile</p>
    </div>
</div>

<!-- Blog Content -->
<div class="blog-container">
    <div class="container">
        <?php if($posts->count() > 0): ?>
            <!-- Blog Cards Grid -->
            <div class="blog-posts">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="blog-card">
                        <div class="blog-card-image <?php if(!$post->featured_image): ?> no-image <?php endif; ?>">
                            <?php if($post->featured_image): ?>
                                <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" alt="<?php echo e($post->title); ?>">
                            <?php else: ?>
                                <span>📰</span>
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-body">
                            <h3 class="blog-card-title"><?php echo e($post->title); ?></h3>
                            <p class="blog-card-excerpt"><?php echo e(Str::limit($post->excerpt ?? $post->content, 100)); ?></p>
                            <div class="blog-card-meta">
                                <span class="blog-card-date"><?php echo e($post->published_at->format('d/m/Y')); ?></span>
                                <span class="blog-card-link"></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->hasPages()): ?>
            <div class="pagination-wrapper">
                <?php echo e($posts->links()); ?>

            </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <h3>Chưa có bài viết nào</h3>
                <p>Vui lòng quay lại sau để xem những bài viết mới nhất</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/blog/index.blade.php ENDPATH**/ ?>