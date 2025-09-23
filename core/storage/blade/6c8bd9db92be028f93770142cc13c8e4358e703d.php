<?php
// actions buttons templates
$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : '';
if ($modx->getConfig('global_tabs') && !isset($_SESSION['stay'])) {
    $_REQUEST['stay'] = 2;
}
if (isset($_REQUEST['stay'])) {
    $_SESSION['stay'] = $_REQUEST['stay'];
} elseif (isset($_SESSION['stay'])) {
    $_REQUEST['stay'] = $_SESSION['stay'];
}
$stay = isset($_REQUEST['stay']) ? $_REQUEST['stay'] : '';
?>
<div id="actions">
    <div class="btn-group">
        <?php if(!empty($select) && !empty($save)): ?>
            <div class="btn-group">
                <a id="Button1" class="btn btn-success" href="javascript:;" onclick="actions.save();">
                    <i class="fa fa-floppy-o"></i>
                    <span><?php echo e(ManagerTheme::getLexicon('save')); ?></span>
                </a>
                <span class="btn btn-success plus dropdown-toggle"></span>
                <select id="stay" name="stay">
                    <?php if(!empty($new)): ?>
                        <option id="stay1" value="1" <?php if($stay == 1): ?>selected="selected"<?php endif; ?>><?php echo e(ManagerTheme::getLexicon('stay_new')); ?></option>
                    <?php endif; ?>
                    <option id="stay2" value="2" <?php if($stay == 2): ?>selected="selected"<?php endif; ?>><?php echo e(ManagerTheme::getLexicon('stay')); ?></option>
                    <option id="stay3" value="" <?php if($stay == ''): ?>selected="selected"<?php endif; ?>><?php echo e(ManagerTheme::getLexicon('close')); ?></option>
                </select>
            </div>
        <?php elseif(!empty($save)): ?>
            <a id="Button1" class="btn btn-success" href="javascript:;" onclick="actions.save();">
                <i class="fa fa-floppy-o"></i>
                <span><?php echo e(ManagerTheme::getLexicon('save')); ?></span>
            </a>
        <?php endif; ?>
        <?php if(!empty($duplicate)): ?>
            <a id="Button6" class="btn btn-secondary" href="javascript:;" onclick="actions.duplicate();">
                <i class="fa fa-clone"></i>
                <span><?php echo e(ManagerTheme::getLexicon('duplicate')); ?></span>
            </a>
        <?php endif; ?>
        <?php if(!empty($delete)): ?>
            <a id="Button3" class="btn btn-secondary" href="javascript:;" onclick="actions.delete();">
                <i class="fa fa-trash"></i>
                <span><?php echo e(ManagerTheme::getLexicon('delete')); ?></span>
            </a>
        <?php endif; ?>
        <?php if(!empty($cancel)): ?>
            <a id="Button5" class="btn btn-secondary" href="javascript:;" onclick="actions.cancel();">
                <i class="fa fa-times-circle"></i>
                <span><?php echo e(ManagerTheme::getLexicon('cancel')); ?></span>
            </a>
        <?php endif; ?>
        <?php if(!empty($preview)): ?>
            <a id="Button4" class="btn btn-secondary" href="javascript:;" onclick="actions.view();">
                <i class="fa fa-eye"></i>
                <span><?php echo e(ManagerTheme::getLexicon('preview')); ?></span>
            </a>
        <?php endif; ?>
    </div>
</div>
