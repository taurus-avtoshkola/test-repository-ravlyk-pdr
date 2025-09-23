<form id="switchForm_<?php echo e($id); ?>" class="form-group form-inline switchForm" data-target="<?php echo e($id); ?>_content" style="display:none">
    <div class="form-row">
        <label class="form-check">
            <input type="radio" name="view" value="list" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_radio_list')); ?>

        </label>
        <label class="form-check">
            <input type="radio" name="view" value="inline" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_radio_inline')); ?>

        </label>
        <label class="form-check">
            <input type="radio" name="view" value="flex" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_radio_flex')); ?>

        </label>
        <input type="number" placeholder="Columns" name="columns" class="form-control form-control-sm columns" value="3" size="3" />
    </div>
    <div class="form-row">
        <label class="form-check">
            <input type="checkbox" name="cb_buttons" value="buttons" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_cb_buttons')); ?>

        </label>
        <label class="form-check">
            <input type="checkbox" name="cb_description" value="description" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_cb_descriptions')); ?>

        </label>
        <label class="form-check">
            <input type="checkbox" name="cb_icons" value="icons" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_cb_icons')); ?>

        </label>
    </div>
    <div class="form-row">
        <label>
            <?php echo e(ManagerTheme::getLexicon('viewopts_fontsize')); ?>

            <input type="number" placeholder="" name="fontsize" class="form-control form-control-sm fontsize" value="10" />
        </label>
    </div>
    <div class="form-row">
        <label>
            <input type="checkbox" class="cb_all" name="cb_all" value="all" />
            <?php echo e(ManagerTheme::getLexicon('viewopts_cb_alltabs')); ?>

        </label>
    </div>
    <div class="optionsLeft optionsReset">
        <a href="javascript:;" class="btn btn-danger btn-sm btn_reset"><?php echo e(ManagerTheme::getLexicon('reset')); ?></a>
    </div>
</form>
