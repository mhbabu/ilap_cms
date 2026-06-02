<?php $__env->startSection('title','Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-bold text-slate-800">Settings</h1>
    <p class="ilap-text-sm text-slate-500">iLAP configuration, templates, system documents and audit log</p>
</div>

<div class="ilap-tabs ilap-mb-6">
    <?php $__currentLoopData = ['settings.index'=>'General','settings.ilap-config'=>'iLAP Config','settings.email-templates'=>'Email Templates','settings.system-documents'=>'System Docs','settings.activity-logs'=>'Audit Log']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($route)); ?>"
           class="ilap-tab <?php echo e(request()->routeIs($route) ? 'ilap-tab--active' : ''); ?>">
            <?php echo e($label); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php echo $__env->yieldContent('settings-content'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/settings/settings-layout.blade.php ENDPATH**/ ?>