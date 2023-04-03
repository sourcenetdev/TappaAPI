<?php
    if (!empty($block)) {
        $out = '<div class="block-blog">';
        if (!empty($block['title'])) {
            $out .= '
                <div class="row">
                    <div class="col-sm-12">
                         <h3 class="dark p-t-15">' . _filter($block['title']) . '</h3>
                    </div>
                </div>
            ';
        }
        if (!empty($block['author'])) {
            $out .= '
                <div class="row">
                    <div class="col-sm-12">
                        <blockquote class="dark small p-t-15">By ' . _filter($block['author']) . '</blockquote>
                    </div>
                </div>
            ';
        }
        if (!empty($block['extra'])) {
            $out .= '
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="dark p-t-15">' . _filter($block['extra']) . '</h3>
                    </div>
                </div>
            ';
        }
        if (!empty($block['cite'])) {
            $out .= '
                <div class="row">
                    <div class="col-sm-12">
                        <cite class="dark small p-t-15">"' . _filter($block['cite']) . '"</cite>
                    </div>
                </div>
            ';
        }
        if (!empty($block['body'])) {
            $out .= '
                <div class="row">
                    <div class="col-sm-12 p-t-25">' . _filter($block['body']) . '</div>
                </div>
            ';
        }
        $out .= '</div>';
        echo $out;
    }
?>