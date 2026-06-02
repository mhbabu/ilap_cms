<!-- Set dynamic heading per branch -->
<?php $orgColor = $campus?->color_primary ?? ''; ?>

<?php $__env->startSection('title','Campuses'); ?>
<?php $__env->startSection('page-title','Branches Overview'); ?>
<?php $__env->startSection('content'); ?>

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">
            Branch Overview
        </h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">
            All iLAP branches — active campus or hub status. Click any branch to open details.
        </p>
    </div>
    <a href="<?php echo e(route('campuses.create')); ?>"
       class="ilap-p-2.5 px-5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Add Branch</a>
</div>


<div class="ilap-grid-3 ilap-mb-6">
    <?php $__empty_1 = true; $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php $cColor = $campus->color_primary ?? 'var(--ilap-primary)' ?>
    <div class="ilap-card ilap-relative overflow-hidden hover:shadow-xl transition-all">

        
        <div class="h-1.5" style="background:<?php echo e($cColor); ?>"></div>

        <div class="ilap-p-5">
            <?php if($campus->logo): ?>
            <div class="ilap-mb-4">
                <img src="<?php echo e($campus->logo); ?>" alt="<?php echo e($campus->name); ?>"
                     style="height:2rem">
            </div>
            <?php endif; ?>

            <div class="ilap-flex items-center justify-between ilap-mb-3">
                <h2 class="ilap-text-lg ilap-font-bold text-slate-800"><?php echo e($campus->name); ?></h2>
                <div class="w-3 h-3 rounded-full" style="background:<?php echo e($cColor); ?>"></div>
            </div>

            <p class="ilap-text-xs text-slate-500 ilap-mb-4">
                ID: <?php echo e($campus->id); ?> | UP: <?php echo e($campus->id % 2 == 0 ? 'Passed' : 'Active'); ?>

                <br>Campus ID: <?php echo e($campus->up_or_down); ?> | <?php echo e($campus->id); ?> | <?php echo e($campus->id); ?>

            </p>

            
            <div class="ilap-grid ilap-grid-2 gap-2 ilap-mb-4">
                <div class="ilap-p-3 rounded-xl" style="background:<?php echo e($cColor); ?>08;border-left:3px solid <?php echo e($cColor); ?>">
                    <p class="ilap-text-2xs text-slate-500 uppercase">Students</p>
                    <p class="ilap-text-xl ilap-font-extrabold" style="color:<?php echo e($cColor); ?>">
                        <?php echo e(number_format(($campus->students ?? collect())->count() ?? $campus->enrollments ?? 0)); ?>

                    </p>
                </div>
                <div class="ilap-p-3 rounded-xl" style="background:var(--ilap-primary-light);border-left:3px solid var(--ilap-primary)">
                    <p class="ilap-text-2xs text-slate-500 uppercase">Payments</p>
                    <p class="ilap-text-xl ilap-font-extrabold" style="color:var(--ilap-secondary)">
                        <?php echo e(number_format(rand(5,60))); ?>

                    </p>
                </div>
            </div>

            <div class="ilap-flex items-center justify-between">
                <a href="<?php echo e(route('campuses.show',$campus)); ?>" class="ilap-text-sm font-bold hover:underline"
                   style="color:<?php echo e($cColor); ?>">Open Branch Admin →</a>
                <span class="ilap-badge ilap-badge--gray"><?php echo e($campus->unique_code ?? '—'); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="ilap-metric ilap-col-span-3 ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No campuses setup yet.</p>
        <a href="<?php echo e(route('campuses.create')); ?>" class="ilap-btn ilap-btn-primary ilap-mt-3">
            + First Branch Setup
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/campus/index.blade.php ENDPATH**/ ?>