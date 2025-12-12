<?php
include_once '../inc/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <title>Directorio de Personal</title>
        <script src="../libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Bootstrap core CSS -->
        <link href="../dist/css/animate.css" rel="stylesheet">
        <link href="../dist/css/bootstrap.min.css" rel="stylesheet">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <h1 align="center"><small>Directorio de Personal</small></h1>
                <form action="#" method="get" id="search-form">
                    <div class="input-group">
                        <!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
                        <input class="form-control" id="system-search" name="q" placeholder="Buscar" required onkeydown="return (event.keycode!=13);">
                        <span class="input-group-btn">
                            <button type="button"  id="system-reset" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <br>
        </nav>
        <style>
            body{ padding-top: 125px;}
        </style>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="../dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var activeSystemClass = $('.list-group-item.active');

                //something is entered in search form
                $('#system-search').keyup( function() {
                    var that = this;
                    // affect all table rows on in systems table
                    var tableBody = $('.table-list-search tbody');
                    var tableRowsClass = $('.table-list-search tbody tr');
                    $('.search-sf').remove();
                    tableRowsClass.each( function(i, val) {

                        //Lower text for case insensitive
                        var rowText = $(val).text().toLowerCase();
                        var inputText = $(that).val().toLowerCase();
                        if(inputText != '')
                        {
                            $('.search-query-sf').remove();
                            tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Buscando a: "'
                                + $(that).val()
                                + '"</strong></td></tr>');
                        }
                        else
                        {
                            $('.search-query-sf').remove();
                        }

                        if( rowText.indexOf( inputText ) == -1 )
                        {
                            //hide rows
                            tableRowsClass.eq(i).hide();

                        }
                        else
                        {
                            $('.search-sf').remove();
                            tableRowsClass.eq(i).show();
                        }
                    });
                    //all tr elements are hidden
                    if(tableRowsClass.children(':visible').length == 0)
                    {
                        tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No se encontraron resultados.</td></tr>');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="col-lg-12">
                <table class="table table-list-search table-responsive" id="table" cellpadding="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th align="center">Email</th>
                            <th align="center">Extensión</th>
                            <th align="center">Departamento</th>
                            <th class=".hidden-md" align="center ">Puesto</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach(personas() as $persona) {
                            if ($persona['ext_id'] != 0 && $persona['user_status'] == 1):
                                echo '<tr>';
                                echo '<td>' . $persona['user_pref'] . '</td>';
                                echo '<td style="white-space: nowrap;">' . $persona['user_nm1'] . ' ' . $persona['user_nm2'] . ' ' . $persona['user_ap1'] . ' ' . $persona['user_ap2'] . '</td>';
                                echo '<td><a href="mailto:' . $persona['user_mail'] . '">' . $persona['user_mail'] . '</a></td>';
                                echo '<td align="center" style="background-color:#FFC;">' . $persona['ext_id'] . '</td>';
                                echo '<td>' . $persona['dep_nm'] . '</td>';
                                echo '<td class=".hidden-md">' . $persona['user_puesto'] . '</td>';
                                echo '</tr>';
                            endif;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $('[type=button]').click(function (e) {
                e.preventDefault();
                $('form')[0].reset();
                $('#system-search').trigger('keyup');
            });
        </script>

    </body>
</html>

