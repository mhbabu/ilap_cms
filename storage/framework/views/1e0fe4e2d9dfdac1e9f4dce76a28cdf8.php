<?php $__env->startSection('title', 'Audit Logs'); ?>

<?php $__env->startSection('settings-content'); ?>
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Audit Logs</h1>
    <p class="ilap-text-sm text-slate-500">System activity log for all admin actions.</p>
</div>

<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Activity</th>
                    <th>Causer</th>
                    <th>Subject</th>
                    <th>When</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ilap-text-xs text-slate-500"><?php echo e($logs->firstItem() + $i); ?></td>
                    <td class="ilap-font-semibold text-slate-700"><?php echo e(ucfirst($log->description ?? $log->log_name)); ?></td>
                    <td class="ilap-text-sm"><?php echo e($log->causer?->name ?? 'System'); ?></td>
                    <td class="ilap-text-sm"><?php echo e($log->subject_type); ?> #<?php echo e($log->subject_id); ?></td>
                    <td class="ilap-text-xs text-slate-500"><?php echo e($log->created_at?->diffForHumans() ?? '—'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="ilap-text-center ilap-py-8 text-slate-400">
                        <p class="ilap-text-lg">No activity logs found.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($logs->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('settings.settings-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/settings/activity_logs.blade.php ENDPATH**/ ?>