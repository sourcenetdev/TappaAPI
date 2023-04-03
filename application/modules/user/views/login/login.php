<?php if (!empty($success) || !empty($error)): ?>
<div class="row">
    <div class="col-sm-12">
        <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
        <?php echo kcms_form_open($fields['form_open']); ?>
        <div class="text-center">
            <img style="margin: 32px auto 0 auto; width: 100px;" src="<?php echo base_url() ?>assets/images/logo_transparent.png"><br>
            <h2 class="secondary-paragraph">Log in</h2>
            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
            <p class="secondary-paragraph"><?php echo lang('user_user_access_prompt'); ?></p>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['login_username']); ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <?php echo kcms_form_input($fields['login_password'], 'password'); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php echo kcms_form_submit($fields['login_submit']); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12" style="border-top: 1px solid #D10412">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="<?php echo base_url(); ?>forgot-password" class="btn btn-tertiary m-l-10">I forgot my password</a>
                <a href="<?php echo base_url(); ?>register" class="btn btn-tertiary m-l-10">I do not have an account</a>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
