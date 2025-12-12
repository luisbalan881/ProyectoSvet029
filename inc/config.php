
<?php
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Global configuration file
 *
 */

// Include Template class
require 'classes/Template.php';

// Create a new Template Object
$one                               = new Template('Vicepresidencia de la República', '2.0', 'assets'); // Name, version and assets folder's name

// Global Meta Data
$one->author                       = 'S.C.';
$one->robots                       = 'noindex, nofollow';
$one->title                        = 'Herramientas Administrativas - Vicepresidencia de la República';
$one->description                  = 'Herramientas Administrativas - Vicepresidencia de la República';

// Global Included Files (eg useful for adding different sidebars or headers per page)
$one->inc_side_overlay             = 'base_side_overlay.php';
$one->inc_sidebar                  = 'base_sidebar.php';
$one->inc_header                   = 'base_header.php';

// Global Color Theme
$one->theme                        = '';       // '' for default theme or 'amethyst', 'city', 'flat', 'modern', 'smooth'

// Global Cookies
$one->cookies                      = true;    // True: Remembers active color theme between pages (when set through color theme list), False: Disables cookies

// Global Body Background Image
$one->body_bg                      = '';       // eg 'assets/img/photos/photo10@2x.jpg' Useful for login/lockscreen pages

// Global Header Options
$one->l_header_fixed               = true;     // True: Fixed Header, False: Static Header

// Global Sidebar Options
$one->l_sidebar_position           = 'left';   // 'left': Left Sidebar and right Side Overlay, 'right;: Flipped position
$one->l_sidebar_mini               = false;    // True: Mini Sidebar Mode (> 991px), False: Disable mini mode
$one->l_sidebar_visible_desktop    = true;     // True: Visible Sidebar (> 991px), False: Hidden Sidebar (> 991px)
$one->l_sidebar_visible_mobile     = false;    // True: Visible Sidebar (< 992px), False: Hidden Sidebar (< 992px)

// Global Side Overlay Options
$one->l_side_overlay_hoverable     = true;    // True: Side Overlay hover mode (> 991px), False: Disable hover mode
$one->l_side_overlay_visible       = false;    // True: Visible Side Overlay, False: Hidden Side Overlay

// Global Sidebar and Side Overlay Custom Scrolling
$one->l_side_scroll                = true;     // True: Enable custom scrolling (> 991px), False: Disable it (native scrolling)

// Global Active Page (it will get compared with the url of each menu link to make the link active and set up main menu accordingly)
$one->main_nav_active              = basename($_SERVER['PHP_SELF']);

// Global Main Menu
$u = '';
$role = '';
$u = isset($_SESSION['user_id']) ? PrivilegedUser::getByUserId($_SESSION["user_id"]) : NULL;
$one->main_nav                     = array(
    array(
        'name'  => '<span class="sidebar-mini-hide">Inicio</span>',
        'icon'  => 'fa fa-th-large',
        'url'   => 'index.php'
    )
);

//Menu de control de usuarios
if ($u != NULL && $u->hasPrivilege('leerUsuario')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Usuarios</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Empleados</span>',
            'icon'  => 'fa fa-users',
            'url'   => '?ref=_35'
        )
      );
      if (verificar_director($_SESSION['user_id'])==1 || ($u != NULL && $u->hasPrivilege('Configuracion'))){
          array_push($one -> main_nav,
            array(
                'name'  => '<span class="sidebar-mini-hide">Control de Horarios</span>',
                'icon'  => 'fa fa-calendar-check-o',
                'url'   => '?ref=_39'
            ),
            array(
                'name'  => '<span class="sidebar-mini-hide">Departamentos</span>',
                'icon'  => 'fa fa-home',
                'url'   => '?ref=_36'
            )
          );
      }



    
}

//Menu de control de cheques
if ($u != NULL && $u->hasPrivilege('leerCheques')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Cheques</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Bancos</span>',
            'icon'  => 'fa fa-bank',
            'url'   => '?ref=_16'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Cuentas</span>',
            'icon'  => 'fa fa-money',
            'url'   => '?ref=_17'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Créditos</span>',
            'icon'  => 'fa fa-arrow-right',
            'url'   => '?ref=_19'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Débitos</span>',
            'icon'  => 'fa fa-arrow-left',
            'url'   => '?ref=_20'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide"><i>Vouchers</i></span>',
            'icon'  => 'fa fa-arrow-left',
            'url'   => '?ref=_21'
        )
    );
}

//menu de control de cheques
if ($u != NULL && $u->hasPrivilege('leerAlmacen')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Almacén</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Productos</span>',
            'icon'  => 'fa fa-shopping-bag',
            'url'   => '?ref=_1'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Reporte de Kardex</span>',
            'icon'  => 'fa fa-align-justify',
            'url'   => '?ref=_3'
        ),
             array(
            'name'  => '<span class="sidebar-mini-hide">Rep Kardex 2</span>',
            'icon'  => 'fa fa-align-justify',
            'url'   => '?ref=_4'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Renglones</span>',
            'icon'  => 'fa fa-align-justify',
            'url'   => '?ref=_2'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Facturas</span>',
            'icon'  => 'fa fa-tags',
            'url'   => '?ref=_5'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Requisición</span>',
            'icon'  => 'fa fa-shopping-cart',
            'url'   => '?ref=_7'
        ),
            
        array(
            'name'  => '<span class="sidebar-mini-hide">Inventario</span>',
            'icon'  => 'fa fa-calculator',
            'url'   => '?ref=_9'
        )
    );
}

//Menu de proveedores
if ($u != NULL && $u->hasPrivilege('leerProveedor')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">CONTROL DE PROVEEDORES</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Proveedores</span>',
            'icon'  => 'fa fa-product-hunt',
            'url'   => '?ref=_18'
        )
    );
}

//Menu de control de cupones
if ($u != NULL && $u->hasPrivilege('leerCupon')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Cupones</span>',
            'type'  => 'heading'
        ),
         array(
            'name'  => '<span class="sidebar-mini-hide">Control de Cupones</span>',
            'type'  => 'heading'
        ),
       
        array(
            'name'  => '<span class="sidebar-mini-hide">Cupones</span>',
            'icon'  => 'fa fa-ticket',
            'url'   => '?ref=_40'
        ),
          array(
            'name'  => '<span class="sidebar-mini-hide">Bitacora KM vehículos </span>',
            'icon'  =>  'fa fa-car',
            'url'   => '?ref=_42'
        ));
    
        if (($u != NULL && $u->hasPrivilege('Configuracion'))){
            array_push($one -> main_nav,
              array(
                  'name'  => '<span class="sidebar-mini-hide">Control de Usuarios</span>',
                  'icon'  => 'fa fa-users',
                  'url'   => '?ref=_41'
              )
            );
        }

        if (permiso_perm(7) && ($u != NULL && $u->hasPrivilege('crearCupon')) || $u->hasPrivilege('Configuracion')){
            array_push($one -> main_nav,
            array(
                'name'  => '<span class="sidebar-mini-hide">Reportes</span>',
                'icon'  => 'fa fa-bar-chart',
                'url'   => '?ref=_42',
                'sub'   => array(
                    array(
                        'name'  => 'Ingresos',
                        'url'   => '?ref=_46'
                    ),
                    array(
                        'name'  => 'Egresos',
                        'url'   => '?ref=_46'
                    )
                )
            )
        );
      }
}

//Menu de control de archivos
if ($u != NULL && $u->hasPrivilege('leerArchivo')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Archivos</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Archivos Enviados</span>',
            'icon'  => 'fa fa-folder-open-o',
            'url'   => '?ref=_25'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Archivos Recibidos</span>',
            'icon'  => 'fa fa-folder-open',
            'url'   => '?ref=_27'
        )
    );
    //control tipo de archivos
    if ($u != NULL && $u->hasPrivilege('leerTipoArchivo')){
        array_push($one -> main_nav,
            array(
                'name'  => '<span class="sidebar-mini-hide">Tipos de Archivo</span>',
                'icon'  => 'fa fa-th-list',
                'url'   => '?ref=_30'
            )
        );
    }
    if ($u != NULL && $u->hasPrivilege('crearInstitucion')){
        array_push($one -> main_nav,
            array(
                'name'  => '<span class="sidebar-mini-hide">Instituciones</span>',
                'icon'  => 'fa fa-bank',
                'url'   => '?ref=_29'
            )
        );
    }
}


//Menu de control de Solicitudes
/*

if ($u != NULL && $u->hasPrivilege('autorizarSolicitudTransporte')){
    array_push($one -> main_nav,
        array(
            'name'  => '<span class="sidebar-mini-hide">CONTROL DE TRANSPORTE</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Solicitudes Transporte</span>',
            'icon'  => 'fa fa-file-text-o',
            'url'   => '?ref=_50'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Control de Vehículos</span>',
            'icon'  => 'fa fa-car',
            'url'   => '?ref=_51'
        )
    );

}
*/




array_push($one -> main_nav,
    array(
        'name'  => '<span class="sidebar-mini-hide">Herramientas</span>',
        'type'  => 'heading'
    ),
   /*     array(
        'name'  => '<span class="sidebar-mini-hide">Directorio</span>',
        'icon'  => 'fa fa-phone-square',
        'url'   => '?ref=_37'
    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Directorio Mensual</span>',
        'icon'  => 'fa fa-phone-square',
        'url'   => '?ref=_38'
    ),
        
     array(
        'name'  => '<span class="sidebar-mini-hide">Control KM</span>',
        'icon'  => 'fa fa-car',
        'url'   => '?ref=_39'
    ),
          array(
        'name'  => '<span class="sidebar-mini-hide">Control user KM</span>',
        'icon'  => 'fa fa-car',
        'url'   => '?ref=_40'
    ),*/
	 array(
        'name'  => '<span class="sidebar-mini-hide">Mis Viáticos</span>',
        'icon'  => 'fa fa-download',
        'url'   => '?ref=_89'
    ),
        array(
        'name'  => '<span class="sidebar-mini-hide"> Detalle De Gastos</span>',
        'icon'  => 'fa fa-phone-square',
        'url'   => '?ref=_201'
    ),
        
		 array(
        'name'  => '<span class="sidebar-mini-hide">Asignacion de Actividades</span>',
        'icon'  => 'fa fa-download',
        'url'   => '?ref=_79'
    ),
        
		
   array(
        'name'  => '<span class="sidebar-mini-hide">Admin Viáticos</span>',
        'icon'  => 'fa fa-download',
        'url'   => '?ref=_90'
    ),     
	 array(
        'name'  => '<span class="sidebar-mini-hide">Reporte Admin Viaticos</span>',
        'icon'  => 'fa fa-download',
        'url'   => '?ref=_91'
    ),    
   
    array(
        'name'   => '<span class="sidebar-mini-hide">Pagina WEB</span>',
        'icon'   => 'fa fa-chrome',
        'url'    => 'https://www.svet.gob.gt',
        'target' => '_blank'
    )
);

array_push($one -> main_nav,
    array(
        'name'  => '<span class="sidebar-mini-hide label label-danger-footer">Vicepresidencia &copy;  2018 </span>',
        'type'  => ''
    )
);
