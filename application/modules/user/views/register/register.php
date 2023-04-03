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
            <h2 class="secondary-paragraph">Register</h2>
            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
            <p class="secondary-paragraph">Please enter your details to register.</p>
        </div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo kcms_form_input($fields['register_username']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo kcms_form_input($fields['register_email']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo kcms_form_input($fields['register_password'], 'password'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo kcms_form_input($fields['register_confirm'], 'password'); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php echo kcms_form_submit($fields['register_submit']); ?>
            </div>
        </div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12" style="border-top: 1px solid #D10412">&nbsp;</div></div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="<?php echo base_url(); ?>forgot-password" class="btn btn-tertiary m-l-10">I forgot my password</a>
                <a href="<?php echo base_url(); ?>login" class="btn btn-tertiary m-l-10">I already have an account</a>
            </div>
        </div>
        <?php echo kcms_form_close($fields['form_close']); ?>
    </div>
</div>
