<?php $__env->startSection('title','Finance'); ?>
<?php $__env->startSection('page-title','Finance &amp; Payments'); ?>
<?php $__env->startSection('content'); ?>

<div class="ilap-page-header ilap-flex items-center justify-between ilap-flex-wrap gap-3">
    <div>
        <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Finance</h1>
        <p class="ilap-text-sm text-slate-500 ilap-mt-1">Payment tracking, receipting &amp; instalment management</p>
    </div>
    <a href="<?php echo e(route('finance.payments.create')); ?>"
       class="ilap-px-5 py-2.5 rounded-xl text-white font-bold shadow-md text-sm"
       style="background:var(--ilap-primary)">+ Record Payment</a>
</div>


<div class="ilap-metrics ilap-mb-6">
    <div class="ilap-metric">
        <p class="ilap-metric__label">Completed Revenue</p>
        <p class="ilap-metric__value">£<?php echo e(number_format($totalRevenue ?? 0, 0)); ?></p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Pending Payment</p>
        <p class="ilap-metric__value" style="color:#d97706">£<?php echo e(number_format($pendingAmt ?? 0, 0)); ?></p>
    </div>
    <div class="ilap-metric">
        <p class="ilap-metric__label">Total Transactions</p>
        <p class="ilap-metric__value"><?php echo e(number_format($payments?->total() ?? ($payments->count() ?? 0))); ?></p>
    </div>
</div>


<div class="ilap-card">
    <div class="ilap-table__wrap">
        <table class="ilap-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Payer</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="ilap-text-xs text-slate-500"><?php echo e($payment->id); ?></td>
                <td>
                    <div class="ilap-flex items-center gap-2">
                        <div class="ilap-avatar" style="background:<?php echo e($payment->campus?->color_primary ?? 'var(--ilap-primary)'); ?>">
                            <?php echo e(strtoupper(substr($payment->payer?->name ?? $payment->payer?->unique_id ?? 'P',0,1))); ?>

                        </div>
                        <span class="ilap-text-sm ilap-font-semibold text-slate-700">
                            <?php echo e($payment->payer?->name ?? ($payment->payer?->unique_id ?? '—')); ?>

                        </span>
                    </div>
                </td>
                <td class="ilap-font-bold" style="color:var(--ilap-primary)">£<?php echo e(number_format($payment->amount, 2)); ?></td>
                <td><span class="ilap-badge ilap-badge--blue"><?php echo e(ucfirst($payment->type)); ?></span></td>
                <td>
                    <?php
                        $sColor = match($payment->status) {
                            'completed' => 'green',
                            'pending'   => 'yellow',
                            'approved'  => 'blue',
                            'rejected'  => 'red',
                            default     => 'gray',
                        };
                    ?>
                    <span class="ilap-badge ilap-badge--<?php echo e($sColor); ?>"><?php echo e(ucfirst($payment->status)); ?></span>
                </td>
                <td class="ilap-text-sm text-slate-500"><?php echo e($payment->campus?->name ?? '—'); ?></td>
                <td class="ilap-flex gap-1">
                    <?php if($payment->status === 'completed'): ?>
                        <a href="<?php echo e(route('receipt', $payment)); ?>"
                           class="ilap-text-sm text-blue-600 font-bold hover:underline">Receipt</a>
                    <?php endif; ?>
                    <?php if($payment->status === 'pending'): ?>
                        <form action="<?php echo e(route('finance.approve', $payment)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="ilap-text-xs text-green-600 font-bold hover:underline">
                                Approve
                            </button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="ilap-text-center ilap-py-12">
                    <p class="ilap-text-slate-400">No payment records found.</p>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="ilap-card ilap-mt-6 ilap-p-5">
    <div class="ilap-flex items-center justify-between ilap-mb-4">
        <h3 class="ilap-font-bold text-slate-800" style="background:var(--ilap-primary);color:white;padding:.25rem .625rem;border-radius:.25rem;font-size:.75rem;font-weight:700">Revenue by Campus</h3>
    </div>
    <div class="ilap-flex items-end gap-3 h-40" id="revenueChart">
        
        <?php $__currentLoopData = ($campuses ?? \App\Models\Campus::active()->get()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $amt = $campus->payments()->completed()->sum('amount'); ?>
            <div class="ilap-flex flex-col items-center ilap-gap-2 ilap-grow">
                <div class="ilap-font-bold ilap-text-xs" style="color:var(--ilap-primary)">£<?php echo e(number_format($amt,0)); ?></div>
                <div class="ilap-w-full rounded-t-xl transition-all"
                     style="height:<?php echo e(min(max($amt/10000,4),90)); ?>%; background:<?php echo e($campus->color_primary ?? 'var(--ilap-primary)'); ?>"></div>
                <span class="ilap-text-2xs text-slate-400"><?php echo e(Str::limit($campus->name, 10)); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/finance/index.blade.php ENDPATH**/ ?>