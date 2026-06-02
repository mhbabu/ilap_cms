<?php $__env->startSection('title','Documents'); ?>
<?php $__env->startSection('page-title','Documents'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Documents</h1>
        <p class="text-xs text-slate-500"><?php echo e($documents->total() ?? $documents->count()); ?> documents</p>
    </div>
    <a href="<?php echo e(route('documents.create')); ?>"
       class="inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-800">
        + Upload Document
    </a>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">#</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Title</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Type</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Category</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Size</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Uploaded</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
            <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600"><?php echo e($i + 1); ?></td>
                <td class="whitespace-nowrap px-5 py-3 text-sm font-semibold text-slate-800"><?php echo e($doc->title); ?></td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600"><?php echo e($doc->type); ?></td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600"><?php echo e($doc->category ?? '—'); ?></td>
                <td class="whitespace-nowrap px-5 py-3 text-sm text-slate-600"><?php echo e($doc->size_formatted ?? '—'); ?></td>
                <td class="whitespace-nowrap px-5 py-3 text-xs text-slate-400"><?php echo e($doc->created_at?->diffForHumans() ?? '—'); ?></td>
                <td class="flex gap-1 whitespace-nowrap px-5 py-3 text-sm">
                    <a href="<?php echo e(route('documents.download',$doc)); ?>"
                       class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">⬇</a>
                    <button onclick="deleteDoc('<?php echo e($doc->id); ?>')"
                            class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">🗑</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">No documents uploaded yet.</td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 px-5 py-3">
        <?php echo e($documents->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/documents/index.blade.php ENDPATH**/ ?>