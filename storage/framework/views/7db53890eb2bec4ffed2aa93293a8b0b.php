<?php $__env->startSection('settings-content'); ?>
<div class="mx-auto max-w-3xl">
  <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-6 py-4">
      <h3 class="text-sm font-bold text-slate-900">Organization Settings</h3>
      <p class="mt-1 text-xs text-slate-500">Update org name and brand colors</p>
    </div>
    <form method="POST" action="<?php echo e(route('settings.update-colors')); ?>" class="space-y-5 p-6">
      <?php echo csrf_field(); ?>
      <div>
        <label for="org_name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Organization Name</label>
        <input type="text" id="org_name" name="org_name" value="<?php echo e($orgName ?? 'iLAP HQ'); ?>" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
      </div>
      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label for="primary_color" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Primary Color</label>
          <div class="flex items-center gap-3">
            <input type="color" id="primary_color" name="primary_color" value="<?php echo e($primaryColor ?? '#1e40af'); ?>" class="h-10 w-14 cursor-pointer rounded-lg border border-slate-200 bg-white p-1">
            <input type="text" value="<?php echo e($primaryColor ?? '#1e40af'); ?>" class="flex-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm uppercase" readonly>
          </div>
        </div>
        <div>
          <label for="secondary_color" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">Secondary Color</label>
          <div class="flex items-center gap-3">
            <input type="color" id="secondary_color" name="secondary_color" value="<?php echo e($secondaryColor ?? '#3b82f6'); ?>" class="h-10 w-14 cursor-pointer rounded-lg border border-slate-200 bg-white p-1">
            <input type="text" value="<?php echo e($secondaryColor ?? '#3b82f6'); ?>" class="flex-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm uppercase" readonly>
          </div>
        </div>
      </div>
      <div class="pt-2">
        <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Save Changes</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('settings.settings-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/settings/index.blade.php ENDPATH**/ ?>