<div class="card control-panel">
    <div class="card-header bgm-dark text-white">
        <h2>
            <?php echo lang('user_user_control_panel_head'); ?>
            <small>This is your control panel. Here you can see all the information related to your account, and do general maintenance such as changing your password.</small>
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

        <div class="p-t-0 p-l-25 p-r-25 p-b-25">
            <div class="row m-b-25"><div class="col-sm-12 col-md-12"></div></div>
            <div class="row m-b-25">
                <div class="col-sm-12 col-md-12">
                    <div class="mini-charts">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-lightgreen">
                                    <div class="clearfix">
                                        <div class="chart stats-bar"></div>
                                        <div class="count">
                                            <small>Website Traffics</small>
                                            <h2>987,459</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-purple">
                                    <div class="clearfix">
                                        <div class="chart stats-bar-2"></div>
                                        <div class="count">
                                            <small>Website Impressions</small>
                                            <h2>356,785K</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-orange">
                                    <div class="clearfix">
                                        <div class="chart stats-line"></div>
                                        <div class="count">
                                            <small>Total Sales</small>
                                            <h2>$ 458,778</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-bluegray">
                                    <div class="clearfix">
                                        <div class="chart stats-line-2"></div>
                                        <div class="count">
                                            <small>Support Tickets</small>
                                            <h2>23,856</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-widgets">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div id="site-visits" class="dw-item bgm-teal">
                                    <div class="dwi-header">
                                        <div class="p-30">
                                            <div class="dash-widget-visits"></div>
                                        </div>

                                        <div class="dwih-title">For the past 30 days</div>
                                    </div>

                                    <div class="list-group lg-even-white">
                                        <div class="list-group-item media sv-item">
                                            <div class="pull-right">
                                                <div class="stats-bar"></div>
                                            </div>
                                            <div class="media-body">
                                                <small>Page Views</small>
                                                <h3>47,896,536</h3>
                                            </div>
                                        </div>

                                        <div class="list-group-item media sv-item">
                                            <div class="pull-right">
                                                <div class="stats-bar-2"></div>
                                            </div>
                                            <div class="media-body">
                                                <small>Site Visitors</small>
                                                <h3>24,456,799</h3>
                                            </div>
                                        </div>

                                        <div class="list-group-item media sv-item">
                                            <div class="pull-right">
                                                <div class="stats-line"></div>
                                            </div>
                                            <div class="media-body">
                                                <small>Total Clicks</small>
                                                <h3>13,965</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div id="pie-charts" class="dw-item bgm-cyan c-white">

                                    <div class="dw-item">
                                        <div class="dwi-header">
                                            <div class="dwih-title">Email Statistics</div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="text-center p-20 m-t-25">
                                            <div class="easy-pie main-pie" data-percent="75">
                                                <div class="percent">45</div>
                                                <div class="pie-title">Total Emails Sent</div>
                                            </div>
                                        </div>

                                        <div class="p-t-25 p-b-20 text-center">
                                            <div class="easy-pie sub-pie-1" data-percent="56">
                                                <div class="percent">56</div>
                                                <div class="pie-title">Bounce Rate</div>
                                            </div>
                                            <div class="easy-pie sub-pie-2" data-percent="84">
                                                <div class="percent">84</div>
                                                <div class="pie-title">Total Opened</div>
                                            </div>
                                            <div class="easy-pie sub-pie-2" data-percent="21">
                                                <div class="percent">21</div>
                                                <div class="pie-title">Total Ignored</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="dw-item bgm-lime">
                                    <div id="weather-widget"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-b-25">
                <div class="col-sm-12 col-md-12">
                    <h2 class="darksec">
                        Access details
                        <small>The information below explains who you are logged in as, and what access you have within the system.</small>
                    </h2>
                    <div class="row m-t-15 m-b-15"></div>
                    <?php if (!empty(trim($logged_user['username']))): ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-2"><p class="secondary-paragraph role-label"><strong>You are logged in as:</strong></p></div>
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <span class="role-button" disabled="disabled"><?php echo $logged_user['username']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user_roles)): ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-2"><p class="secondary-paragraph role-label"><strong>You have the following roles:</strong></p></div>
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <?php foreach ($user_roles as $v): ?>
                                    <span class="role-button" disabled="disabled"><?php echo $v; ?></span>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user_permissions) && config_item('show_effective_permissions')): ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-2"><p class="secondary-paragraph role-label"><strong>Your effective permissions:</strong></p></div>
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <?php foreach ($user_permissions as $v): ?>
                                    <span class="role-button" disabled="disabled"><?php echo $v; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row m-t-20"></div>
                    <div class="row m-t-20"></div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="row m-b-25">
                        <div class="col-sm-12">
                            <h2 class="darksec">
                                Session Information
                                <small>This table shows your login activity (if available).</small>
                            </h2>
                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                            <?php if (!empty($tabledata['page_data'])): ?>
                            <?php echo kcms_form_datatable($tabledata); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
