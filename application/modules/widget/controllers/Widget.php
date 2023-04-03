<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   6.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Widget Module
 *
 * Allows the generation of widgets on the site.
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Widget extends MX_Controller
{
    public $delete_type = 'hard';
    public $page_limit = 25;

    /**
     * __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {

        // Executes the parent's constructor.
        parent::__construct();

        // Loads this module's resources
        _models_load(['widget/widget_model']);
        _languages_load(['widget/widget']);
        _helpers_load(['widget/widget']);

        // Sets the settings for this module.
        _settings_check('widget');

        // Loads all widgets.
        $this->widgets_init();
    }

    public function index()
    {
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Parallax_div' => [
                'actions' => [
                    $condition . 'list_parallax_divs' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage parallax divs'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add parallax divs', 'Manage parallax divs']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add parallax divs', 'Manage parallax divs']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete parallax divs', 'Manage parallax divs']
                            ]
                        ]
                    ],
                    $condition . 'add_parallax_div' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add parallax divs', 'Manage parallax divs']
                    ],
                    $condition . 'edit_parallax_div' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit parallax divs', 'Manage parallax divs']
                    ],
                    $condition . 'get_parallax_divs' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage parallax divs']
                    ],
                    $condition . 'delete_parallax_div' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete parallax divs', 'Manage parallax divs']
                    ]
                ]
            ],
            'Info_block' => [
                'actions' => [
                    $condition . 'list_info_blocks' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage info blocks'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add info blocks', 'Manage info blocks']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add info blocks', 'Manage info blocks']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete info blocks', 'Manage info blocks']
                            ]
                        ]
                    ],
                    $condition . 'add_info_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add info blocks', 'Manage info blocks']
                    ],
                    $condition . 'edit_info_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit info blocks', 'Manage info blocks']
                    ],
                    $condition . 'get_info_blocks' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage info blocks']
                    ],
                    $condition . 'delete_info_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete info blocks', 'Manage info blocks']
                    ]
                ]
            ],
            'Slider' => [
                'actions' => [
                    $condition . 'list_sliders' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage sliders'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add sliders', 'Manage sliders']
                            ],
                            'add_items' => [
                                'roles' => ['Super Administrators'],
                                'permissions' => ['Add slider items', 'Manage slider items']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add sliders', 'Manage sliders']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete sliders', 'Manage sliders']
                            ]
                        ]
                    ],
                    $condition . 'add_slider' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add sliders', 'Manage sliders']
                    ],
                    $condition . 'edit_slider' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit sliders', 'Manage sliders']
                    ],
                    $condition . 'get_sliders' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage sliders']
                    ],
                    $condition . 'delete_slider' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete sliders', 'Manage sliders']
                    ],
                    $condition . 'list_slider_items' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage slider items'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add slider items', 'Manage slider items']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add slider items', 'Manage slider items']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete slider items', 'Manage slider items']
                            ]
                        ]
                    ],
                    $condition . 'add_slider_item' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add slider items', 'Manage slider items']
                    ],
                    $condition . 'edit_slider_item' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit slider items', 'Manage slider items']
                    ],
                    $condition . 'get_slider_items' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage slider items']
                    ],
                    $condition . 'delete_slider_item' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete slider items', 'Manage slider items']
                    ]
                ]
            ]
        ];
    }

    public function widgets_init()
    {
        $libraries = _list_files(dirname(__FILE__) . '/../libraries/', ['php'], true);
        if (!empty($libraries)) {
            foreach ($libraries as $library) {
                $this->load->library('widget/' . $library);
            }
        }
    }

    public function load_widget($widget, $func)
    {
        $params = func_get_args();
        unset($params[0], $params[1]);
        if (!empty($params)) {
            $this->{$widget}->{$func}(...$params);
        } else {
            $this->{$widget}->{$func}();
        }
    }
}
