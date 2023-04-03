<div class="card">
    <div class="card-header">
        <h2 class="dark">REGISTER<small>You have successfully registered.</small></h2>
    </div>
    <div class="card-body m-t-0">
        <div class="p-t-0 p-l-25 p-r-25 p-b-25">
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
        </div>
    </div>
</div>
