<div class="row form-row form-element-input">
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
        <input class="form-control" type="<?php echo e(isset($type) ? $type : 'text'); ?>"
            <?php if(!empty($id)): ?> id="<?php echo e($id); ?>" <?php elseif(!empty($name)): ?> id="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(!empty($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(isset($value)): ?> value="<?php echo e($value); ?>" <?php endif; ?>
        <?php if(isset($placeholder)): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php echo isset($attributes) ? $attributes : ''; ?>

        <?php if(!empty($readonly)): ?> readonly <?php endif; ?>
        <?php if(!empty($disabled)): ?> disabled <?php endif; ?>
        />
        <?php if(!empty($comment)): ?>
            <small class="form-text text-muted"><?php echo $comment; ?></small>
        <?php endif; ?>
    </div>
</div>
