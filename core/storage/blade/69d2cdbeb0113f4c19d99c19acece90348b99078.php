<?php if(!empty($options) || !empty($first)): ?>
    <select class="form-control <?php echo e(isset($class) ? $class : ''); ?>" name="<?php echo e($name); ?>" id="<?php echo e(isset($id) ? $id : $name); ?>"
        <?php echo isset($attributes) ? $attributes : ''; ?>

    >
        <?php if(!empty($first)): ?>
            <option value="<?php echo e(isset($first['value']) ? $first['value'] : ''); ?>"><?php echo e(isset($first['text']) ? $first['text'] : ''); ?></option>
        <?php endif; ?>
        <?php if(!empty($options)): ?>
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($option['optgroup']) && !empty($option['optgroup']['options'])): ?>
                    <optgroup label="<?php echo e(isset($option['optgroup']['name']) ? $option['optgroup']['name'] : 'optgroup'); ?>">
                        <?php $__currentLoopData = $option['optgroup']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($opt['value']); ?>" <?php if(isset($value) && $value == $opt['value']): ?>selected="selected"<?php endif; ?>><?php echo e($opt['text']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </optgroup>
                <?php elseif(is_string($option)): ?>
                    <?php if(!empty($as)): ?>
                        <?php if($as == 'keys'): ?>
                            <option value="<?php echo e($key); ?>"
                                <?php if(isset($value) && $value == $key): ?>
                                selected="selected"
                                <?php endif; ?>
                            ><?php echo e($key); ?></option>
                        <?php elseif($as == 'values'): ?>
                            <option value="<?php echo e($option); ?>"
                                <?php if(isset($value) && $value == $option): ?>
                                selected="selected"
                                <?php endif; ?>
                            ><?php if(!empty($ucwords)): ?><?php echo e(ucwords(str_replace("_", " ", $option))); ?><?php else: ?><?php echo e($option); ?><?php endif; ?></option>
                        <?php endif; ?>
                    <?php else: ?>
                        <option value="<?php echo e($key); ?>"
                            <?php if(isset($value) && $value == $key): ?>
                            selected="selected"
                            <?php endif; ?>
                        ><?php if(!empty($ucwords)): ?><?php echo e(ucwords(str_replace("_", " ", $option))); ?><?php else: ?><?php echo e($option); ?><?php endif; ?></option>
                    <?php endif; ?>
                <?php else: ?>
                    <option value="<?php echo e(isset($option['value']) ? $option['value'] : ''); ?>"
                        <?php if(isset($value) && $value == $option['value']): ?>
                        selected="selected"
                        <?php endif; ?>
                    ><?php echo e(isset($option['text']) ? $option['text'] : $option['value']); ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>
<?php endif; ?>
