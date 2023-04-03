<div class="card">
    <?php general_prompt($data, false); ?>
    <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (!empty($notice)): ?>
    <div class="alert alert-notice"><?php echo $notice; ?></div>
    <?php endif; ?>
    <?php if (!empty($warning)): ?>
    <div class="alert alert-warning"><?php echo $warning; ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($primary['form_open']); ?>
        <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
                <ul class="tab-nav" role="tablist" data-tab-color="red">
                    <?php
                        $counter = 0;
                        $tabs = [];
                        foreach ($form_info as $k => $v) {
                            $class = '';
                            if ($counter == 0) {
                                $class = ' class="active"';
                            }
                            if (!in_array($v['tab_name'], $tabs)) {
                                echo '<li' . $class . '><a href="#tab_' . $v['tab_name'] . '" aria-controls="tab_' . $v['tab_name'] . '" role="tab" data-toggle="tab">' . $v['tab_name'] . '</a></li>';
                                $tabs[] = $v['tab_name'];
                            }
                            $counter++;
                        }
                    ?>
                </ul>
                <div class="tab-content" style="height: 300px; overflow-x: hidden; overflow-y: auto;">
                    <?php
                    $counter = 0;
                        foreach ($tabs as $k => $v) {
                            $class = '';
                            if ($counter == 0) {
                                $class = ' active';
                            }
                            echo '<div role="tabpanel" class="tab-pane' . $class . '" id="tab_' . $v . '">';
                            foreach ($form_info as $kk => $vv) {
                                if ($vv['tab_name'] == $v && isset($secondary[$kk]['id'])) {
                                    echo '
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">' . $vv['field_type']($secondary[$kk]) . '</div>
                                        </div>
                                    ';
                                }
                            }
                            echo '</div>';
                            $counter++;
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 text-center">
                        <ul class="pagination wizard">
                            <li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
                            <li class="previous"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-left"></i></a></li>
                            <li class="next"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-right"></i></a></li>
                            <li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <?php echo kcms_form_submit($primary['settings_submit']) ?>
                </div>
            </div>
        </div>
        <?php echo kcms_form_close($primary['form_close']); ?>
    </div>
</div>
