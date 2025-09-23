<?php $__env->startSection('head'); ?>
    <?php echo $__env->make('manager::partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('manager::partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>
