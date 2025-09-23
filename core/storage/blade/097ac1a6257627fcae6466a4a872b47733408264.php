<?php $__env->startPush('scripts.bot'); ?>
    <script>
        var trans = <?php echo json_encode($unlockTranslations, JSON_UNESCAPED_UNICODE); ?>,
            mraTrans = <?php echo json_encode($mraTranslations, JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script src="media/script/jquery.quicksearch.js"></script>
    <script src="media/script/jquery.nucontextmenu.js"></script>
    <script src="media/script/bootstrap/js/bootstrap.min.js"></script>
    <script src="actions/resources/functions.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <h1>
        <i class="fa fa-th"></i><?php echo e(ManagerTheme::getLexicon('element_management')); ?>

    </h1>

    <div class="sectionBody">
        <div class="tab-pane" id="resourcesPane">
            <script type="text/javascript">
              tpResources = new WebFXTabPane(document.getElementById('resourcesPane'), false);
            </script>

            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($tab instanceof EvolutionCMS\Interfaces\ManagerTheme\TabControllerInterface): ?>
                    <?php echo $__env->make(ManagerTheme::getViewName($tab->getView()), $tab->getParameters(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                    <?php echo $tab; ?>

                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($activeTab !== ''): ?>
                <script> tpResources.setSelectedTab('<?php echo e($activeTab); ?>');</script>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager::template.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>