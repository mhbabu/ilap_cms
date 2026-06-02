<?php $__env->startSection('title','Tickets'); ?>
<?php $__env->startSection('page-title','Tickets'); ?>

<?php $__env->startSection('content'); ?>
<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Tickets</h1>
        <p class="ilap-text-xs text-slate-500" id="ilap-ticket-status-note">No tickets yet.</p>
    </div>
    <a href="<?php echo e(route('tickets.create')); ?>"
       class="ilap-px-5 py-2.5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Open Ticket</a>
</div>


<div class="ilap-flex items-center gap-2 ilap-flex-wrap ilap-mb-6">
    <?php $__currentLoopData = ['open'=>'Open','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $sCount = ($statusCounts ?? collect())[$status] ?? 0; $activeFilter = request('status') === $status; ?>
        <a href="<?php echo e(request()->fullUrlWithQuery(['status' => $activeFilter ? '' : $status])); ?>"
           class="ilap-px-4 py-1.5 rounded-full text-sm font-bold border transition-all <?php echo e($activeFilter ? 'ilap-font-bold' : 'ilap-text-muted'); ?>"
           style="border-color:<?php echo e($activeFilter ? 'var(--ilap-primary)':'#e2e8f0'); ?>;background:<?php echo e($activeFilter ? 'var(--ilap-primary-light)':'transparent'); ?>

               ;color:<?php echo e($activeFilter ? 'var(--ilap-primary)':'#64748b'); ?>">
            <?php echo e($label); ?> <span class="ilap-font-extrabold"><?php echo e($sCount); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="ilap-grid-2">
    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="ilap-card hover:shadow-lg transition-shadow">
        <div class="ilap-p-4">
            
            <div class="ilap-flex items-start justify-between ilap-mb-2">
                <span class="ilap-text-2xs text-slate-400 font-semibold ilap-uppercase"><?php echo e($ticket->ticket_number); ?></span>
                <?php
                    $ps = ['critical'=>'red','high'=>'orange','medium'=>'#f59e0b','low'=>'green'];
                    $ss = ['open'=>'red','in_progress'=>'blue','resolved'=>'green','closed'=>'gray'];
                ?>
                <span class="ilap-badge ilap-badge--<?php echo e($ss[$ticket->status] ?? 'gray'); ?>">
                    <?php echo e(ucfirst(str_replace('_',' ',$ticket->status))); ?>

                </span>
            </div>

            <h3 class="ilap-text-lg ilap-font-bold text-slate-800"><?php echo e($ticket->title); ?></h3>
            <p class="ilap-text-sm text-slate-500 ilap-mt-1 ilap-line-clamp-2"><?php echo e($ticket->description); ?></p>

            <div class="ilap-flex items-center justify-between ilap-mt-4 ilap-pt-3 ilap-border-t border-slate-100">
                <div class="ilap-flex items-center gap-2">
                    <span class="ilap-badge ilap-badge--<?php echo e($ps[$ticket->priority] ?? 'gray'); ?>">
                        <?php echo e(ucfirst($ticket->priority)); ?>

                    </span>
                    <span class="ilap-text-2xs text-slate-400">• <?php echo e($ticket->type); ?></span>
                    <span class="ilap-text-2xs text-slate-400">• <?php echo e($ticket->creator?->name ?? '—'); ?></span>
                </div>
                <a href="<?php echo e(route('tickets.show',$ticket)); ?>"
                   class="ilap-btn ilap-btn-sm ilap-btn-secondary">View</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="ilap-metric ilap-col-span-2 ilap-text-center">
        <p class="ilap-text-lg ilap-font-bold text-slate-700">No tickets found</p>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">Create your first ticket to get started.</p>
    </div>
    <?php endif; ?>
</div>

<?php echo e($tickets->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/tickets/index.blade.php ENDPATH**/ ?>