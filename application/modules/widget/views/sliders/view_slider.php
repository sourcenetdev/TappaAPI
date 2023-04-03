<?php
if (!empty($slider_items) && !empty($slider)) {
    echo '<section id="slider-' . $slider[0]['id'] . '" class="' . $slider[0]['section_class'] . '">';
    foreach ($slider_items as $sk => $sv) {
        echo '
            <article>
                <img id="slider-item-' . $sv['id'] . '" src="' . base_url() . $slider[0]['image_path'] . '/' . $sv['image'] . '" alt="' . $sv['title'] . '" />
                <div class="' . $sv['image_div_class'] . '">
                    <header>
                        <p>' . $sv['image_text'] . '</p>
                        <h2>' . $sv['image_heading'] . '</h2>
                    </header>
                </div>
            </article>
        ';
    }
    echo '</section>';
}
