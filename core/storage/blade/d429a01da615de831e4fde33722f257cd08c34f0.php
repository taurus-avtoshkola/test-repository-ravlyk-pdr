<div class="row form-row form-element-textarea">
    <label for="<?php echo e(isset($for) ? $for : $name); ?>" class="control-label col-5 col-md-3 col-lg-2">
        <?php echo isset($label) ? $label : ''; ?>

        <?php if(!empty($required)): ?>
            <span class="form-element-required">*</span>
        <?php endif; ?>
        <?php if(!empty($small)): ?>
            <small class="form-text text-muted"><?php echo $small; ?></small>
        <?php endif; ?>
    </label>
    <div class="col-7 col-md-9 col-lg-10">
        <textarea class="form-control" name="<?php echo e($name); ?>" id="<?php echo e(isset($id) ? $id : $name); ?>" rows="<?php echo e(isset($rows) ? $rows : '3'); ?>"
            <?php if(!empty($placeholder)): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php echo isset($attributes) ? $attributes : ''; ?>

        <?php if(!empty($readonly)): ?> readonly <?php endif; ?>
        ><?php echo e($value); ?></textarea>
        <?php if(!empty($comment)): ?>
            <small class="form-text text-muted"><?php echo $comment; ?></small>
        <?php endif; ?>
    </div>
</div>
