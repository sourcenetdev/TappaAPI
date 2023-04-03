<?php
    $success = $this->session->userdata('success');
    $warning = $this->session->userdata('warning');
    $errors = $this->session->userdata('errors');
?>
<?php if (!empty($success) || !empty($warning) || !empty($errors)): ?>
<div class="row">
    <div class="col-sm-12">
        <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($warning)): ?>
        <div class="alert alert-warning"><?php echo $warning; ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?php echo $errors; ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-4" style="overflow: hidden">
        {{{templatecontent:layout:left}}}
    </div>
    <div class="col-sm-4" style="overflow: hidden">
        {{{templatecontent:layout:center}}}
    </div>
    <div class="col-sm-4" style="overflow: hidden">
        {{{templatecontent:layout:right}}}
    </div>
</div>
