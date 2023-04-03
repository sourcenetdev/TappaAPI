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
                            <div class="col-sm-12" style="padding: 16px;">
                            <h2>Scrabble Letter Distribution - sorted by <strong>Tile</strong></h2>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>TILE</th>
                                        <th>TILE VALUE</th>
                                        <th>TILE COUNT</th>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>C</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>D</td>
                                        <td>2</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>E</td>
                                        <td>1</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td>F</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>G</td>
                                        <td>2</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>H</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>I</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>J</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>K</td>
                                        <td>5</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>L</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>M</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>N</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>O</td>
                                        <td>1</td>
                                        <td>8</td>
                                    </tr>
                                    <tr>
                                        <td>P</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>Q</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>R</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>S</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>T</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>U</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>V</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>W</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>X</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Y</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>Z</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>(blank)</td>
                                        <td>0</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>

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

                            <h2>Scrabble Letter Distribution - sorted by <strong>Tile Value</strong></h2>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>TILE</th>
                                        <th>TILE VALUE</th>
                                        <th>TILE COUNT</th>
                                    </tr>
                                    <tr>
                                        <td>Z</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Q</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>X</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>J</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>K</td>
                                        <td>5</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Y</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>W</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>V</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>H</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>F</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>P</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>M</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>C</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>G</td>
                                        <td>2</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>D</td>
                                        <td>2</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>U</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>T</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>S</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>R</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>N</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>O</td>
                                        <td>1</td>
                                        <td>8</td>
                                    </tr>
                                    <tr>
                                        <td>L</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>I</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>E</td>
                                        <td>1</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>(blank)</td>
                                        <td>0</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>

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

                            <h2>Scrabble Letter Distribution - sorted by <strong>Tile Count</strong></h2>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>TILE</th>
                                        <th>TILE VALUE</th>
                                        <th>TILE COUNT</th>
                                    </tr>
                                    <tr>
                                        <td>E</td>
                                        <td>1</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>I</td>
                                        <td>1</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td>O</td>
                                        <td>1</td>
                                        <td>8</td>
                                    </tr>
                                    <tr>
                                        <td>N</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>R</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>T</td>
                                        <td>1</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>L</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>S</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>U</td>
                                        <td>1</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>D</td>
                                        <td>2</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>G</td>
                                        <td>2</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>C</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>P</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>M</td>
                                        <td>3</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>F</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>H</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>V</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>W</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>Y</td>
                                        <td>4</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>(blank)</td>
                                        <td>0</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>J</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>K</td>
                                        <td>5</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Q</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>X</td>
                                        <td>8</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Z</td>
                                        <td>10</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
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