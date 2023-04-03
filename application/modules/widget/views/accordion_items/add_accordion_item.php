<div class="card">
    <?php general_prompt($data, false); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
    <?php echo kcms_form_open($fields['form_open']); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['accordion_item_name']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_textarea($fields['accordion_item_body']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['accordion_item_class']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['accordion_item_icon']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_select($fields['accordion_item_active']); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_submit($fields['accordion_item_submit']) ?>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>