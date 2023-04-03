<div class="card">
    <?php general_prompt($data); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($data['fields']['form_open']); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo form_hidden('can_delete', 1); ?>
                <?php echo kcms_form_submit($data['fields']['permission_submit']); ?>&nbsp;
                <a class="btn btn-secondary" href="<?php echo base_url(); ?>user/list_permissions_data"><?php echo $data['messages']['return']; ?></a>
            </div>
        </div>
        <?php echo kcms_form_close($data['fields']['form_close']); ?>
    </div>
</div>
