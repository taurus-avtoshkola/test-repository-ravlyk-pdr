<div class="panel-heading">
    <span class="panel-title">
        <a class="accordion-toggle" id="toggle<?php echo e($name); ?><?php echo e($id); ?>" href="#collapse<?php echo e($name); ?><?php echo e($id); ?>" data-cattype="<?php echo e($name); ?>" data-catid="<?php echo e($id); ?>" title="Click to toggle collapse. Shift+Click to toggle all.">
            <span class="category_name">
                <strong>
                    <?php echo e($title); ?>

                    <?php if($id > 0): ?>
                        <small>(<?php echo e($id); ?>)</small>
                    <?php endif; ?>
                </strong>
            </span>
        </a>
    </span>
</div>
<div id="collapse<?php echo e($name); ?><?php echo e($id); ?>" class="panel-collapse collapse in" aria-expanded="true">
    <?php echo e($slot); ?>

</div>
