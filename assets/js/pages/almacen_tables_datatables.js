/*
 *  Document   : almacen_tables_datatables.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Tables Datatables Page
 */

var AlmacenTableDatatables = function() {
    var currentdate = new Date();
    var datetime = currentdate.getFullYear() + "/"
        + (currentdate.getMonth()+1)  + "/"
        + currentdate.getDate() + " - "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    //Datatables Listado de Productos
    var initDataTableProductos = function() {
        jQuery('.js-dataTable-productos').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + 'Listado de Productos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + 'Listado de Productos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Listado de Productos',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Listado de Productos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                }
            ],
            columnDefs: [
                {responsivePriority:0, targets: [0,1,3,8,-1]},
                {responsivePriority:1, targets: [4,7,10]},
                {responsivePriority:2, targets: [9]},
                {responsivePriority:3, targets: [6]},
                {responsivePriority:4, targets: [5]},
                {responsivePriority:5, targets: [2]}


            ]
        });
    };

    //Datatables Listado de Renglones
    var initDataTableRenglones = function() {
        jQuery('.js-dataTable-renglones').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Listado de Renglones',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Listado de Renglones',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Listado de Renglones',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Listado de Renglones',
                    exportOptions: {
                        columns: [0,1]
                    }
                }
            ]
        });
    };
	
	
	//Datatables Listado de Kardex
    var initDataTablekardex= function() {
        jQuery('.js-dataTable-kardex').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Listado de kardex',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Listado de kardex',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Listado de kardex',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Listado de kardex',
                    exportOptions: {
                        columns: [0,1]
                    }
                }
            ]
        });
    };

// reporte Nombramientos
var initDataTableReport1 = function() {
        jQuery('.js-dataTable-Report1').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Reporte Nombramientos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Reporte Nombramientos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Reporte Nombramientos',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Reporte Nombramientos',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                }
            ]
        });
    };



    //Datatables Listado de Facturas
    var initDataTableFacturas = function() {
        jQuery('.js-dataTable-facturas').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Listado de Facturas',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Listado de Facturas',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Listado de Facturas',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Listado de Facturas',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                }
            ],
            columnDefs: [
                {targets: 0, render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY' )},
                {responsivePriority:0, targets: [0,5,8]},
                {responsivePriority:1, targets: [3,4]},
                {responsivePriority:2, targets: [7]},
                {responsivePriority:3, targets: [1,2]}
            ]
        });
    };

    var initDataTableIngresos1H = function() {
        jQuery('.js-dataTable-ingresos-1h').dataTable({
            order: [],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            buttons: [],
            columnDefs: [
                {responsivePriority:0, targets: [0,5,-1]},
                {responsivePriority:1, targets: [-3]},
                {responsivePriority:2, targets: [-2]},
                {responsivePriority:3, targets: [6]},
                {responsivePriority:4, targets: [1]},
                {responsivePriority:5, targets: [7,8]}
            ]
        });
    };

    //Datatables Listado de Facturas
    var initDataTableRequisiciones = function() {
        jQuery('.js-dataTable-requisiciones').dataTable({
            order: [[1, "desc"]],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Listado de Requisiciones',
                    exportOptions: {
                        columns: [0,1,2,3,5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Listado de Requisiciones',
                    exportOptions: {
                        columns: [0,1,2,3,5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Listado de Requisiciones',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1,2,3,5]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Listado de Requisiciones',
                    exportOptions: {
                        columns: [0,1,2,3,5]
                    }
                }
            ],
            columnDefs: [
                {targets: 0, render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY' )},
                {responsivePriority:0, targets: [0,1,6]},
                {responsivePriority:1, targets: [2,5]}
            ]
        });
    };

    //Datatables Inventario
    var initDataTableInventario = function() {
        jQuery('.js-dataTable-inventario').dataTable({
            order: [],
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: datetime + ' Inventario',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: datetime + ' Inventario',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: datetime + ' Inventario',
                    download: 'open',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: datetime + ' Inventario',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                }
            ],
            columnDefs: [
                {responsivePriority: 0, targets: [0,2,-1]},
                {responsivePriority: 1, targets: [7,8,9]},
                {responsivePriority: 2, targets: [1,10]},
                {responsivePriority: 3, targets: [6]},
                {responsivePriority: 4, targets: [4]}
            ]

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
            initDataTableProductos();
            initDataTableRenglones();
			initDataTablekardex();
		    initDataTableReport1();
            initDataTableFacturas();
            initDataTableIngresos1H();
            initDataTableRequisiciones();
            initDataTableInventario();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ AlmacenTableDatatables.init(); });