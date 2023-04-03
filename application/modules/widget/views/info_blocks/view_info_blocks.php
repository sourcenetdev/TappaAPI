<?php
if (!empty($info_block)) {
    echo '
        <section id="' . $info_block[0]['section_id'] . '" class="wrapper ' . $info_block[0]['section_class'] . '">
            <div class="inner">
                <div class="grid-style">
    ';
    foreach ($info_block as $k => $v) {
        echo '
            <div>
                <div class="box">
                    <div class="image fit">
                        <img src="' . base_url() . $v['image_path'] . '/' . $v['image_file'] . '" alt="" />
                    </div>
                    <div class="content">
                        <header class="align-center">
                            <p>' . $v['image_text'] . '</p>
                            <h2>' . $v['image_heading'] . '</h2>
                        </header>
                        <p>' . $v['body_text'] . '</p>
                        <footer class="align-center">
                            <a href="#" class="button ' . $v['button_class'] . '">' . $v['button_text'] . '</a>
                        </footer>
                    </div>
                </div>
            </div>
        ';
    }
    echo '
                </div>
            </div>
        </section>
    ';
}
