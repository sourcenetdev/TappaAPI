<!DOCTYPE html>
<html lang="en">
<head>
    {{{headtags}}}
    {{{templatedata:head}}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>

    <!-- Header -->
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="logo" class="pull-left hero-logo">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="__BASE__view/welcome">
                                    <img class="hidden-xs hidden-sm" src="__BASE__assets/images/kcms_logo.png" alt="__SITENAME__" title="__SITENAME__" /></img>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <p style="font-size: 150%; margin-top: 20px;">{{{variable:system_name}}}</p>
                            </div>
                        </div>
                        <a style="position: relative; left: -9999px !important" href="__BASE__view/welcome#maincontent"><h1>{{{variable:system_name}}}</h1></a>
                    </div>
                    <nav id="nav-menu-container" style="background-color: #ffffff; color: #333333;">
                        <ul class="nav-menu">
                            <li><a href="__BASE__view/welcome">Home</a></li>
                            <li><a href="__BASE__view/welcome#modules">Modules</a></li>
                            <li><a href="__BASE__view/welcome#features">Features</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <a id="top"></a>
    <div id="maincontent" style="margin-top: 110px;">
        <div id="preloader"></div>
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{{block:welcome_to_kyrandia}}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php _set_provider_facebook(); ?>
                    </div>
                </div>
            </div>
        </section>
        <section id="services">
            <div class="container">
                <div id="modules" class="row">
                    <div class="col-md-12">
                        {{{block:some_modules_available}}}
                    </div>
                </div>
                <p>&nbsp;</p>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="dark">Features</h2>
                    </div>
                </div>
                <div id="features" class="row">
                    <div class="col-md-4">
                        {{{block:full_administration_area}}}
                    </div>
                    <div class="col-md-4">
                        {{{block:translation_system}}}
                    </div>
                    <div class="col-md-4">
                        {{{block:extended_hooks_system}}}
                    </div>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            &copy; Copyright <strong>{{{variable:system_name}}}</strong>, <?php echo date('Y'); ?>, all rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </div>
    {{{templatedata:body}}}
</body>
</html>
