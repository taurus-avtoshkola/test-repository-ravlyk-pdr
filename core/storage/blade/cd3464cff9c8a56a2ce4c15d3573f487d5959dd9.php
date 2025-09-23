<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('scripts.top'); ?>
        <script>
          // Added for RTE selection
          function changeRTE()
          {
            var whichEditor = document.getElementById('which_editor');
            if (whichEditor) {
              for (var i = 0; i < whichEditor.length; i++) {
                if (whichEditor[i].selected) {
                  newEditor = whichEditor[i].value;
                  break;
                }
              }
            }

            documentDirty = false;
            document.mutate.a.value = '<?php echo e($action); ?>';
            document.mutate.which_editor.value = newEditor;
            document.mutate.submit();
          }

          var actions = {
            save: function() {
              documentDirty = false;
              form_save = true;
              document.mutate.save.click();
            },
            duplicate: function() {
              if (confirm('<?php echo e(ManagerTheme::getLexicon('confirm_duplicate_record')); ?>') === true) {
                documentDirty = false;
                document.location.href = "index.php?id=<?php echo e($data->getKey()); ?>&a=97";
              }
            },
            delete: function() {
              if (confirm('<?php echo e(ManagerTheme::getLexicon('confirm_delete_htmlsnippet')); ?>') === true) {
                documentDirty = false;
                document.location.href = 'index.php?id=' + document.mutate.id.value + '&a=80';
              }
            },
            cancel: function() {
              documentDirty = false;
              document.location.href = 'index.php?a=76&tab=2';
            }
          };

          document.addEventListener('DOMContentLoaded', function() {
            var h1help = document.querySelector('h1 > .help');
            h1help.onclick = function() {
              document.querySelector('.element-edit-message').classList.toggle('show');
            };
          });

        </script>
    <?php $__env->stopPush(); ?>

    <form class="htmlsnippet" id="mutate" name="mutate" method="post" action="index.php">
        <?php echo get_by_key($events, 'OnChunkFormPrerender'); ?>


        <input type="hidden" name="a" value="79" />
        <input type="hidden" name="id" value="<?php echo e($data->getKey()); ?>" />
        <input type="hidden" name="mode" value="<?php echo e($action); ?>" />

        <h1>
            <i class="fa fa-th-large"></i>
            <?php if($data->name): ?>
                <?php echo e($data->name); ?>

                <small>(<?php echo e($data->getKey()); ?>)</small>
            <?php else: ?>
                <?php echo e(ManagerTheme::getLexicon('new_htmlsnippet')); ?>

            <?php endif; ?>
            <i class="fa fa-question-circle help"></i>
        </h1>

        <?php echo $__env->make('manager::partials.actionButtons', $actionButtons, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="container element-edit-message">
            <div class="alert alert-info"><?php echo ManagerTheme::getLexicon('htmlsnippet_msg'); ?></div>
        </div>

        <div class="tab-pane" id="chunkPane">
            <script>
              var tpChunk = new WebFXTabPane(document.getElementById('chunkPane'), false);
            </script>

            <div class="tab-page" id="tabGeneral">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('settings_general')); ?></h2>
                <script>tpChunk.addTabPage(document.getElementById('tabGeneral'));</script>

                <div class="container container-body">
                    <?php echo $__env->make('manager::form.row', [
                        'for' => 'name',
                        'label' => ManagerTheme::getLexicon('htmlsnippet_name'),
                        'element' => '<div class="form-control-name clearfix">' .
                            ManagerTheme::view('form.inputElement', [
                                'name' => 'name',
                                'value' => $data->name,
                                'class' => 'form-control-lg',
                                'attributes' => 'onchange="documentDirty=true;" maxlength="100"'
                            ]) .
                            ($modx->hasPermission('save_role')
                            ? '<label class="custom-control" data-tooltip="' . ManagerTheme::getLexicon('lock_htmlsnippet') . "\n" . ManagerTheme::getLexicon('lock_htmlsnippet_msg') .'">' .
                             ManagerTheme::view('form.inputElement', [
                                'type' => 'checkbox',
                                'name' => 'locked',
                                'checked' => ($data->locked == 1)
                             ]) .
                             '<i class="fa fa-lock"></i>
                             </label>
                             <small class="form-text text-danger hide" id="savingMessage"></small>
                             <script>if (!document.getElementsByName(\'name\')[0].value) document.getElementsByName(\'name\')[0].focus();</script>'
                            : '') .
                            '</div>'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('manager::form.input', [
                        'name' => 'description',
                        'id' => 'description',
                        'label' => ManagerTheme::getLexicon('htmlsnippet_desc'),
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

                    <?php if($_SESSION['mgrRole'] === 1): ?>
                        <div class="form-row">
                            <label for="disabled">
                                <?php echo $__env->make('manager::form.inputElement', [
                                    'type' => 'checkbox',
                                    'name' => 'disabled',
                                    'value' => 'on',
                                    'checked' => ($data->disabled === 1)
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php if($data->disabled == 1): ?>
                                    <span class="text-danger"><?php echo e(ManagerTheme::getLexicon('disabled')); ?></span>
                                <?php else: ?>
                                    <?php echo e(ManagerTheme::getLexicon('disabled')); ?>

                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- HTML text editor start -->
                <div class="navbar navbar-editor">
                    <span><?php echo e(ManagerTheme::getLexicon('chunk_code')); ?></span>
                    <?php if(get_by_key($modx->config, 'use_editor') == 1): ?>
                        <span class="float-xs-right">
                            <?php echo e(ManagerTheme::getLexicon('which_editor_title')); ?>

                            <?php echo $__env->make('manager::form.selectElement', [
                                'name' => 'which_editor',
                                'value' => $which_editor,
                                'first' => [
                                    'value' => 'none',
                                    'text' => ManagerTheme::getLexicon('none')
                                ],
                                'options' => get_by_key($events, 'OnRichTextEditorRegister'),
                                'as' => 'values',
                                'class' => 'form-control-sm',
                                'attributes' => 'onchange="changeRTE();"'
                            ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="section-editor clearfix">
                    <?php echo $__env->make('manager::form.textareaElement', [
                        'name' => 'post',
                        'value' => (isset($data->post) ? $data->post : $data->snippet),
                        'class' => 'phptextarea',
                        'rows' => 20,
                        'attributes' => 'onChange="documentDirty=true;"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <!-- HTML text editor end -->

            </div>

            <?php echo get_by_key($events, 'OnChunkFormRender'); ?>

        </div>
        <input type="submit" name="save" style="display:none;" />
    </form>

    <?php if(get_by_key($modx->config, 'use_editor') == 1): ?>
        <?php echo get_by_key($events, 'OnRichTextEditorInit'); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager::template.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>