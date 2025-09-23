<?php /** @var EvolutionCMS\Models\SiteTemplate $item */ ?>
<li>
    <label <?php if(!$item->selectable): ?> class="disabled" <?php endif; ?>>
        <?php echo $__env->make('manager::form.inputElement', [
            'type' => 'checkbox',
            'name' => 'template[]',
            'checked' => !empty($selected),
            'value' => $item->getKey(),
            'attributes' => 'onchange="documentDirty=true;"'
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo e($item->name); ?>

        <small>(<?php echo e($item->getKey()); ?>)</small>
        <?php if(!empty($item->description)): ?>
            - <?php echo $item->description; ?>

        <?php endif; ?>
        <?php if(!empty($item->locked)): ?>
            <em>(<?php echo e(ManagerTheme::getLexicon('locked')); ?>)</em>
        <?php endif; ?>
        <?php if($item->getKey() == get_by_key($modx->config, 'default_template')): ?>
            <em>(<?php echo e(ManagerTheme::getLexicon('defaulttemplate_title')); ?>)</em>
        <?php endif; ?>
    </label>
</li>
