(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery);
    }
}(function ($) {
    $.extend($.summernote.options, {
        nugget: {
            list: []
        },
        snblock: {
            list: []
        },
        snimage: {
            list: []
        },
        snaccordions: {
            list: []
        },
        sntabs: {
            list: []
        },
        snaccordions: {
            list: []
        },
        snfile: {
            list: []
        },
        snfilegroup: {
            list: []
        },
        snlink: {
            list: []
        }
    });
    $.extend(true, $.summernote, {
        lang: {
            'en-US': {
                nugget: {
                    Nugget: 'Nugget',
                    Insert_nugget: 'Insert Nugget'
                },
                snblock: {
                    Block: 'Blocks',
                    Insert_block: 'Insert Blocks'
                },
                snimage: {
                    Image: 'Images',
                    Insert_image: 'Insert Images'
                },
                snaccordions: {
                    Accordions: 'Accordions',
                    Insert_accordions: 'Insert Accordions'
                },
                sntabs: {
                    Tabs: 'Tabs',
                    Insert_tabs: 'Insert Tabs'
                },
                snaccordions: {
                    Accordions: 'Accordions',
                    Insert_accordions: 'Insert Accordions'
                },
                snfile: {
                    File: 'Files',
                    Insert_file: 'Insert Files'
                },
                snfilegroup: {
                    FileGroup: 'File Groups',
                    Insert_filegroup: 'Insert File Groups'
                },
                snlink: {
                    Link: 'Links',
                    Insert_link: 'Insert Links'
                }
            },
            'en-GB': {
                nugget: {
                    Nugget: 'Nugget',
                    Insert_nugget: 'Insert Nugget'
                },
                snblock: {
                    Block: 'Blocks',
                    Insert_block: 'Insert Blocks'
                },
                snimage: {
                    Image: 'Images',
                    Insert_image: 'Insert Images'
                },
                snaccordions: {
                    Accordions: 'Accordions',
                    Insert_accordions: 'Insert Accordions'
                },
                sntabs: {
                    Tabs: 'Tabs',
                    Insert_tabs: 'Insert Tabs'
                },
                snaccordions: {
                    Accordions: 'Accordions',
                    Insert_accordions: 'Insert Accordions'
                },
                snfile: {
                    File: 'Files',
                    Insert_file: 'Insert Files'
                },
                snfilegroup: {
                    FileGroup: 'File Groups',
                    Insert_filegroup: 'Insert File Groups'
                },
                snlink: {
                    Link: 'Links',
                    Insert_link: 'Insert Links'
                }
            }
        }
    });
    $.extend($.summernote.plugins, {
        'nugget': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.nugget;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.nugget.Nugget,
                tooltip: lang.nugget.Insert_nugget
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.nugget', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="nugget"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-nugget',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', value);
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snblock': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snblock;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snblock.Block,
                tooltip: lang.snblock.Insert_block
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snblock', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snblock"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snblock',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[block:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snimage': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snimage;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snimage.Image,
                tooltip: lang.snimage.Insert_image
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snimage', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snimage"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snimage',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[image:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snaccordions': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snaccordions;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snaccordions.Accordions,
                tooltip: lang.snaccordions.Insert_accordions
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snaccordions', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snaccordions"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snaccordions',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[accordions:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'sntabs': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.sntabs;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.sntabs.Tabs,
                tooltip: lang.sntabs.Insert_tabs
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.sntabs', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="sntabs"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-sntabs',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[tabs:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snfile': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snfile;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snfile.File,
                tooltip: lang.snfile.Insert_file
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snfile', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snfile"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snfile',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[file:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snfilegroup': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snfilegroup;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snfilegroup.FileGroup,
                tooltip: lang.snfilegroup.Insert_filegroup
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snfilegroup', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snfilegroup"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snfilegroup',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[filegroup:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        },
        'snlink': function (context) {
            var ui = $.summernote.ui;
            var options = context.options.snlink;
            var context_options = context.options;
            var lang = context_options.langInfo;
            var defaultOptions = {
                label: lang.snlink.Link,
                tooltip: lang.snlink.Insert_link
            };
            for (var propertyName in defaultOptions) {
                if (options.hasOwnProperty(propertyName) === false) {
                    options[propertyName] = defaultOptions[propertyName];
                }
            }
            context.memo('button.snlink', function () {
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<span class="snlink"> ' + options.label + '</span><span class="note-icon-caret"></span>',
                        tooltip: options.tooltip,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-snlink',
                        items: options.list,
                        click: function (event) {
                            event.preventDefault();
                            var $button = $(event.target);
                            var value = $button.data('value');
                            var node = document.createElement('span');
                            node.innerHTML = value;
                            context.invoke('editor.insertText', '[[link:' + value + ']]');
                        }
                    })
                ]);
                return button.render();
            });
        }
    });
}));