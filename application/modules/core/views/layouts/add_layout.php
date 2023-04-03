<div class="card">
    <div class="card-header">
        <h2 class="dark">Add Layout<small>Please complete the fields below to add a layout.</small></h2>
    </div>
    <div class="card-body m-t-0">
        <div class="p-t-0 p-l-25 p-r-25 p-b-25">
            <?php echo kcms_form_open($fields['form_open']); ?>
            <?php if (!empty($success) || !empty($errors)): ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger"><?php echo $errors; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_input($fields['layout_name']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_input($fields['layout_file']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_input($fields['layout_areas']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_select($fields['layout_active']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row p-0 p-t-25"><div class="col-sm-12"></div></div>
                    <?php echo material_form_submit($fields['layout_submit']); ?>
                </div>
            </div>
            <?php echo kcms_form_close($data['fields']['form_close']); ?>
        </div>
    </div>
</div>