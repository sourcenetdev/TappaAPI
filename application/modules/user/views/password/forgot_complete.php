<div class="card">
    <div class="card-header bgm-dark text-white">
        <h2>
            <?php echo lang('user_user_password_reset_head'); ?>
            <small><?php echo lang('user_user_password_reset_prompt'); ?></small>
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
            <div class="row">
                <div class="col-sm-12">
                    <p><?php sprintf(lang('user_user_password_reset_info'), config_item('temp_password_validity')); ?></p>
                    <a href="<?php echo base_url() ?>login" class="btn btn-primary"><?php echo lang('user_user_password_reset_button'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
