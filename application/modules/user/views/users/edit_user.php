<div class="card">
    <?php general_prompt($data, false); ?>
    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
        <?php echo kcms_form_open($fields['form_open']); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['user_username']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['user_email']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['user_password'], 'password'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['user_confirm'], 'password'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_select($fields['user_roles']); ?>
            </div>
            <div class="col-sm-12 col-md-6" style="margin-top: 64px;">
                <?php echo kcms_form_button($fields['user_role_add']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_select($fields['user_active']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_select($fields['user_locked']); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <input type="hidden" name="id" value="<?php echo $item[0]['id']; ?>">
                <?php echo kcms_form_submit($fields['user_submit']); ?>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
<div id="add_user_role" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card" style="box-shadow: none !important; margin-bottom: 0px !important">
                    <?php general_prompt($messages_role, false); ?>
                    <?php echo kcms_form_open($fields_role['form_role_open']); ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <?php echo kcms_form_input($fields_role['user_role_role']); ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <?php echo kcms_form_button($fields_role['user_role_submit']); ?>
                        </div>
                    </div>
                    <?php echo kcms_form_close($fields_role['form_close']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#role_submit').click(function(){
            var theUrl = "<?php echo base_url(); ?>user/add_user_role/" + encodeURIComponent($('#user_role').val());
            $.ajax({
                type: "POST",
                dataType: "json",
                url: theUrl,
                cache: false,
                success: function(data) {
                    if (data.id == 0) {
                        alert('We could not add the role. Please contact support.');
                    } else {
                        $('#add_user_role').modal('hide');
                        $('#roles').append('<option value="' + data.id + '">' + data.role + '</option>');
                        $('#roles').val(data.id);
                        $('#roles').trigger('change.select2');
                        $('#user_role').val('');
                    }
                },
                error: function(data) {
                    alert('We could not add the role. Please contact support.');
                }
            });
        });
    });
</script>
