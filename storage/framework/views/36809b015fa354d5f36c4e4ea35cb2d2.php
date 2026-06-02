<?php $__env->startSection('title', 'Tickets'); ?>
<?php $__env->startSection('page-title', 'Create Ticket'); ?>

<?php $__env->startSection('content'); ?>
<div class="ilap-page-header">
    <h1 class="ilap-text-2xl ilap-font-extrabold" style="color:var(--ilap-primary-dark)">Create Support Ticket</h1>
</div>

<div class="ilap-card">
    <form action="<?php echo e(route('tickets.store')); ?>" method="POST" class="ilap-p-6 grid gap-4 md:grid-cols-2">
        <?php echo csrf_field(); ?>
        
        <div class="ilap-form-group">
            <label class="ilap-label">Title *</label>
            <input type="text" name="title" required class="ilap-input" placeholder="Brief summary">
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Priority *</label>
            <select name="priority" required class="ilap-select">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Type *</label>
            <select name="type" required class="ilap-select">
                <option value="technical">Technical</option>
                <option value="financial">Financial</option>
                <option value="administrative">Administrative</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="ilap-form-group">
            <label class="ilap-label">Campus</label>
            <select name="campus_id" class="ilap-select">
                <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($campus->id); ?>"><?php echo e($campus->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="ilap-form-group md:col-span-2">
            <label class="ilap-label">Description *</label>
            <textarea name="description" rows="4" required class="ilap-input" placeholder="Detailed description..."></textarea>
        </div>

        <div class="ilap-mt-4 md:col-span-2">
            <button type="submit" class="ilap-btn ilap-btn-primary ilap-px-6 py-2.5 rounded-xl font-bold">
                Create Ticket
            </button>
            <a href="<?php echo e(route('tickets.index')); ?>" class="ilap-btn ilap-btn-secondary ilap-ml-2">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Projects/l/resources/views/tickets/create.blade.php ENDPATH**/ ?>