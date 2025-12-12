<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCheques')):
        include_once 'inc/Account.php';
        $id = null;
        $index = 0;
        $saldo = 0.00;
        $credito_total = 0.00;
        $debito_total = 0.00;
        $fecha_inicio = null;
        $fecha_fin = null;
        $cuenta = array();
        $balance = array();
        $balanceTotalToDate = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $cuenta = Account::getByID($id);
        }
        if ( null==$id ) {
            echo "<script type='text/javascript'> window.location='index.php?ref=_17'; </script>";
        }
        if ( !empty($_POST)) {
            $fecha_inicio = fecha_ymd($_POST['fecha_inicio']);
            $fecha_fin = fecha_ymd($_POST['fecha_fin']);
            $balance = Account::balance(usuarioPrivilegiado(),$id,$fecha_inicio,$fecha_fin);
            $balanceTotalToDate = Account::balanceTotalToDate(usuarioPrivilegiado(),$id,$fecha_inicio);
        }else{
            echo "<script type='text/javascript'> window.location='index.php?ref=_17'; </script>";
        }
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.0/css/responsive.bootstrap.min.css">
         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading hidden-print">
                        BALANCE DE CUENTAS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Cheques</li>
                        <li><a class="link-effect" href="#">Balance de Cuentas</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Balance -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <!-- Print Page functionality is initialized in App() -> uiHelperPrint() -->
                            <!-- <button type="button" onclick="App.initHelper('print-page');"><i class="si si-printer"></i> Imprimir Balance</button>-->
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title hidden-print"><?php echo 'Cuenta No. '.$cuenta->account['number'] ?></h3>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- Balance Info -->
                    <div class="h1 text-center">Balance de Cuenta <br><?php echo fecha_dmy($fecha_inicio).' a '.fecha_dmy($fecha_fin) ?></div>
                    <hr class="hidden-print">
                    <div class="row items-push-2x">
                        <!-- Account Info -->
                        <div class="col-xs-6 col-sm-4 col-lg-3">
                            <p class="h2 font-w400 push-5">Cuenta</p>
                            <article>
                                <?php
                                    echo "<strong>Titular:</strong> ".$cuenta->account['title']."<br>";
                                    echo "<strong>Número:</strong>  ".$cuenta->account['number']."<br>";
                                    echo "<strong>Banco:</strong>   ".$cuenta->account['bank_name']."<br>";
                                ?>
                            </article>
                        </div>
                        <!-- END Acccount Info -->
                    </div>
                    <!-- END Balance Info -->
                    <!-- Table -->
                    <div class="table-responsive push-50">
                        <table class="table table-bordered table-hover js-dataTable-balance">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 25px;">No.</th>
                                    <th class="text-center" style="width: 100px;">Fecha</th>
                                    <th style="width: 300px;">Descripción</th>
                                    <th class="text-center">Crédito</th>
                                    <th class="text-center">Débito</th>
                                    <th class="text-center">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldo = $balanceTotalToDate['mov_credito'] - $balanceTotalToDate['mov_debito'];
                                $credito_total += $balanceTotalToDate['mov_credito'];
                                $debito_total += $balanceTotalToDate['mov_debito'];
                                echo '<tr>';
                                echo '<td class="text-center" style="width: 25px;"></td>';
                                echo '<td class="text-center" style="width: 100px;"></td>';
                                echo '<td class="text-left" style="width: 300px;">VIENE</td>';
                                echo '<td class="text-left" style="white-space: nowrap;">Q '.number_format($credito_total,2).'</td>';
                                echo '<td class="text-left" style="white-space: nowrap;">Q '.number_format($debito_total,2).'</td>';
                                echo '<td class="text-left" style="white-space: nowrap;">Q '.number_format($saldo,2).'</td>';
                                echo '</tr>';
                                foreach ($balance as $movimiento){
                                    $index += 1;
                                    echo '<tr '.(($movimiento['mov_status'] == 0)?'class="danger"':"").'>';
                                    echo '<td class="text-center">'.$index.'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($movimiento['mov_fecha']).'</td>';
                                    echo '<td class="text-left">'.$movimiento['mov_desc'].'</td>';
                                    if ($movimiento['mov_tipo'] == 'credito'){
                                        if($movimiento['mov_status'] != 0){
                                            $saldo += $movimiento['mov_monto'];
                                            $credito_total += $movimiento['mov_monto'];
                                        }
                                        echo '<td class="text-left" style="white-space: nowrap;">Q '.number_format($movimiento['mov_monto'],2).'</td>';
                                        echo '<td class="text-center"></td>';
                                    }else{
                                        if($movimiento['mov_status'] != 0){
                                            $saldo -= $movimiento['mov_monto'];
                                            $debito_total += $movimiento['mov_monto'];
                                        }
                                        echo '<td class="text-center"></td>';
                                        echo '<td class="text-left" style="white-space: nowrap;">Q '.number_format($movimiento['mov_monto'],2).'</td>';
                                    }
                                    echo '<td class="text-left"  style="white-space: nowrap;">Q '.number_format($saldo,2).'</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="active">
                                    <td></td>
                                    <td></td>
                                    <td class="font-w700 text-uppercase text-right">Total</td>
                                    <td class="font-w700 text-left" style="white-space: nowrap;">Q&nbsp;<?php echo number_format($credito_total,2) ?></td>
                                    <td class="font-w700 text-left" style="white-space: nowrap;">Q&nbsp;<?php echo number_format($debito_total,2) ?></td>
                                    <td class="font-w700 text-left" style="white-space: nowrap;">Q&nbsp;<?php echo number_format($saldo,2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- END Table -->

                    <!-- Footer -->
                    <hr class="hidden-print">
                    <p class="text-muted text-center"><small>Balance de Cuenta <?php echo 'No. '.$cuenta->account['number'].' de '.fecha_dmy($fecha_inicio).' a '.fecha_dmy($fecha_fin) ?></small></p>
                    <!-- END Footer -->
                </div>
            </div>
            <!-- END Balance -->
        </div>
        <!-- FIN Contenido de Pagina -->
    <?php
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
