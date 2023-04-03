<div class="card">
    <?php general_prompt($data); ?>
    <div class="card-body m-t-0">
        <div class="p-t-0 p-l-25 p-r-25 p-b-25">
            <?php echo kcms_form_open($fields['form_open']); ?>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_submit($fields['layout_submit']); ?>&nbsp;
                    <a class="btn btn-info" href="__BASE__content/list_layouts_data">Go back to the layouts listing.</a>
                    <?php echo material_form_hidden(array('id' => 'confirm', 'value' => 'Yes')); ?>
                </div>
            </div>
            <?php echo kcms_form_close($data['fields']['form_close']); ?>
        </div>
    </div>
</div>
