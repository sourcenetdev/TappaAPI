<div class="card">
    <?php if (!empty($hint['heading']) || !empty($hint['message'])): ?>
    <div class="card-header bgm-dark text-white">
        <h2>
            <?php echo (!empty($hint['heading']) ? $hint['heading'] : ''); ?>
            <small><?php echo (!empty($hint['message']) ? $hint['message'] : ''); ?></small>
        </h2>
    </div>
    <?php endif; ?>
    <div class="card-body">
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
        <div class="m-t-20 p-t-0 p-l-25 p-r-25 p-b-25">
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($tabledata['page_data'])): ?>
                    <?php echo kcms_form_datatable($tabledata); ?>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div role="alert" class="alert alert-danger"><?php echo $empty_message; ?></div>
                            <a class="btn btn-primary" href="__BASE__user/add_user/"><?php echo $empty_button; ?></a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
