<?php
if (!empty($info_block)) {
    echo '
        <div>
            <div class="box">
                <div class="image fit">
                    <img src="' . base_url() . $info_block[0]['image_path'] . '/' . $info_block[0]['image_file'] . '" alt="" />
                </div>
                <div class="content">
                    <header class="align-center">
                        <p>' . $info_block[0]['image_text'] . '</p>
                        <h2>' . $info_block[0]['image_heading'] . '</h2>
                    </header>
                    <p>' . $info_block[0]['body_text'] . '</p>
                    <footer class="align-center">
                        <a href="#" class="button ' . $info_block[0]['button_class'] . '">' . $info_block[0]['button_text'] . '</a>
                    </footer>
                </div>
            </div>
        </div>
    ';
}
