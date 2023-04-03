<div class="card">
    <?php general_prompt($data, false); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($fields['form_open']); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['global_headtag_headtag']); ?>
            </div>
        </div>
        <?php if (!empty($fields['global_headtag_fields'])): ?>
            <?php foreach ($fields['global_headtag_fields'] as $k => $v): ?>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <?php echo kcms_form_input($v); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
        <?php echo form_hidden('headtag_id', $headtag_id); ?>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
