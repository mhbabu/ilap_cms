<?php $__env->startSection('title', 'Leads'); ?>
<?php $__env->startSection('page-title', 'Lead Management'); ?>
<?php $__env->startSection('content'); ?>

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Leads</h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">
            Total: <strong><?php echo e(number_format($campusTotal ?? ($leads->total() ?? 0))); ?></strong>
            leads currently above 70% conversion
        </p>
    </div>
    <a href="<?php echo e(route('leads.create')); ?>" class="ilap-btn ilap-btn-primary ilap-px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-md"
       style="background:var(--ilap-primary)">+ New Lead</a>
</div>


<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <p class="ilap-metric__label">Total Leads</p>
        <p class="ilap-metric__value"><?php echo e(number_format($campusTotal ?? ($leads->total() ?? 0))); ?></p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Converted</p>
        <p class="ilap-metric__value" style="color:#16a34a"><?php echo e(number_format($leads->where('status','converted')->count())); ?></p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Pending</p>
        <p class="ilap-metric__value" style="color:#d97706"><?php echo e(number_format($leads->whereIn('status',['new','contacted'])->count())); ?></p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Flagged</p>
        <p class="ilap-metric__value" style="color:#dc2626"><?php echo e(number_format($leads->where('is_flag',true)->count())); ?></p>
    </div>
</div>


<div class="ilap-grid-3">
    <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="ilap-card hover:shadow-lg transition-shadow duration-200 <?php echo e($lead->is_flag ? 'border-l-4 border-red-500' : ''); ?>">
        <div class="ilap-card-header ilap-flex items-center justify-between">
            <div class="ilap-flex items-center gap-2">
                <?php if($lead->is_flag): ?>
                    <span class="ilap-pill" style="background:#fee2e2;color:#991b1b">⚠ Flagged</span>
                <?php endif; ?>
                <span class="ilap-badge ilap-badge--<?php echo e($lead->status==='converted'?'green':($lead->status==='contacted'?'yellow':'gray')); ?>">
                    <?php echo e(ucfirst($lead->status)); ?>

                </span>
            </div>
        </div>
        <div class="ilap-p-4">
            <h3 class="ilap-font-bold text-slate-800"><?php echo e($lead->name ?? 'Anonymous Lead'); ?></h3>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1"><?php echo e($lead->phone); ?></p>
            <?php if($lead->email): ?> <p class="ilap-text-xs text-slate-400"><?php echo e($lead->email); ?></p> <?php endif; ?>

            <?php if($lead->source): ?>
            <p class="ilap-text-xs text-slate-400 ilap-mt-2">Source: <?php echo e(ucfirst($lead->source)); ?></p>
            <?php endif; ?>

            <div class="ilap-flex items-center gap-2 ilap-mt-3">
                <a href="<?php echo e(route('leads.show',$lead)); ?>" class="ilap-btn ilap-btn-secondary ilap-btn-sm">View</a>
                <?php if(!$lead->handler_id): ?>
                    <a href="<?php echo e(route('leads.edit',$lead)); ?>" class="ilap-btn ilap-btn-sm" style="background:var(--ilap-primary-light);color:var(--ilap-primary)">Assign</a>
                <?php endif; ?>
                <?php if($lead->status !== 'converted'): ?>
                    <form action="<?php echo e(route('leads.convert',$lead)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="ilap-btn ilap-btn-success ilap-btn-sm"
                                onclick="return confirm('Convert this lead to student?')">
                            Convert → Student
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="ilap-metric ilap-col-span-full ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No leads yet.</p>
        <p class="ilap-text-sm text-slate-500 ilap-mt-2">Create your first lead to get started.</p>
    </div>
    <?php endif; ?>
</div>

<?php echo e($leads->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/leads/index.blade.php ENDPATH**/ ?>