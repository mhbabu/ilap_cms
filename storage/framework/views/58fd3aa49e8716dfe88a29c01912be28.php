<?php $__env->startSection('title', 'Students'); ?>
<?php $__env->startSection('page-title', 'Students'); ?>

<?php $__env->startSection('content'); ?>
<div class="ilap-page-header ilap-flex flex-wrap items-center justify-between gap-3">
    <div></div>
    <div class="ilap-flex items-center gap-2 flex-wrap">
        <?php if(request('status')): ?> <a href="<?php echo e(route('students.index')); ?>" class="ilap-btn ilap-btn-secondary ilap-btn-sm">Clear</a> <?php endif; ?>
        <a href="<?php echo e(route('students.export')); ?>?campus_id=<?php echo e(request('campus_id')); ?>"
           class="ilap-btn ilap-btn-secondary ilap-btn-sm">📥 Export CSV</a>
        <a href="<?php echo e(route('students.create')); ?>"
           class="ilap-px-5 py-2.5 rounded-xl text-white text-sm font-bold shadow-md transition-all
                  hover:translate-y-[-1px] hover:shadow-lg"
           style="background:var(--ilap-primary)">+ New Student</a>
    </div>
</div>


<div class="ilap-card ilap-mb-6">
    <form method="GET" class="ilap-p-4 grid gap-3 md:grid-cols-4">
        <div>
            <label class="ilap-label">Search</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="ilap-input"
                   placeholder="Name / Unique ID">
        </div>
        <div>
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                <option value="">All Campuses</option>
                <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php if(request('campus_id')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="ilap-label">Status</label>
            <select name="status" class="ilap-select">
                <option value="">All</option>
                <?php $__currentLoopData = ['registered','payment_pending','enrolled','documents_verified','completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php if(request('status')==$s): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="ilap-flex items-end">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-w-full">Filter</button>
        </div>
    </form>
</div>


<div class="ilap-flex items-center gap-3 ilap-mb-4">
    <span class="ilap-badge ilap-badge--blue">
        Total Students: <?php echo e($total ?? number_format($students->total())); ?>

    </span>
</div>


<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name &amp; ID</th>
                    <th>Campus</th>
                    <th>Handler</th>
                    <th>Phone</th>
                    <th>IELTS</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="ilap-text-muted"><?php echo e($students->firstItem() + $i); ?></td>
                <td>
                    <div class="ilap-flex items-center gap-2">
                        <div class="ilap-avatar"><?php echo e(strtoupper(substr($student->name??'?',0,1))); ?></div>
                        <div>
                            <p class="ilap-text-sm ilap-font-bold text-slate-800"><?php echo e($student->name); ?></p>
                            <p class="ilap-badge ilap-badge--gray ilap-text-2xs"><?php echo e($student->unique_id); ?></p>
                        </div>
                    </div>
                </td>
                <td class="ilap-text-sm"><?php echo e($student->campus?->name ?? '—'); ?></td>
                <td class="ilap-text-sm"><?php echo e($student->handler?->name ?? $student->handler?->email ?? '—'); ?></td>
                <td class="ilap-text-sm text-slate-500"><?php echo e($student->phone ?? '—'); ?></td>
                <td>
                    <?php if($student->ielts_score): ?>
                        <span class="ilap-badge ilap-badge--blue ilap-font-bold"><?php echo e(number_format($student->ielts_score,1)); ?></span>
                    <?php else: ?> <span class="ilap-text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                        $color = $student->current_step==='completed'?'green'
                            : ($student->current_step==='documents_verified'?'blue'
                            : ($student->current_step==='enrolled'?'yellow':'gray'));
                        $label = ucfirst(str_replace('_',' ',($student->current_step ?? 'registered')));
                    ?>
                    <span class="ilap-badge ilap-badge--<?php echo e($color); ?>"><?php echo e($label); ?></span>
                </td>
                <td>
                    <a href="<?php echo e(route('students.show',$student)); ?>"
                       class="ilap-btn ilap-btn-secondary ilap-btn-sm"
                       style="background:var(--ilap-primary-light);color:var(--ilap-primary)">
                        View
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="ilap-text-center ilap-py-12 text-slate-400">
                    <p class="ilap-text-lg">No students found.</p>
                    <p class="ilap-text-xs ilap-mt-1">Adjust filters or add a new student.</p>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($students->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/students/index.blade.php ENDPATH**/ ?>