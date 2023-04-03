<!doctype html>
<html>
    <head>

        <!-- Loads page metadata and head CSS and scripts -->
        {{{headtags}}}
        {{{templatedata:head}}}
    </head>
    <body class="template-login">
        <div id="login-background"></div>

        <!-- Main Content Section -->
        <section id="main">

            <!-- Content area -->
            <section id="content">
                <div class="container">
                    <?php echo $contents; ?>
                </div>
            </section>
        </section>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li><a href="http://www.google.com/chrome/"><img src="img/browsers/chrome.png" alt="Chrome"><div>Chrome</div></a></li>
                        <li><a href="https://www.mozilla.org/en-US/firefox/new/"><img src="img/browsers/firefox.png" alt="Firefox"><div>Firefox</div></a></li>
                        <li><a href="http://www.opera.com"><img src="img/browsers/opera.png" alt="Opera"><div>Opera</div></a></li>
                        <li><a href="https://www.apple.com/safari/"><img src="img/browsers/safari.png" alt="Safari"><div>Safari</div></a></li>
                        <li><a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie"><img src="img/browsers/ie.png" alt="Internet Explorer (Latest)"><div>IE (New)</div></a></li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        <!-- Load template body data -->
        {{{templatedata:body}}}

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="<?php echo base_url(); ?>application/views/admin/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
    </body>
</html>
