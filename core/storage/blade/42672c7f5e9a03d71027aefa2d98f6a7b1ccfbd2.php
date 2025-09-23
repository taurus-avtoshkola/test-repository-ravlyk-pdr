<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('scripts.top'); ?>
        <?php /** @var EvolutionCMS\Models\SiteTemplate $data */ ?>
        <script>

            var actions = {
                save: function () {
                    documentDirty = false;
                    form_save = true;
                    document.mutate.save.click();
                    //saveWait('mutate');
                },
                duplicate: function () {
                    if (confirm("<?php echo e(ManagerTheme::getLexicon('confirm_duplicate_record')); ?>") === true) {
                        documentDirty = false;
                        document.location.href = "index.php?id=<?php echo e($data->getKey()); ?>&a=96";
                    }
                },
                delete: function () {
                    if (confirm("<?php echo e(ManagerTheme::getLexicon('confirm_delete_template')); ?>") === true) {
                        documentDirty = false;
                        document.location.href = 'index.php?id=<?php echo e($data->getKey()); ?>&a=21';
                    }
                },
                cancel: function () {
                    documentDirty = false;
                    document.location.href = 'index.php?a=76&tab=0';
                }
            };

            document.addEventListener('DOMContentLoaded', function () {
                var h1help = document.querySelector('h1 > .help');
                h1help.onclick = function () {
                    document.querySelector('.element-edit-message').classList.toggle('show');
                };
            });

        </script>
    <?php $__env->stopPush(); ?>

    <form name="mutate" method="post" action="index.php">
        <?php echo get_by_key($events, 'OnTempFormPrerender'); ?>


        <input type="hidden" name="a" value="20">
        <input type="hidden" name="id" value="<?php echo e($data->getKey()); ?>">
        <input type="hidden" name="mode" value="<?php echo e($action); ?>">

        <h1>
            <i class="fa fa-newspaper-o"></i>
            <?php if($data->templatename): ?>
                <?php echo e($data->templatename); ?>

                <small>(<?php echo e($data->getKey()); ?>)</small>
            <?php else: ?>
                <?php echo e(ManagerTheme::getLexicon('new_template')); ?>

            <?php endif; ?>
            <i class="fa fa-question-circle help"></i>
        </h1>

        <?php echo $__env->make('manager::partials.actionButtons', $actionButtons, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="container element-edit-message">
            <div class="alert alert-info"><?php echo e(ManagerTheme::getLexicon('template_msg')); ?></div>
        </div>

        <div class="tab-pane" id="templatesPane">
            <script>
                var tp = new WebFXTabPane(document.getElementById('templatesPane'), <?php echo e(get_by_key($modx->config, 'remember_last_tab') ? 1 : 0); ?>);
            </script>

            <div class="tab-page" id="tabTemplate">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('template_edit_tab')); ?></h2>
                <script>tp.addTabPage(document.getElementById('tabTemplate'));</script>

                <div class="container container-body">
                    <div class="form-group">
                        <?php echo $__env->make('manager::form.row', [
                            'for' => 'templatename',
                            'label' => ManagerTheme::getLexicon('template_name'),
                            'small' => ($data->getKey() == get_by_key($modx->config, 'default_template') ? '<b class="text-danger">' . mb_strtolower(rtrim(ManagerTheme::getLexicon('defaulttemplate_title'), ':'), ManagerTheme::getCharset()) . '</b>' : ''),
                            'element' => '<div class="form-control-name clearfix">' .
                                ManagerTheme::view('form.inputElement', [
                                    'name' => 'templatename',
                                    'value' => $data->templatename,
                                    'class' => 'form-control-lg',
                                    'attributes' => 'onchange="documentDirty=true;"'
                                ]) .
                                ($modx->hasPermission('save_role')
                                ? '<label class="custom-control" data-tooltip="' . ManagerTheme::getLexicon('lock_template') . "\n" . ManagerTheme::getLexicon('lock_template_msg') .'">' .
                                 ManagerTheme::view('form.inputElement', [
                                    'type' => 'checkbox',
                                    'name' => 'locked',
                                    'checked' => ($data->locked == 1)
                                 ]) .
                                 '<i class="fa fa-lock"></i>
                                 </label>
                                 <small class="form-text text-danger hide" id="savingMessage"></small>
                                 <script>if (!document.getElementsByName(\'templatename\')[0].value) document.getElementsByName(\'templatename\')[0].focus();</script>'
                                : '') .
                                '</div>'
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <?php echo $__env->make('manager::form.input', [
                            'name' => 'description',
                            'id' => 'description',
                            'label' => ManagerTheme::getLexicon('template_desc'),
                            'value' => $data->description,
                            'attributes' => 'onchange="documentDirty=true;" maxlength="255"'
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <?php echo $__env->make('manager::form.select', [
                            'name' => 'categoryid',
                            'id' => 'categoryid',
                            'label' => ManagerTheme::getLexicon('existing_category'),
                            'value' => $data->category,
                            'first' => [
                                'text' => ''
                            ],
                            'options' => $categories->pluck('category', 'id'),
                            'attributes' => 'onchange="documentDirty=true;"'
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <?php echo $__env->make('manager::form.input', [
                            'name' => 'newcategory',
                            'id' => 'newcategory',
                            'label' => ManagerTheme::getLexicon('new_category'),
                            'value' => (isset($data->newcategory) ? $data->newcategory : ''),
                            'attributes' => 'onchange="documentDirty=true;" maxlength="45"'
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </div>

                    <?php if($modx->hasPermission('save_role')): ?>
                        <div class="form-group">
                            <label>
                                <?php echo $__env->make('manager::form.inputElement', [
                                    'name' => 'selectable',
                                    'id' => 'selectable',
                                    'type' => 'checkbox',
                                    'checked' => ($data->selectable == 1),
                                    'attributes' => 'onchange="documentDirty=true;"'
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo e(ManagerTheme::getLexicon('template_selectable')); ?>

                            </label>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- HTML text editor start -->
                <div class="navbar navbar-editor">
                    <span><?php echo e(ManagerTheme::getLexicon('template_code')); ?></span>
                </div>
                <div class="section-editor clearfix">
                    <?php echo $__env->make('manager::form.textareaElement', [
                        'name' => 'post',
                        'value' => (isset($data->post) ? $data->post : $data->content),
                        'class' => 'phptextarea',
                        'rows' => 20,
                        'attributes' => 'onChange="documentDirty=true;"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <!-- HTML text editor end -->

                <input type="submit" name="save" style="display:none">
            </div>

            <div class="tab-page" id="tabAssignedTVs">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('template_assignedtv_tab')); ?></h2>
                <script>tp.addTabPage(document.getElementById('tabAssignedTVs'));</script>
                <input type="hidden" name="tvsDirty" id="tvsDirty" value="0">

                <div class="container container-body">
                    <?php if($data->tvs->count() > 0): ?>
                        <p><?php echo e(ManagerTheme::getLexicon('template_tv_msg')); ?></p>
                    <?php endif; ?>

                    <?php if($modx->hasPermission('save_template') && $data->tvs->count() > 1 && $data->getKey()): ?>
                        <div class="form-group">
                            <a class="btn btn-primary"
                               href="?a=117&id=<?php echo e($data->getKey()); ?>"><?php echo e(ManagerTheme::getLexicon('template_tv_edit')); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if($data->tvs->count() > 0): ?>
                        <ul>
                            <?php $__currentLoopData = $data->tvs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('manager::page.template.tv', [
                                    'item' => $item,
                                    'tvSelected' => [$item->getKey()]
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <?php echo e(ManagerTheme::getLexicon('template_no_tv')); ?>

                    <?php endif; ?>

                    <?php if($tvOutCategory->count() || $categoriesWithTv->count()): ?>
                        <hr>
                        <p><?php echo e(ManagerTheme::getLexicon('template_notassigned_tv')); ?></p>
                    <?php endif; ?>

                    <?php if($tvOutCategory->count() > 0): ?>
                        <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => 'tv_in_template', 'id' => 0, 'title' => ManagerTheme::getLexicon('no_category')]); ?>
                            <ul>
                                <?php $__currentLoopData = $tvOutCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('manager::page.template.tv', compact('item', 'tvSelected'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php echo $__env->renderComponent(); ?>
                    <?php endif; ?>

                    <?php $__currentLoopData = $categoriesWithTv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => 'tv_in_template', 'id' => $cat->id, 'title' => $cat->name]); ?>
                            <ul>
                                <?php $__currentLoopData = $cat->tvs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(! $data->tvs->contains('id', $item->getKey())): ?>
                                        <?php echo $__env->make('manager::page.template.tv', compact('item', 'tvSelected'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php echo $__env->renderComponent(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php echo get_by_key($events, 'OnTempFormRender'); ?>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager::template.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>