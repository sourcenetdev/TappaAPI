<div class="card">
    <?php general_prompt($data, false); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($fields['form_open']); ?>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <?php echo kcms_form_select($fields['global_headtag_headtag_id']); ?>
            </div>
            <div class="col-sm-12 col-md-9" id="additional_tags" style="display: none;">
                <div id="additional_tags_fields" class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_select($fields['global_headtag_active']); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_submit($fields['global_headtag_submit']) ?>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        // Custom metadata section change.
        $('#headtag_id').change(function(e){
            $('#additional_tags').show();
            e.preventDefault();
            var base_url = '<?php echo base_url(); ?>seo/build_meta_element_group/';
            $.ajax(base_url, {
                type: 'POST',
                success: function(response) {
                    if (response) {
                        $('#additional_tags_fields').append($.parseJSON(response));
                    }
                }
            });
        });

        // Form initialize tags.
        <?php if (!empty($this->input->post('headtag_id'))): ?>
        $('#additional_tags').show();
        var base_url = '<?php echo base_url(); ?>seo/build_meta_element_group/';
        $.ajax(base_url, {
            type: 'POST',
            data: <?php echo json_encode(_post()); ?>,
            success: function(response) {
                if (response) {
                    $('#additional_tags_fields').append($.parseJSON(response));
                }
            }
        });
        <?php endif; ?>
    });
</script>