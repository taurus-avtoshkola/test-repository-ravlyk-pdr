<!DOCTYPE html>
<html lang="<?php echo e(ManagerTheme::getLang()); ?>" dir="<?php echo e(ManagerTheme::getTextDir()); ?>">
<head>
    <title>Evolution CMS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo e(ManagerTheme::getCharset()); ?>"/>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width"/>
    <meta name="theme-color" content="#1d2023"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <?php if(class_exists(Tracy\Debugger::class) && $modx->get('config')->get('tracy.active')): ?>
        <?php echo Tracy\Debugger::renderLoader(); ?>

    <?php endif; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(ManagerTheme::css()); ?>"/>
    <script type="text/javascript" src="media/script/tabpane.js"></script>
    <script type="text/javascript" src="<?php echo e($modx->getConfig('mgr_jquery_path')); ?>"></script>
    <?php if($modx->getConfig('show_picker') === true): ?>
        <script src="<?php echo e(ManagerTheme::getThemeUrl()); ?>/js/color.switcher.js" type="text/javascript"></script>
    <?php endif; ?>

    <?php echo ManagerTheme::getMainFrameHeaderHTMLBlock(); ?>


    <script type="text/javascript">
        if (!evo) {
            var evo = {};
        }
        var actions,
            actionStay = [],
            dontShowWorker = false,
            documentDirty = false,
            timerForUnload,
            managerPath = '';

        evo.lang = <?php echo json_encode(Illuminate\Support\Arr::only(
            ManagerTheme::getLexicon(),
            ['saving', 'error_internet_connection', 'warning_not_saved']
        )); ?>;
        evo.style = <?php echo json_encode(Illuminate\Support\Arr::only(
            ManagerTheme::getStyle(),
            ['actions_file', 'actions_pencil', 'actions_reply', 'actions_plus']
        )); ?>;
        evo.urlCheckConnectionToServer = '<?php echo e(MODX_MANAGER_URL); ?>';
    </script>
    <script src="media/script/main.js"></script>
    <?php if(get_by_key($_REQUEST, 'r', '', 'is_numeric')): ?>
        <script>doRefresh(<?php echo e($_REQUEST['r']); ?>);</script>
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts.top'); ?>
    <?php echo $modx->getRegisteredClientStartupScripts(); ?>

</head>

<body class="<?php echo e(ManagerTheme::getTextDir()); ?> <?php echo e(ManagerTheme::getThemeStyle()); ?>" data-evocp="color">
