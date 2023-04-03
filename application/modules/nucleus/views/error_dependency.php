<div class="card">
    <div class="card-header bgm-dark text-white">
        <h2>
            500
            <small>Dependency error.</small>
        </h2>
    </div>
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
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="m-t-20 p-t-0 p-l-25 p-r-25 p-b-25">
            <div class="row">
                <div class="col-sm-12">
                    <p>Unfortunately, it seems like our website has been misconfigured. We have notified our administrators.</p>
                    <?php if (!empty($message)): ?>
                    <h2 class="darksec">Additional information</h2>
                    <p>The server has returned the following status messages:</p>
                    <ul>
                        <?php foreach ($message as $k => $v): ?>
                            <?php echo '<li>' . $v . '</li>'; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <h2 class="darksec">If you are unable to resolve this problem:</h2>
                    <ul>
                        <li>Continue to using other functionality of the system, by using the main menu.</li>
                        <li>Contact your administrator.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
