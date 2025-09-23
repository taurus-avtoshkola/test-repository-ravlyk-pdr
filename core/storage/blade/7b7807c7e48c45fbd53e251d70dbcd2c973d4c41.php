<textarea class="form-control <?php echo e(isset($class) ? $class : ''); ?>" name="<?php echo e($name); ?>" id="<?php echo e(isset($id) ? $id : $name); ?>" rows="<?php echo e(isset($rows) ? $rows : '3'); ?>"
    <?php if(!empty($placeholder)): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
<?php echo isset($attributes) ? $attributes : ''; ?>

<?php if(!empty($readonly)): ?> readonly <?php endif; ?>
><?php echo e($value); ?></textarea>
