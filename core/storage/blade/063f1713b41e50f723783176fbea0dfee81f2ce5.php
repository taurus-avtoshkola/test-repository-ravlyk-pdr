<div class="row form-row form-element-select">
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
        <?php if(!empty($options) || !empty($first)): ?>
            <div class="clearfix">
                <select class="form-control" name="<?php echo e($name); ?>" id="<?php echo e(isset($id) ? $id : $name); ?>"
                    <?php echo isset($attributes) ? $attributes : ''; ?>

                >
                    <?php if(!empty($first)): ?>
                        <option value="<?php echo e(isset($first['value']) ? $first['value'] : ''); ?>"><?php echo e(isset($first['text']) ? $first['text'] : ''); ?></option>
                    <?php endif; ?>
                    <?php if(!empty($options)): ?>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($option['optgroup']) && !empty($option['optgroup']['options'])): ?>
                                <optgroup label="<?php echo e(isset($option['optgroup']['name']) ? $option['optgroup']['name'] : 'optgroup'); ?>">
                                    <?php $__currentLoopData = $option['optgroup']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(is_string($opt)): ?>
                                            <option value="<?php echo e($k); ?>"
                                                <?php if(isset($value) && $value == $k): ?>
                                                selected="selected"
                                                <?php endif; ?>
                                            ><?php echo e($opt); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e(isset($opt['value']) ? $opt['value'] : $k); ?>"
                                                <?php if(isset($value) && $value == $opt['value']): ?>
                                                selected="selected"
                                                <?php endif; ?>
                                            ><?php echo e(isset($opt['text']) ? $opt['text'] : $opt['value']); ?></option>
                                        <?php endif; ?>
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
                                <option value="<?php echo e($option['value']); ?>"
                                    <?php if(isset($value) && $value == $option['value']): ?>
                                    selected="selected"
                                    <?php endif; ?>
                                ><?php echo e(isset($option['text']) ? $option['text'] : $option['value']); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php endif; ?>
        <?php if(!empty($comment)): ?>
            <small class="form-text text-muted"><?php echo $comment; ?></small>
        <?php endif; ?>
    </div>
</div>
