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
        <header id="header" class="alt">
            <div class="logo"><a href="/">__SITENAME__</a></div>
            <a href="#menu">Menu</a>
        </header>
        <nav id="menu">
            <ul class="links">
                <li><a href="/">Home</a></li>
                <li><a href="/view/scrabble_tile_distribution">Scrabble Tile Distribution</a></li>
            </ul>
        </nav>
        <?php $hielo->show_slider('hielo_main_slider'); ?>
        <?php $hielo->show_info_blocks('hielo_main_info_blocks'); ?>
        <?php $hielo->show_parallax_div('hielo_main_parallax_div'); ?>
        <footer id="footer">
            <div class="container">
                <ul class="icons">
                    <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
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