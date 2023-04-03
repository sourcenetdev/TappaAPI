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
            <div class="logo"><a href="/">Scrabble.rocks</a></div>
            <a href="#menu">Menu</a>
        </header>
        <nav id="menu">
            <ul class="links">
                <li><a href="/">Home</a></li>
                <li><a href="/view/scrabble_tile_distribution">Scrabble Tile Distribution</a></li>
            </ul>
        </nav>
        <section id="one" class="wrapper style3" style="background-image: url(/application/views/themes/hielo/images/header.jpg);">
            <div class="inner">
                <header class="align-center">
                    <p>Your scrabble word finder</p>
                    <h2>Welcome to Scrabble.rocks!</h2>
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
                                    <p>What is scrabble.rocks?</p><br>
                                    <div>Scrabble.rocks is a website used to find the best possible play in a given scenario. Enter your current board scenario, and let the tool find words you can play. Scrabble.rocks is free, so feel free to spread the word to your scrabble-playing friends.</div><br><br>
                                </header>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="padding: 32px 0 48px;">
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Scrabble.rocks Leaderboard -->
                                <ins class="adsbygoogle"
                                    style="display:block"
                                    data-ad-client="ca-pub-0110942971443395"
                                    data-ad-slot="7326735494"
                                    data-ad-format="auto"
                                    data-full-width-responsive="true"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                                <?php echo $contents; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" style="padding: 16px;">
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Scrabble.rocks square -->
                                <ins class="adsbygoogle"
                                    style="display:block"
                                    data-ad-client="ca-pub-0110942971443395"
                                    data-ad-slot="5872762027"
                                    data-ad-format="auto"
                                    data-full-width-responsive="true"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                            <div class="col-sm-6" style="padding: 16px;">
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Scrabble.rocks Square 2 -->
                                <ins class="adsbygoogle"
                                    style="display:block"
                                    data-ad-client="ca-pub-0110942971443395"
                                    data-ad-slot="5427330461"
                                    data-ad-format="auto"
                                    data-full-width-responsive="true"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <p><strong>Please note: </strong>Although we have a large dictionary of English words <strong>(over 370,000 words)</strong>, no guarantee is made that this software will provide valid words for any given scenario. While great care is made to ensure accuracy of these words, this is a single person hobby site, and thus I can't verify every word in the database, either. Be warned. Usage of this tool is not encouraged for competitions, as it is a form of cheating. Winners don't cheat!</p>
                        <ul class="icons">
                            <li><a target="_blank" href="https://www.facebook.com/scrabblerocks/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="copyright text-center">
                            &copy; <?php echo date('Y'); ?>, <a target="_blank" href="https://www.impero.co.za">Impero Consulting</a>. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{{templatedata:body}}}
    </body>
</html>