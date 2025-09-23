<?php $__env->startSection('content'); ?>
    <?php /** @var EvolutionCMS\Models\SiteTmplvar $data */ ?>
    <?php $__env->startPush('scripts.top'); ?>
        <script>

          function check_toggle()
          {
            var el = document.getElementsByName('template[]');
            var count = el.length;
            for (var i = 0; i < count; i++) {
              el[i].checked = !el[i].checked;
            }
          };

          function check_none()
          {
            var el = document.getElementsByName('template[]');
            var count = el.length;
            for (var i = 0; i < count; i++) {
              el[i].checked = false;
            }
          };

          function check_all()
          {
            var el = document.getElementsByName('template[]');
            var count = el.length;
            for (var i = 0; i < count; i++) {
              el[i].checked = true;
            }
          };

          var actions = {
            save: function() {
              documentDirty = false;
              form_save = true;
              document.mutate.save.click();
              saveWait('mutate');
            },
            duplicate: function() {
              if (confirm("<?php echo e(ManagerTheme::getLexicon('confirm_duplicate_record')); ?>") === true) {
                documentDirty = false;
                document.location.href = "index.php?id=<?php echo e($data->getKey()); ?>&a=304";
              }
            },
            delete: function() {
              if (confirm("<?php echo e(ManagerTheme::getLexicon('confirm_delete_tmplvars')); ?>") === true) {
                documentDirty = false;
                document.location.href = 'index.php?id=' + document.mutate.id.value + '&a=303';
              }
            },
            cancel: function() {
              documentDirty = false;
              document.location.href = 'index.php?a=<?php echo e($origin); ?><?php if(!empty($originId)): ?>&id=<?php echo e($originId); ?><?php endif; ?>&tab=1';
            }
          };

          // Widget Parameters
          var widgetParams = {};          // name = description;datatype;default or list values - datatype: int, string, list : separated by comma (,)
          widgetParams['date'] = '&format=Date Format;string;%A %d, %B %Y &default=If no value, use current date;list;Yes,No;No';
          widgetParams['string'] = '&format=String Format;list;Upper Case,Lower Case,Sentence Case,Capitalize';
          widgetParams['delim'] = '&format=Delimiter;string;,';
          widgetParams['hyperlink'] = '&text=Display Text;string; &title=Title;string; &class=Class;string &style=Style;string &target=Target;string &attrib=Attributes;string';
          widgetParams['htmltag'] = '&tagname=Tag Name;string;div &tagid=Tag ID;string &class=Class;string &style=Style;string &attrib=Attributes;string';
          widgetParams['viewport'] = '&vpid=ID/Name;string &width=Width;string;100 &height=Height;string;100 &borsize=Border Size;int;1 &sbar=Scrollbars;list;,Auto,Yes,No &asize=Auto Size;list;,Yes,No &aheight=Auto Height;list;,Yes,No &awidth=Auto Width;list;,Yes,No &stretch=Stretch To Fit;list;,Yes,No &class=Class;string &style=Style;string &attrib=Attributes;string';
          widgetParams['datagrid'] = '&cols=Column Names;string &flds=Field Names;string &cwidth=Column Widths;string &calign=Column Alignments;string &ccolor=Column Colors;string &ctype=Column Types;string &cpad=Cell Padding;int;1 &cspace=Cell Spacing;int;1 &rowid=Row ID Field;string &rgf=Row Group Field;string &rgstyle = Row Group Style;string &rgclass = Row Group Class;string &rowsel=Row Select;string &rhigh=Row Hightlight;string; &psize=Page Size;int;100 &ploc=Pager Location;list;top-right,top-left,bottom-left,bottom-right,both-right,both-left; &pclass=Pager Class;string &pstyle=Pager Style;string &head=Header Text;string &foot=Footer Text;string &tblc=Grid Class;string &tbls=Grid Style;string &itmc=Item Class;string &itms=Item Style;string &aitmc=Alt Item Class;string &aitms=Alt Item Style;string &chdrc=Column Header Class;string &chdrs=Column Header Style;string;&egmsg=Empty message;string;No records found;';
          widgetParams['richtext'] = '&w=Width;string;100% &h=Height;string;300px &edt=Editor;list;<?php echo get_by_key($events, 'OnRichTextEditorRegister'); ?>';
          widgetParams['image'] = '&alttext=Alternate Text;string &hspace=H Space;int &vspace=V Space;int &borsize=Border Size;int &align=Align;list;none,baseline,top,middle,bottom,texttop,absmiddle,absbottom,left,right &name=Name;string &class=Class;string &id=ID;string &style=Style;string &attrib=Attributes;string';
          widgetParams['custom_widget'] = '&output=Output;textarea;[+value+]';

          // Current Params
          var currentParams = {};
          var lastdf, lastmod = {};

          function showParameters(ctrl)
          {
            var c, p, df, cp;
            var ar, desc, value, key, dt;

            currentParams = {}; // reset;

            if (ctrl && ctrl.form) {
              f = ctrl.form;
            } else {
              f = document.forms['mutate'];
              if (!f) return;
              ctrl = f.display;
            }
            cp = f.params.value.split('&'); // load current setting once

            // get display format
            df = lastdf = ctrl.options[ctrl.selectedIndex].value;

            // load last modified param values
            if (lastmod[df]) cp = lastmod[df].split('&');
            for (p = 0; p < cp.length; p++) {
              cp[p] = (cp[p] + '').replace(/^\s|\s$/, ''); // trim
              ar = cp[p].split('=');
              currentParams[ar[0]] = ar[1];
            }

            // setup parameters
            var tr = document.getElementById('displayparamrow'), t, td,
                dp = (widgetParams[df]) ? widgetParams[df].split('&') : '';
            if (!dp) {
              tr.style.display = 'none';
            } else {
              t = '<table class="displayparams"><thead><tr><td width="50%"><?php echo e(ManagerTheme::getLexicon('parameter')); ?></td><td width="50%"><?php echo e(ManagerTheme::getLexicon('value')); ?></td></tr></thead>';
              for (p = 0; p < dp.length; p++) {
                dp[p] = (dp[p] + '').replace(/^\s|\s$/, ''); // trim
                ar = dp[p].split('=');
                key = ar[0];     // param
                ar = (ar[1] + '').split(';');
                desc = ar[0];   // description
                dt = ar[1];     // data type
                value = decode((currentParams[key]) ? currentParams[key] : (dt === 'list') ? ar[3] : (ar[2]) ? ar[2] : '');
                if (value !== currentParams[key]) currentParams[key] = value;
                value = (value + '').replace(/^\s|\s$/, ''); // trim
                value = value.replace(/\"/g, '&quot;'); // replace double quotes with &quot;
                if (dt) {
                  switch (dt) {
                    case 'int':
                    case 'float':
                      c = '<input type="text" name="prop_' + key + '" value="' + value + '" size="30" onchange="setParameter(\'' + key + '\',\'' + dt + '\',this)" />';
                      break;
                    case 'list':
                      c = '<select name="prop_' + key + '" onchange="setParameter(\'' + key + '\',\'' + dt + '\',this)">';
                      var ls = (ar[2] + '').split(',');
                      if (!currentParams[key] || currentParams[key] === 'undefined') {
                        currentParams[key] = ls[0]; // use first list item as default
                      }
                      for (var i = 0; i < ls.length; i++) {
                        c += '<option value="' + ls[i] + '"' + ((ls[i] === value) ? ' selected="selected"' : '') + '>' + ls[i] + '</option>';
                      }
                      c += '</select>';
                      break;
                    case 'textarea':
                      c = '<textarea class="inputBox phptextarea" name="prop_' + key + '" cols="25" style="width:220px;" onchange="setParameter(\'' + key + '\',\'' + dt + '\',this)" >' + value + '</textarea>';
                      break;
                    default:  // string
                      c = '<input type="text" name="prop_' + key + '" value="' + value + '" size="30" onchange="setParameter(\'' + key + '\',\'' + dt + '\',this)" />';
                      break;
                  }
                  t += '<tr><td bgcolor="#FFFFFF" width="50%">' + desc + '</td><td bgcolor="#FFFFFF" width="50%">' + c + '</td></tr>';
                }
                ;
              }
              t += '</table>';
              td = (document.getElementById) ? document.getElementById('displayparams') : document.all['displayparams'];
              td.innerHTML = t;
              tr.style.display = '';
            }
            implodeParameters();
          }

          function setParameter(key, dt, ctrl)
          {
            var v;
            if (!ctrl) return null;
            switch (dt) {
              case 'int':
                ctrl.value = parseInt(ctrl.value);
                if (isNaN(ctrl.value)) ctrl.value = 0;
                v = ctrl.value;
                break;
              case 'float':
                ctrl.value = parseFloat(ctrl.value);
                if (isNaN(ctrl.value)) ctrl.value = 0;
                v = ctrl.value;
                break;
              case 'list':
                v = ctrl.options[ctrl.selectedIndex].value;
                break;
              case 'textarea':
                v = ctrl.value + '';
                break;
              default:
                v = ctrl.value + '';
                break;
            }
            currentParams[key] = v;
            implodeParameters();
          }

          function resetParameters()
          {
            document.mutate.params.value = '';
            lastmod[lastdf] = '';
            showParameters();
          }

          // implode parameters
          function implodeParameters()
          {
            var v, p, s = '';
            for (p in currentParams) {
              v = currentParams[p];
              if (v) s += '&' + p + '=' + encode(v);
            }
            document.forms['mutate'].params.value = s;
            if (lastdf) lastmod[lastdf] = s;
          }

          function encode(s)
          {
            s = s + '';
            s = s.replace(/\=/g, '%3D'); // =
            s = s.replace(/\&/g, '%26'); // &
            return s;
          }

          function decode(s)
          {
            s = s + '';
            s = s.replace(/\%3D/g, '='); // =
            s = s.replace(/\%26/g, '&'); // &
            return s;
          }

          document.addEventListener('DOMContentLoaded', function() {
            var h1help = document.querySelector('h1 > .help');
            h1help.onclick = function() {
              document.querySelector('.element-edit-message').classList.toggle('show');
            };
          });

        </script>
    <?php $__env->stopPush(); ?>

    <form name="mutate" method="post" action="index.php" enctype="multipart/form-data">
        <?php echo get_by_key($events, 'OnTVFormPrerender'); ?>


        <input type="hidden" name="id" value="<?php echo e($data->getKey()); ?>">
        <input type="hidden" name="a" value="302">
        <input type="hidden" name="or" value="<?php echo e($origin); ?>">
        <input type="hidden" name="oid" value="<?php echo e($originId); ?>">
        <input type="hidden" name="mode" value="<?php echo e($action); ?>">
        <input type="hidden" name="params" value="<?php echo e($data->display_params); ?>">

        <h1>
            <i class="fa fa-list-alt"></i>
            <?php if($data->name): ?>
                <?php echo e($data->name); ?>

                <small>(<?php echo e($data->getKey()); ?>)</small>
            <?php else: ?>
                <?php echo e(ManagerTheme::getLexicon('new_tmplvars')); ?>

            <?php endif; ?>
            <i class="fa fa-question-circle help"></i>
        </h1>

        <?php echo $__env->make('manager::partials.actionButtons', $actionButtons, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="container element-edit-message">
            <div class="alert alert-info"><?php echo ManagerTheme::getLexicon('tmplvars_msg'); ?></div>
        </div>

        <div class="tab-pane" id="tmplvarsPane">
            <script>
              var tpTmplvars = new WebFXTabPane(document.getElementById('tmplvarsPane'), false);
            </script>

            <div class="tab-page" id="tabGeneral">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('settings_general')); ?></h2>
                <script>tpTmplvars.addTabPage(document.getElementById('tabGeneral'));</script>

                <div class="container container-body">
                    <?php echo $__env->make('manager::form.row', [
                        'for' => 'name',
                        'label' => ManagerTheme::getLexicon('tmplvars_name'),
                        'element' => '<div class="form-control-name clearfix">' .
                            ManagerTheme::view('form.inputElement', [
                                'name' => 'name',
                                'value' => $data->name,
                                'class' => 'form-control-lg',
                                'attributes' => 'onchange="documentDirty=true;" maxlength="50"'
                            ]) .
                            ($modx->hasPermission('save_role')
                            ? '<label class="custom-control" data-tooltip="' . ManagerTheme::getLexicon('lock_tmplvars') . "\n" . ManagerTheme::getLexicon('lock_tmplvars_msg') .'">' .
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
                        'name' => 'caption',
                        'id' => 'caption',
                        'label' => ManagerTheme::getLexicon('tmplvars_caption'),
                        'value' => $data->caption,
                        'attributes' => 'onchange="documentDirty=true;" maxlength="80"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('manager::form.input', [
                        'name' => 'description',
                        'id' => 'description',
                        'label' => ManagerTheme::getLexicon('tmplvars_description'),
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

                    <?php echo $__env->make('manager::form.select', [
                        'name' => 'type',
                        'id' => 'type',
                        'label' => ManagerTheme::getLexicon('tmplvars_type'),
                        'value' => $data->type,
                        'options' => $types,
                        'attributes' => 'onchange="documentDirty=true;"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('manager::form.textarea', [
                        'name' => 'elements',
                        'id' => 'elements',
                        'label' => ManagerTheme::getLexicon('tmplvars_elements'),
                        'small' => ManagerTheme::getLexicon('tmplvars_binding_msg'),
                        'value' => $data->elements,
                        'attributes' => 'onchange="documentDirty=true;"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('manager::form.textarea', [
                        'name' => 'default_text',
                        'id' => 'default_text',
                        'label' => ManagerTheme::getLexicon('tmplvars_default'),
                        'small' => ManagerTheme::getLexicon('tmplvars_binding_msg'),
                        'value' => $data->default_text,
                        'attributes' => 'onchange="documentDirty=true;"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('manager::form.select', [
                        'name' => 'display',
                        'id' => 'display',
                        'label' => ManagerTheme::getLexicon('tmplvars_widget'),
                        'value' => $data->display,
                        'first' => [
                            'text' => ''
                        ],
                        'options' => $display,
                        'attributes' => 'onchange="documentDirty=true;showParameters(this);"'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="row form-row" id="displayparamrow">
                        <label class="col-md-3 col-lg-2"><?php echo e(ManagerTheme::getLexicon('tmplvars_widget_prop')); ?><br />
                            <a href="javascript:;" onclick="resetParameters(); return false">
                                <i class="<?= $_style['actions_refresh'] ?>"
                                    data-tooltip="<?php echo e(ManagerTheme::getLexicon('tmplvars_reset_params')); ?>"></i>
                            </a>
                        </label>
                        <div id="displayparams" class="col-md-9 col-lg-10"></div>
                    </div>

                <?php echo $__env->make('manager::form.input', [
                    'name' => 'rank',
                    'id' => 'rank',
                    'label' => ManagerTheme::getLexicon('tmplvars_rank'),
                    'value' => (isset($data->rank) ? $data->rank : 0),
                    'attributes' => 'onchange="documentDirty=true;" maxlength="4" size="1"'
                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <!-- Access Permissions -->

                </div>
            </div>

            <div class="tab-page" id="tabTemplates">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('manage_templates')); ?></h2>
                <script>tpTmplvars.addTabPage(document.getElementById('tabTemplates'));</script>

                <div class="container container-body">
                    <p><?php echo e(ManagerTheme::getLexicon('tmplvar_tmpl_access_msg')); ?></p>
                    <div class="form-group">
                        <a class="btn btn-secondary btn-sm" href="javascript:;"
                            onclick="check_all();return false;"><?php echo e(ManagerTheme::getLexicon('check_all')); ?></a>
                        <a class="btn btn-secondary btn-sm" href="javascript:;"
                            onclick="check_none();return false;"><?php echo e(ManagerTheme::getLexicon('check_none')); ?></a>
                        <a class="btn btn-secondary btn-sm" href="javascript:;"
                            onclick="check_toggle(); return false;"><?php echo e(ManagerTheme::getLexicon('check_toggle')); ?></a>
                    </div>

                    <?php if(isset($tplOutCategory) && $tplOutCategory->count() > 0): ?>
                        <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => 'tv_in_template', 'id' => 0, 'title' => ManagerTheme::getLexicon('no_category')]); ?>
                            <ul>
                                <?php /** @var EvolutionCMS\Models\SiteTemplate $item */ ?>
                                <?php $__currentLoopData = $tplOutCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('manager::page.tmplvar.template', ['item' => $item, 'selected' => $controller->isSelectedTemplate($item)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php echo $__env->renderComponent(); ?>
                    <?php endif; ?>

                    <?php if(isset($categoriesWithTpl)): ?>
                        <?php $__currentLoopData = $categoriesWithTpl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => 'tv_in_template', 'id' => $cat->id, 'title' => $cat->name]); ?>
                                <ul>
                                    <?php $__currentLoopData = $cat->templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('manager::page.tmplvar.template', ['item' => $item, 'selected' => $controller->isSelectedTemplate($item)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php echo $__env->renderComponent(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(get_by_key($modx->config, 'use_udperms') == 1 && $modx->hasPermission('access_permissions')): ?>
                <div class="tab-page" id="tabAccess">
                    <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('access_permissions')); ?></h2>
                    <script>tpTmplvars.addTabPage(document.getElementById('tabAccess'));</script>

                    <div class="container container-body">
                        <?php
                        // fetch permissions for the variable
                        $rs = $modx->getDatabase()
                            ->select('documentgroup', $modx->getDatabase()
                                ->getFullTableName('site_tmplvar_access'), "tmplvarid='{$data->getKey()}'");
                        $groupsarray = $modx->getDatabase()
                            ->getColumn('documentgroup', $rs);
                        ?>
                        <script>
                          function makePublic(b)
                          {
                            var notPublic = false;
                            var f = document.forms['mutate'];
                            var chkpub = f['chkalldocs'];
                            var chks = f['docgroups[]'];
                            if (!chks && chkpub) {
                              chkpub.checked = true;
                              return false;
                            }
                            else if (!b && chkpub) {
                              if (!chks.length) {
                                notPublic = chks.checked;
                              } else {
                                for (var i = 0; i < chks.length; i++) {
                                  if (chks[i].checked) notPublic = true;
                                }
                              }
                              chkpub.checked = !notPublic;
                            }
                            else {
                              if (!chks.length) {
                                chks.checked = (b) ? false : chks.checked;
                              } else {
                                for (var i = 0; i < chks.length; i++) {
                                  if (b) chks[i].checked = false;
                                }
                              }
                              chkpub.checked = true;
                            }
                          }
                        </script>

                        <p><?php echo e(ManagerTheme::getLexicon('tmplvar_access_msg')); ?></p>

                        <?php

                        $tbl_documentgroup_names = $modx->getDatabase()
                            ->getFullTableName('documentgroup_names');

                        $chks = '';
                        $rs = $modx->getDatabase()
                            ->select('name, id', $tbl_documentgroup_names);

                        if (empty($groupsarray) && isset($_POST['docgroups']) && is_array($_POST['docgroups']) && empty($_POST['id'])) {
                            $groupsarray = $_POST['docgroups'];
                        }

                        while ($row = $modx->getDatabase()
                            ->getRow($rs)) {
                            $checked = in_array($row['id'], $groupsarray);
                            if ($modx->hasPermission('access_permissions')) {
                                if ($checked) {
                                    $notPublic = true;
                                }
                                $chks .= "<li><label><input type='checkbox' name='docgroups[]' value='" . $row['id'] . "' " . ($checked ? "checked='checked'" : '') . " onclick=\"makePublic(false)\" /> " . $row['name'] . "</label></li>";
                            } else {
                                if ($checked) {
                                    echo "<input type='hidden' name='docgroups[]'  value='" . $row['id'] . "' />";
                                }
                            }
                        }

                        if ($modx->hasPermission('access_permissions')) {
                            $chks = "<li><label><input type='checkbox' name='chkalldocs' " . (empty($notPublic) ? "checked='checked'" : '') . " onclick=\"makePublic(true)\" /> <span class='warning'>" . $_lang['all_doc_groups'] . "</span></label></li>" . $chks;
                        }

                        echo '<ul>' . $chks . '</ul>';

                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <input type="submit" name="save" style="display:none">

            <?php echo get_by_key($events, 'OnTVFormRender'); ?>

        </div>
    </form>
    <script>setTimeout('showParameters()', 10);</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager::template.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>