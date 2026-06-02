<?php $__env->startSection('title', $lead->name); ?>
<?php $__env->startSection('page-title', $lead->name .' — Lead Detail'); ?>

<?php $__env->startSection('content'); ?>

<div class="ilap-card ilap-p-6">
    <div class="ilap-flex items-start justify-between ilap-mb-6">
        <div>
            <h1 class="ilap-text-2xl ilap-font-extrabold text-slate-800"><?php echo e($lead->name); ?></h1>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1">Lead #<?php echo e($lead->id); ?>

                <?php if($lead->is_flag): ?> &middot; <span class="ilap-pill" style="background:#fee2e2;color:#991b1b">Flagged</span> <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('leads.index')); ?>" class="ilap-btn ilap-btn-secondary">← Back</a>
    </div>

    <div class="ilap-grid-3 ilap-mb-6">
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Phone</p>
                <p class="ilap-text-lg ilap-font-bold" style="color:var(--ilap-primary)"><?php echo e($lead->phone ?? '—'); ?></p>
            </div>
        </div>
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Email</p>
                <p class="ilap-text-lg ilap-font-bold text-slate-800"><?php echo e($lead->email ?? '—'); ?></p>
            </div>
        </div>
        <div class="ilap-card">
            <div class="ilap-p-4">
                <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-1">Status</p>
                <span class="ilap-badge ilap-badge--<?php echo e($lead->status === 'converted' ? 'green' : 'blue'); ?> ilap-text-lg">
                    <?php echo e(ucfirst($lead->status)); ?>

                </span>
            </div>
        </div>
    </div>

    <div class="ilap-card ilap-mb-6 ilap-p-5">
        <p class="ilap-text-xs text-slate-500 uppercase ilap-mb-2 ilap-font-bold">Source</p>
        <span class="ilap-badge ilap-badge--blue"><?php echo e($lead->source); ?></span>
        <?php if($lead->notes): ?><p class="ilap-mt-3 ilap-text-sm text-slate-600"><?php echo e($lead->notes); ?></p><?php endif; ?>
    </div>

    <div class="ilap-flex gap-3">
        <?php if($lead->status !== 'converted'): ?>
        <form action="<?php echo e(route('leads.convert',$lead)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="ilap-btn ilap-btn-success"
                    onclick="return confirm('Convert this lead to a student?')">
                Convert → Student
            </button>
        </form>
        <?php endif; ?>

        <a href="<?php echo e(route('students.create')); ?>" class="ilap-btn ilap-btn-secondary">Still No Update?</a>

        <form action="<?php echo e(route('leads.destroy',$lead)); ?>" method="POST" class="inline"
              onsubmit="return confirm('Delete this lead?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="ilap-btn ilap-btn-danger">Delete Lead</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/leads/show.blade.php ENDPATH**/ ?>