<div class="card">
    <div class="card-header bgm-dark text-white">
        <h2>
            <?php echo lang('user_user_password_changed_head'); ?>
            <small><?php echo lang('user_user_password_changed_prompt'); ?></small>
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
        </div>
    </div>
</div>