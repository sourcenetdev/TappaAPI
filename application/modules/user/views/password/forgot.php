<div class="card">
    <div class="card-header bgm-dark text-white">
        <h2>
            <?php echo lang('user_user_forgot_head'); ?>
            <small><?php echo lang('user_user_forgot_prompt'); ?></small>
        </h2>
    </div>
    <div class="card-body m-t-0">
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
        <div class="m-t-0 p-t-0 p-l-25 p-r-25 p-b-25">
            <?php echo kcms_form_open($fields['form_open']); ?>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <?php echo kcms_form_input($fields['password_forgot_email']); ?>
                </div>
            </div>
            <div class="row"><div class="col-sm-12 col-md-6">&nbsp;</div></div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <?php echo kcms_form_submit($fields['password_forgot_submit']); ?>
                </div>
            </div>
            <?php echo kcms_form_close($data['fields']['form_close']); ?>
        </div>
    </div>
</div>
