<div class="card">
    <div class="card-header bgm-dark text-white">
        <h2>
            Access denied
            <small>You do not have access to the requested functionality.</small>
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
                    <?php if (!empty($message)): ?>
                    <h2 class="darksec">Additional information</h2>
                    <p>The server has returned the following status messages:</p>
                    <ul>
                        <?php foreach ($message as $k => $v): ?>
                            <?php echo '<li>' . $v . '</li>'; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <h2 class="darksec">How to resolve this error</h2>
                    <p><strong>Potential causes of this problem:</strong></p>
                    <ul>
                        <li>Your session may have expired. Simply log in again, and check if your access is restored.</li>
                        <li>An administrator may have removed your access for some reason.</li>
                        <li>You have stumbled upon this link by accident or by following a bookmark. This is often possible when multiple people share the same device but have different access levels.</li>
                    </ul>
                    <h2 class="darksec">If none of the above worked:</h2>
                    <ul>
                        <li>Continue to using other functionality of the system, by using the main menu.</li>
                        <li>Contact your administrator.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
