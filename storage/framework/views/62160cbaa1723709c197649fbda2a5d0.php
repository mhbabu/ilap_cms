<?php $__env->startSection('title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-6">
  <div class="ilap-page-header">
    <div>
      <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Settings</h1>
      <p class="ilap-text-sm text-slate-500">Manage general, iLAP, templates, docs and audit settings</p>
    </div>
  </div>

  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50">
      <nav class="flex gap-1 px-2 pt-2 overflow-x-auto">
        <?php $__currentLoopData = ['settings.index'=>'General','settings.ilap-config'=>'iLAP Config','settings.email-templates'=>'Email Templates','settings.system-documents'=>'System Docs','settings.activity-logs'=>'Audit Log']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route($route)); ?>"
             class="px-4 py-2.5 text-sm font-semibold whitespace-nowrap rounded-t-md transition-colors
                    <?php echo e(request()->routeIs($route) ? 'bg-white text-slate-900 border-b-2 border-slate-900 -mb-px' : 'text-slate-600 hover:text-slate-800'); ?>">
            <?php echo e($label); ?>

          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </nav>
    </div>

    <div class="p-6">
      <?php echo $__env->yieldContent('settings-content'); ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/settings/settings-layout.blade.php ENDPATH**/ ?>