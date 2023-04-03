<?php
if (!empty($parallax_div)) {
    echo '
        <section id="two" class="wrapper ' . $parallax_div[0]['section_class'] . '" style="background-image: url(' . $parallax_div[0]['image_path'] . $parallax_div[0]['image_file'] . ')">
            <div class="inner">
                <header class="align-center">
                    <p>' . $parallax_div[0]['image_text'] . '</p>
                    <h2>' . $parallax_div[0]['image_heading'] . '</h2>
                </header>
            </div>
        </section>
    ';
}
