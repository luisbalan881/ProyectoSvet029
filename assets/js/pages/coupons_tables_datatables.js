/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var CouponsTableDatatables = function() {
    var currentdate = new Date();
    var datetime = currentdate.getFullYear() + "/"
        + (currentdate.getMonth()+1)  + "/"
        + currentdate.getDate() + " - "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    //Datatables Cupones Pedido
    var initDataTableApplications = function() {
        jQuery('.js-dataTable-cupones-pedido').dataTable({
            order: [],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Cupones Pedido',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Cupones Pedido',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Cupones Pedido',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '8pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'table-layout','inherit')
                            .css( 'font-size', 'inherit' );
                        $(win.document.body).find('h1').css('text-align','center');
                    }
                }
            ],
            columnDefs: [
                {targets: 2, render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY' )},
                { responsivePriority: 0, targets: [0,7,9]},
                { responsivePriority: 1, targets: [8]},
                { responsivePriority: 2, targets: [2,3]},
                { responsivePriority: 3, targets: [1,5]}]
        });
    };

    //Datatables Cupones Pedido
    var initDataTableCuponsIng = function() {
        jQuery('.js-dataTable-cupones-ing').dataTable({
            order: [],
            pageLength: -1,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    },
                    footer: true
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '8pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'table-layout','inherit')
                            .css( 'font-size', 'inherit' );
                        $(win.document.body).find('h1').css('text-align','center');
                    },
                    footer: true
                }
            ],
            columnDefs: [
                { responsivePriority: 0, targets: [0,3,-1]},
                { responsivePriority: 1, targets: [1,2]},
                { responsivePriority: 2, targets: [4,6]},
                { responsivePriority: 3, targets: [7]},
                { bSortable: false, targets:[0,1,2,3,4,5,6,7,-1]}
                ]
        });
    };

    //Datatables Cupones Vehiculos
    var initDataTableVehicles = function() {
        jQuery('.js-dataTable-cupones-vehiculos').dataTable({
            order: [],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Vehículos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Vehículos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Vehículos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '8pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'table-layout','inherit')
                            .css( 'font-size', 'inherit' );
                        $(win.document.body).find('h1').css('text-align','center');
                    }
                }
            ],
            columnDefs: [
                { responsivePriority: 0, targets: [0,3,8]},
                { responsivePriority: 1, targets: [1]},
                { responsivePriority: 1, targets: [4,6]}]
        });
    };

    //Datatables Cupones Conductores
    var initDataTableDrivers = function() {
        jQuery('.js-dataTable-cupones-conductores').dataTable({
            order: [],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Conductores',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Conductores',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Conductores',
                    exportOptions: {
                        columns: [0,1,2,3]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '8pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'table-layout','inherit')
                            .css( 'font-size', 'inherit' );
                        $(win.document.body).find('h1').css('text-align','center');
                    }
                }
            ],
            columnDefs: [
                { targets: [3], render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY' )},
                { responsivePriority: 0, targets: [0,4]}
            ]
        });
    };

    //Datatables Cupones Despacho
    var initDataTableDispatch = function() {
        jQuery('.js-dataTable-cupones-despacho').dataTable({
            order: [[0,"asc"]],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Despacho de Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Despacho de Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Despacho de Cupones',
                    exportOptions: {
                        columns: [0,1,2,3,5,6,7,8,9,10]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '8pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'table-layout','inherit')
                            .css( 'font-size', 'inherit' );
                        $(win.document.body).find('h1').css('text-align','center');
                    }
                }
            ],
            columnDefs: [
                {targets: 1, render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY' )},
                { responsivePriority: 0, targets: [0,2,11]},
                { responsivePriority: 1, targets: [1,4,6]},
                { responsivePriority: 2, targets: [7,8,9,10]},
                { responsivePriority: 3, targets: [3,5]}
            ],
            fixedColumns: true
        });
    };

    // DataTables Bootstrap integration
    var bsDataTables = function() {
        var $DataTable = jQuery.fn.dataTable;

        // Set the defaults for DataTables init
        jQuery.extend( true, $DataTable.defaults, {
            dom:
            "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            renderer: 'bootstrap',
            oLanguage: {
                /*sLengthMenu: "_MENU_",
                 sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                 oPaginate: {
                 sPrevious: '<i class="fa fa-angle-left"></i>',
                 sNext: '<i class="fa fa-angle-right"></i>'
                 }*/
                sProcessing:     "Procesando...",
                sLengthMenu:     "Mostrar _MENU_ registros",
                sZeroRecords:    "No se encontraron resultados",
                sEmptyTable:     "Ningún dato disponible en esta tabla",
                sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
                sInfoPostFix:    "",
                sSearch:         "Buscar:",
                sUrl:            "",
                sInfoThousands:  ",",
                sLoadingRecords: "Cargando...",
                oPaginate: {
                    sFirst:    "Primero",
                    sLast:     "Último",
                    sNext:     "Siguiente",
                    sPrevious: "Anterior"
                },
                oAria: {
                    sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // Default class modification
        jQuery.extend($DataTable.ext.classes, {
            sWrapper: "dataTables_wrapper form-inline dt-bootstrap",
            sFilterInput: "form-control",
            sLengthSelect: "form-control"
        });

        // Bootstrap paging button renderer
        $DataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
            var api     = new $DataTable.Api(settings);
            var classes = settings.oClasses;
            var lang    = settings.oLanguage.oPaginate;
            var btnDisplay, btnClass;

            var attach = function (container, buttons) {
                var i, ien, node, button;
                var clickHandler = function (e) {
                    e.preventDefault();
                    if (!jQuery(e.currentTarget).hasClass('disabled')) {
                        api.page(e.data.action).draw(false);
                    }
                };

                for (i = 0, ien = buttons.length; i < ien; i++) {
                    button = buttons[i];

                    if (jQuery.isArray(button)) {
                        attach(container, button);
                    }
                    else {
                        btnDisplay = '';
                        btnClass = '';

                        switch (button) {
                            case 'ellipsis':
                                btnDisplay = '&hellip;';
                                btnClass = 'disabled';
                                break;

                            case 'first':
                                btnDisplay = lang.sFirst;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'previous':
                                btnDisplay = lang.sPrevious;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'next':
                                btnDisplay = lang.sNext;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            case 'last':
                                btnDisplay = lang.sLast;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            default:
                                btnDisplay = button + 1;
                                btnClass = page === button ?
                                    'active' : '';
                                break;
                        }

                        if (btnDisplay) {
                            node = jQuery('<li>', {
                                'class': classes.sPageButton + ' ' + btnClass,
                                'aria-controls': settings.sTableId,
                                'tabindex': settings.iTabIndex,
                                'id': idx === 0 && typeof button === 'string' ?
                                settings.sTableId + '_' + button :
                                    null
                            })
                                .append(jQuery('<a>', {
                                        'href': '#'
                                    })
                                        .html(btnDisplay)
                                )
                                .appendTo(container);

                            settings.oApi._fnBindAction(
                                node, {action: button}, clickHandler
                            );
                        }
                    }
                }
            };

            attach(
                jQuery(host).empty().html('<ul class="pagination"/>').children('ul'),
                buttons
            );
        };

        // TableTools Bootstrap compatibility - Required TableTools 2.1+
        if ($DataTable.TableTools) {
            // Set the classes that TableTools uses to something suitable for Bootstrap
            jQuery.extend(true, $DataTable.TableTools.classes, {
                "container": "DTTT btn-group",
                "buttons": {
                    "normal": "btn btn-default",
                    "disabled": "disabled"
                },
                "collection": {
                    "container": "DTTT_dropdown dropdown-menu",
                    "buttons": {
                        "normal": "",
                        "disabled": "disabled"
                    }
                },
                "print": {
                    "info": "DTTT_print_info"
                },
                "select": {
                    "row": "active"
                }
            });

            // Have the collection use a bootstrap compatible drop down
            jQuery.extend(true, $DataTable.TableTools.DEFAULTS.oTags, {
                "collection": {
                    "container": "ul",
                    "button": "li",
                    "liner": "a"
                }
            });
        }
    };

    return {
        init: function() {
            //Init Datatables
            bsDataTables();
            initDataTableApplications();
            initDataTableCuponsIng();
            initDataTableVehicles();
            initDataTableDrivers();
            initDataTableDispatch();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ CouponsTableDatatables.init(); });
