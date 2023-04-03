<div class="card">
    <?php general_prompt($data, false); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($fields['form_open']); ?>
        <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
                <ul class="tab-nav" role="tablist" data-tab-color="red">
                    <li class="active"><a href="#tab_basic" aria-controls="tab_basic" role="tab" data-toggle="tab">Basic information</a></li>
                    <li><a href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab">Content</a></li>
                    <li><a href="#tab_headtags" aria-controls="tab_headtags" role="tab" data-toggle="tab">Head tags and SEO</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_basic">
                        <h2 class="darksec">Basic page information</h2>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php echo kcms_form_input($fields['page_name']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php echo kcms_form_select($fields['page_theme']); ?>
                            </div>
                        </div>
                        <div id="theme_display" class="row" style="display: none;">
                            <div class="col-sm-12 col-md-6">
                                <img style="max-width: 200px;" id="theme_image" src="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php echo kcms_form_select($fields['page_layout']); ?>
                            </div>
                        </div>
                        <div id="layout_display" class="row" style="display: none;">
                            <div class="col-sm-12 col-md-6">
                                <img style="max-width: 200px;" id="layout_image" src="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php echo kcms_form_select($fields['page_active']); ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab_content">
                        <h2 id="content_head" class="darksec">Page content <small>If this tab is empty, select a theme and/or a layout first.</small></h2>
                        <div id="theme_area_container">
                            <div class="row">
                                <div id="theme_container" class="col-sm-12">
                                    <?php if (!empty($theme_areas)): ?>
                                    <?php foreach ($theme_areas as $k => $v):  ?>
                                    <div class="row theme-editor" style="display: none;" id="theme_editor_<?php echo $v['id']; ?>">
                                        <div class="col-sm-12">
                                            <?php echo kcms_form_summernote($v); ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div id="layout_area_container">
                            <div class="row">
                                <div id="layout_container" class="col-sm-12">
                                    <?php if (!empty($layout_areas)): ?>
                                    <?php foreach ($layout_areas as $k => $v):  ?>
                                    <div class="row layout-editor" style="display: none;" id="layout_editor_<?php echo $v['id']; ?>">
                                        <div class="col-sm-12">
                                            <?php echo kcms_form_summernote($v); ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab_headtags">
                        <h2 class="darksec">Head tags and SEO</h2>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <p><br><a href="#" id="meta_add"><i class="zmdi zmdi-plus-circle zmdi-hc-lg mdc-text-green"></i>&nbsp;&nbsp;Add additional head tags to this page.</a></p>
                                <p>After adding a tag by clicking the link above, select the head tag, and enter its corresponding value in the text field next to it.</p>
                            </div>
                        </div>
                        <div class="row" id="additional_tags" style="display: none;">
                            <div id="additional_tags_fields" class="col-sm-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_submit($fields['page_submit']); ?>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        // Theme and layout images and theme area content sections.
        var theme_id = $('#theme_id').val();
        var layout_id = $('#layout_id').val();
        var theme_areas = $('#theme_areas').val();
        var layout_areas =  $('#layout_areas').val();
        if (typeof(theme_id) != 'undefined' && theme_id != 0) {
            $('#theme_image').attr('src', "<?php echo base_url(); ?>application/modules/theme/assets/images/themes/" + theme_id + '.png');
            $('#theme_display').show();
        } else {
            $('#theme_display').hide();
        }
        if (typeof(layout_id) != 'undefined' && layout_id != 0) {
            $('#layout_image').attr('src', "<?php echo base_url(); ?>application/modules/layout/assets/images/layouts/" + layout_id + '.png');
            $('#layout_display').show();
        } else {
            $('#layout_display').hide();
        }

        // When changing the theme...
        $('#theme_id').change(function(){
            var theme_id = $(this).val();
            if (typeof(theme_id) != 'undefined' && theme_id != 0) {
                $('#theme_image').attr('src', "<?php echo base_url(); ?>application/modules/theme/assets/images/themes/" + theme_id + '.png');
                $('#theme_display').show();
            } else {
                $('#theme_display').hide();
            }
            $('.theme-editor').hide();
            $('#content_head > small').show();
            <?php if (!empty($theme_areas)): ?>
            <?php $counter = 0; ?>
            <?php foreach ($theme_areas as $k => $v): ?>
            if (theme_id == '<?php echo $v['parent_id']; ?>') {
                $('#theme_editor_<?php echo $v['id']; ?>').show();
                <?php $counter++; ?>
            }
            <?php endforeach; ?>
            <?php if ($counter > 0): ?>
            $('#content_head > small').hide();
            <?php endif; ?>
            <?php endif; ?>
        });

        // When changing the layout.
        $('#layout_id').change(function(){
            var layout_id = $(this).val();
            if (typeof(layout_id) != 'undefined' && layout_id != 0) {
                $('#layout_image').attr('src', "<?php echo base_url(); ?>application/modules/layout/assets/images/layouts/" + layout_id + '.png');
                $('#layout_display').show();
            } else {
                $('#layout_display').hide();
            }
            $('.layout-editor').hide();
            <?php if (!empty($layout_areas)): ?>
            <?php $counter = 0; ?>
            <?php foreach ($layout_areas as $k => $v): ?>
            if (layout_id == '<?php echo $v['parent_id']; ?>') {
                $('#layout_editor_<?php echo $v['id']; ?>').show();
                <?php $counter++; ?>
            }
            <?php endforeach; ?>
            <?php if ($counter > 0): ?>
            $('#content_head > small').hide();
            <?php endif; ?>
            <?php endif; ?>
        });

        // Custom metadata section change.
        $('#meta_add').click(function(e){
            $('#additional_tags').show();
            e.preventDefault();
            var base_url = '<?php echo base_url(); ?>page/ajax_get_page_meta/';
            $.ajax(base_url, {
                type: 'POST',
                success: function(response) {
                    if (response) {
                        $('#additional_tags_fields').append($.parseJSON(response));
                        $("meta").select2({
                            allowClear: true,
                            containerCssClass: "input-group-wide width-100",
                        });
                    }
                }
            });
        });

        // Form initialize editors
        $('.layout-editor').hide();
        <?php if (!empty($layout_areas)): ?>
        <?php foreach ($layout_areas as $k => $v): ?>
        if (layout_id == '<?php echo $v['parent_id']; ?>') {
            $('#layout_editor_<?php echo $v['id']; ?>').show();
        }
        <?php endforeach; ?>
        <?php endif; ?>
        $('.theme-editor').hide();
        <?php if (!empty($theme_areas)): ?>
        <?php foreach ($theme_areas as $k => $v): ?>
        if (theme_id == '<?php echo $v['parent_id']; ?>') {
            $('#theme_editor_<?php echo $v['id']; ?>').show();
        }
        <?php endforeach; ?>
        <?php endif; ?>

        // Form initialize tags.
        <?php if (!empty($this->input->post('meta'))): ?>
        $('#additional_tags').show();
        var base_url = '<?php echo base_url(); ?>page/ajax_get_page_meta/';
        $.ajax(base_url, {
            type: 'POST',
            data: <?php echo json_encode(_post()); ?>,
            success: function(response) {
                if (response) {
                    $('#additional_tags_fields').append($.parseJSON(response));
                    $("meta").select2({
                        allowClear: true,
                        containerCssClass: "input-group-wide width-100",
                    });
                }
            }
        });
        <?php endif; ?>
    });
</script>