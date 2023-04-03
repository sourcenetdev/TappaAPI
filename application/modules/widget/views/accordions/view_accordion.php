<?php
if (!empty($accordion_items) && !empty($accordion)) {
    echo '
        <div
            class="panel-group"
            role="tablist"
            aria-multiselectable="true"
            data-collapse-color="red"
            id="accordion-head-' . $accordion['id'] . '">
    ';
    $class = '';
    if (!empty($accordion['outer_class'])) {
        $class = ' ' . $accordion['outer_class'];
    }
    foreach ($accordion_items as $ak => $av) {
        $opened = '';
        $aclass = ' class="collapsed"';
        $expanded = 'false';
        if ($ak == 0) {
            if ($accordion['first_open'] == 'Yes') {
                $opened = ' in';
                $aclass = '';
                $expanded = 'true';
            }
        }
        echo '
            <div class="panel panel-collapse' . $class . '">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a ' . $aclass . '
                            data-toggle="collapse" aria-expanded="' . $expanded . '"
                            data-parent="#accordion-head-' . $accordion['id'] . '"
                            href="#accordion-' . $av['id'] . '">' . _filter($av['name']) . '
        ';
        if (!empty($av['icon'])) {
            echo '<i style="float: left; margin: 0 10px;" class="' . $av['icon'] . '"></i>';
        }
        echo '
                        </a>
                    </h4>
        ';
        echo '
                </div>
                <div id="accordion-' . $av['id'] . '" class="collapse' . $opened . '" role="tabpanel">
                    <div class="panel-body">' . _filter($av['body']) . '</div>
                </div>
            </div>
        ';
    }
    echo '</div>';
}
