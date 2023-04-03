<div class="card">
    <div class="card-header">
        <h2 class="dark">Manage Layouts<small>Here is a list of layouts. You can add new layouts by clicking on the Add button below, or edit or delete existing ones by clicking its corresponding Edit or Delete icon.</small></h2>
    </div>
    <div class="card-body m-t-0">
        <div class="p-t-0 p-l-25 p-r-25 p-b-25">
            <?php if (!empty($notice) || !empty($error) || !empty($success)): ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($notice)): ?>
                    <div class="alert alert-info"><?php echo $notice; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($tabledata['page_data'])): ?>
                    <?php echo material_datatable($tabledata, $show_ids); ?>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div role="alert" class="alert alert-danger">We could not find any attributes to list.</div>
                                <a class="btn btn-primary" href="__BASE__content/add_layout/">Add a new layout</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
