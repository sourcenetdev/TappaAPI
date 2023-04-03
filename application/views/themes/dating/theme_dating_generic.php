<?php
    require_once('Hielo.php');
    $hielo = new Hielo();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        {{{headtags}}}
        {{{templatedata:head}}}
    </head>
    <body>
        <header id="header">
            <div class="logo"><a href="/">Flingles</a></div>
            <a href="#menu">Menu</a>
        </header>
        <nav id="menu">
            <ul class="links">
                <li><a href="/">Home</a></li>
                <li><a href="/view/my_profile">My Profile</a></li>
            </ul>
        </nav>
        <section id="one" class="wrapper style3" style="background-image: url(/application/views/themes/dating/images/header.jpg);">
            <div class="inner">
                <header class="align-center">
                    <p>What is Flingles?</p><br>
                    <div>Flingles is a one-of-a-kind dating website that puts control back into your court.</div><br><br>
                </header>
            </div>
        </section>
        <section id="two" class="wrapper style2" style="background-color: #ffffff;">
            <div class="inner">
                <div class="box">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <header class="align-center">
                                    <p>What is Flingles?</p><br>
                                    <div>Flingles is a one-of-a-kind dating website that puts control back into your court.</div><br><br>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div class="container">
                <ul class="icons">
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
                </ul>
            </div>
            <div class="copyright">
                &copy; <?php echo date('Y'); ?>, Impero Consulting. All rights reserved.
            </div>
        </footer>
        {{{templatedata:body}}}
    </body>
</html>
