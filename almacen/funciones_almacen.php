<?php
/**
 * User: stuart.carazo
 * Date: 18/05/2016
 * Time: 3:53 PM
 * @param $fecha
 * @return bool|string
 */



function persona_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,role_id,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,T1.dep_id,dep_nm,user_puesto 
            FROM vp_user AS T1 
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            WHERE T1.user_id = ?
            order by user_nm1,user_ap1";
    $p = $pdo->prepare($sql);
    $p->execute(array($id));
    $persona = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $persona;
}



//funciones de renglones
function renglones(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT renglon_id,renglon_nm,renglon_status FROM alm_renglon  order by renglon_id ASC ";
    $r = $pdo->prepare($sql);
    $r->execute();
    $renglones = $r->fetchAll();
    Database::disconnect();
    return $renglones;
}

function renglones2(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT k.kx_num, c.nombre, c.prod_id  from alm_kardex k
    INNER JOIN vp_catalogo_insumos c
    on k.prod_id = c.prod_id where kx_status=1";
    
    
         
    
    
    $r = $pdo->prepare($sql);
    $r->execute();
    $renglones = $r->fetchAll();
    Database::disconnect();
    return $renglones;
}


function renglones3(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT k.kx_num, c.nombre, c.prod_id  from alm_kardex k
    INNER JOIN vp_catalogo_insumos c
    on k.prod_id = c.prod_id where k.kx_status=1 and c.status=1
    ORDER by c.nombre";
    
    
         
    
    
    $r = $pdo->prepare($sql);
    $r->execute();
    $renglones = $r->fetchAll();
    Database::disconnect();
    return $renglones;
}


function renglon_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT renglon_id,renglon_nm,renglon_status FROM alm_renglon  
            WHERE renglon_id like ?
            order by renglon_id ASC ";
    $r = $pdo->prepare($sql);
    $r->execute(array($id));
    $renglon = $r->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $renglon;
}

//Función para generar reporte de inventario agrupado por renglones.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function renglon_reporte($renglon_inicio,$renglon_fin,$fecha_inicio,$fecha_fin){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.renglon_id as renglon_id, renglon_nm, ing_prod, T2.renglon_id as prod_renglon, prod_cod,  prod_nm, prod_desc, prod_min, prod_max,nombre_presentacion, med_nm, prod_status,ing_cant, costo_unitario, ing_costo, ing_fecha, fac_id, fac_serie, fac_num
            FROM alm_renglon AS T1
            LEFT JOIN (SELECT  T1.prod_id,T1.status AS prod_status,renglon_id,COALESCE(T1.codigo,'N/A') AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,COALESCE(T1.codigo_presentacion,'N/A') AS med_id,T1.nombre_presentacion,T1.cantidad_unidad AS med_nm
                       FROM vp_catalogo_insumos AS T1) AS T2 on T1.renglon_id = T2.renglon_id
            INNER JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,((ing_costo - ing_descuento - (ing_costo*porcentaje_descuento))/ing_cant) as costo_unitario, (ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo,fac_fecha as ing_fecha, T2.fac_id, fac_serie, fac_num
                      FROM alm_ingreso AS T2 
                      LEFT JOIN (SELECT T1.fac_id, fac_serie, fac_num, fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento,fac_fecha
                      FROM alm_factura AS T1
                      LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                      GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                      WHERE T2.ing_status=1 AND T3.fac_status=1
                      GROUP BY T2.ing_id) T3 ON  T3.ing_prod = T2.prod_id
            WHERE T1.renglon_id >= ? and T1.renglon_id <= ? and ing_fecha >= ? and ing_fecha <= ?
            order by T1.renglon_id,ing_fecha ASC ";
    $r = $pdo->prepare($sql);
    $r->execute(array($renglon_inicio,$renglon_fin,$fecha_inicio,$fecha_fin));
    $renglon = $r->fetchAll();
    Database::disconnect();
    return $renglon;
}

function duplicado_renglon($id){
    $duplicado = false;
    $id = number_format($id);
    foreach (renglones() as $renglon){
        $renglon_id = $renglon['renglon_id'];
        if ($id > 0 && $renglon_id == $id){
            $duplicado=true;
        }
    }
    return $duplicado;
}

function renglon_nuevo(){
    $renglon_id = $_POST['renglon_id'];
    $renglon_nm = $_POST['renglon_nm'];
    $renglon_status = 1;
    $user_id = $_SESSION['user_id'];
    $renglon_rev = 1;
    $duplicado = duplicado_renglon($renglon_id);
    if ($duplicado == 0){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alm_renglon (renglon_id,renglon_nm,renglon_status,user_id,renglon_rev) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($renglon_id,$renglon_nm,$renglon_status,$user_id,$renglon_rev));
        Database::disconnect();
    }
}

function renglon_modificar($id){
    $renglon_nm = $_POST['renglon_nm'];
    $renglon_status = $_POST['renglon_status'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE alm_renglon SET renglon_nm = ?, renglon_status = ?, user_id = ?,renglon_rev = renglon_rev + 1 WHERE renglon_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($renglon_nm,$renglon_status, $user_id,$id));
    Database::disconnect();
}

//funciones de Medidas
function medidas(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT med_id, med_nm, med_cat_nm,med_status
                    FROM alm_medida AS T1
                    LEFT JOIN alm_medida_categoria AS T2
                    ON T1.med_cat_id = T2.med_cat_id  
                    order by med_id ASC ";
    $r = $pdo->prepare($sql);
    $r->execute();
    $medidas = $r->fetchAll();
    Database::disconnect();
    return $medidas;
}

//FUNCIONES DE PRODUTO
//función que devuelve el listado de todos los productos existentes con descripción, existencia, costo y costo promedio.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function productos(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.prod_id,T1.renglon_id,T1.renglon_codigo,COALESCE(T1.codigo,"N/A") AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,T1.nombre_presentacion,T1.cantidad_unidad AS med_nm,COALESCE(T1.codigo_presentacion,"N/A") AS codigo_presentacion,T1.status AS prod_status,ing_ing_id,sum(ing_cant),sum(ing_costo),sum(egr_cant), sum(ing_cant-COALESCE(egr_cant,0)) AS existencia, sum((ing_costo/ing_cant)*(ing_cant-COALESCE(egr_cant,0))) AS existencia_costo, (sum(ing_costo)/sum(ing_cant)) as costo_promedio
            FROM vp_catalogo_insumos AS T1 
            LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo
                       FROM alm_ingreso AS T2 
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                    FROM alm_factura AS T1
                                    LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                    GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                       WHERE T2.ing_status=1 AND T3.fac_status=1) AS ing on T1.prod_id = ing.ing_prod 
            LEFT JOIN (SELECT sum(T4.egr_cant) AS egr_cant,T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id 
                       FROM alm_egreso AS T4 
                       LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id 
                       WHERE T4.egr_status = 1 AND T5.req_status not LIKE 0 group by T4.ing_id ) AS egr on egr_ing_id = ing_ing_id

            group by T1.prod_id
            ORDER BY T1.prod_id ASC';
    $p = $pdo->prepare($sql);
    $p->execute();
    $productos = $p->fetchAll();
    Database::disconnect();
    return $productos;
}

//función que devuelve el listado de productos activos o que alguna vez tuvieron al menos una transacción en almacén.
//incluyendo descripción, existencia, costo y costo promedio.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function productos_inventario(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.prod_id,T1.renglon_id,T1.renglon_codigo,COALESCE(T1.codigo,"N/A") AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,T1.nombre_presentacion,T1.cantidad_unidad AS med_nm,COALESCE(T1.codigo_presentacion,"N/A") AS codigo_presentacion,T1.status AS prod_status,ing_ing_id,sum(ing_cant),sum(ing_costo),sum(egr_cant), sum(ing_cant-COALESCE(egr_cant,0)) AS existencia, sum((ing_costo/ing_cant)*(ing_cant-COALESCE(egr_cant,0))) AS existencia_costo, (sum(ing_costo)/sum(ing_cant)) as costo_promedio
            FROM vp_catalogo_insumos AS T1 
            LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo
                       FROM alm_ingreso AS T2 
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                    FROM alm_factura AS T1
                                    LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                    GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                       WHERE T2.ing_status=1 AND T3.fac_status=1) AS ing on T1.prod_id = ing.ing_prod 
            LEFT JOIN (SELECT sum(T4.egr_cant) AS egr_cant,T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id 
                       FROM alm_egreso AS T4 
                       LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id 
                       WHERE T4.egr_status = 1 AND T5.req_status not LIKE 0 group by T4.ing_id ) AS egr ON egr_ing_id = ing_ing_id
            GROUP BY T1.prod_id
            HAVING T1.status like 1 or sum(ing_cant) > 0
            ORDER BY  T1.prod_id ASC';
    $p = $pdo->prepare($sql);
    $p->execute();
    $productos = $p->fetchAll();
    Database::disconnect();
    return $productos;
}

//función que devuelve el listado de productos activos o que alguna vez tuvieron al menos una transacción en almacén.
//devuelve el listado de todos los productos con fecha menor o igual a fecha de la requisición incluyendo descripción, existencia, costo y costo promedio.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function productos_fecha($req_fecha){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Existencia con costo de existencia menor o igual a fecha de la requisicion
    $sql = 'SELECT T1.prod_id,T1.renglon_id,T1.renglon_codigo,COALESCE(T1.codigo,"N/A") AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,T1.nombre_presentacion ,T1.cantidad_unidad AS med_nm,COALESCE(T1.codigo_presentacion,"N/A") AS codigo_presentacion,T1.status AS prod_status,ing_ing_id,sum(ing_cant),sum(ing_costo),sum(egr_cant), sum(ing_cant-COALESCE(egr_cant,0)) AS existencia, sum((ing_costo/ing_cant)*(ing_cant-COALESCE(egr_cant,0))) AS existencia_costo
            FROM vp_catalogo_insumos AS T1 
            LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo
                       FROM alm_ingreso AS T2 
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento, fac_fecha
                                    FROM alm_factura AS T1
                                    LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                    GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                       WHERE T2.ing_status=1 AND T3.fac_status=1 and T3.fac_fecha <= ?) AS ing on T1.prod_id = ing.ing_prod 
            LEFT JOIN (SELECT sum(T4.egr_cant) AS egr_cant,T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id 
                       FROM alm_egreso AS T4 
                       LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id 
                       WHERE T4.egr_status = 1 AND T5.req_status not LIKE 0 group by T4.ing_id ) AS egr on egr_ing_id = ing_ing_id
            group by T1.prod_id
            HAVING T1.status like 1 or sum(ing_cant) > 0
            ORDER BY  T1.prod_id ASC';
    $p = $pdo->prepare($sql);
    $p->execute(array($req_fecha));
    $productos = $p->fetchAll();
    Database::disconnect();
    return $productos;
}

//Fución que usando el id devuelve la información individual de un producto incluyendo descripción, existencia, costo y costo promedio.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function producto_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.prod_id,T1.renglon_id,coalesce(T1.renglon_codigo,0) AS renglon_codigo,COALESCE(T1.codigo,'N/A') AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,T1.nombre_presentacion,T1.cantidad_unidad AS med_nm,COALESCE(T1.codigo_presentacion,'N/A') AS med_id,T1.status AS prod_status,ing_ing_id,sum(ing_cant),sum(ing_costo),sum(egr_cant), sum(ing_cant-COALESCE(egr_cant,0)) AS existencia, sum((ing_costo/ing_cant)*(ing_cant-COALESCE(egr_cant,0))) AS existencia_costo
            FROM vp_catalogo_insumos AS T1 
            LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo
                       FROM alm_ingreso AS T2 
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                    FROM alm_factura AS T1
                                    LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                    GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                       WHERE T2.ing_status=1 AND T3.fac_status=1) AS ing on T1.prod_id = ing.ing_prod 
            LEFT JOIN (SELECT sum(T4.egr_cant) AS egr_cant,T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id 
                       FROM alm_egreso AS T4 
                       LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id 
                       WHERE T4.egr_status = 1 AND T5.req_status not LIKE 0 group by T4.ing_id ) AS egr on egr_ing_id = ing_ing_id
            WHERE prod_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $producto = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $producto;
}

//Fución que usando el id devuelve a la fecha de la requisición la información individual de un producto incluyendo descripción, existencia, costo y costo promedio.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function producto_info_fecha($id,$req_fecha){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.prod_id,T1.renglon_id,T1.renglon_codigo,COALESCE(T1.codigo,'N/A') AS prod_cod,T1.nombre AS prod_nm,T1.caracteristicas AS prod_desc,T1.minimo AS prod_min,T1.maximo AS prod_max,T1.nombre_presentacion,T1.cantidad_unidad AS med_nm,COALESCE(T1.codigo_presentacion,'N/A') AS med_id,T1.status AS prod_status,ing_ing_id,sum(ing_cant),sum(ing_costo),sum(egr_cant), sum(ing_cant-COALESCE(egr_cant,0)) AS existencia, sum((ing_costo/ing_cant)*(ing_cant-COALESCE(egr_cant,0))) AS existencia_costo
            FROM vp_catalogo_insumos AS T1 
            LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo
                       FROM alm_ingreso AS T2 
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento, fac_fecha
                                    FROM alm_factura AS T1
                                    LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                    GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id 
                       WHERE T2.ing_status=1 AND T3.fac_status=1 and T3.fac_fecha <= ?) AS ing on T1.prod_id = ing.ing_prod 
            LEFT JOIN (SELECT sum(T4.egr_cant) AS egr_cant,T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id 
                       FROM alm_egreso AS T4 
                       LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id 
                       WHERE T4.egr_status = 1 AND T5.req_status not LIKE 0 group by T4.ing_id ) AS egr on egr_ing_id = ing_ing_id
            WHERE prod_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($req_fecha,$id));
    $producto = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $producto;
}


//Función que devuelve los ingresos de un producto en especifico a la fecha de la requisición.
function producto_ingresos($prod_id,$req_fecha){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.ing_id,T1.prod_id,ing.ing_cant,COALESCE(sum(egr.egr_cant),0) as egresos, ing_fecha
                    FROM alm_ingreso AS T1
                    LEFT JOIN (SELECT T2.ing_id,T2.prod_id,T2.ing_cant, T3.fac_fecha as ing_fecha
                      FROM alm_ingreso AS T2
                      LEFT JOIN alm_factura AS T3 ON T2.fac_id = T3.fac_id
                      WHERE T2.ing_status=1 AND T3.fac_status=1) AS ing on T1.ing_id = ing.ing_id
                    LEFT JOIN (SELECT T4.ing_id,T4.prod_id,T4.egr_cant
                      FROM alm_egreso AS T4
                      LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id
                      WHERE T4.egr_status = 1 AND T5.req_status NOT LIKE 0 ) AS egr on T1.ing_id = egr.ing_id
                    WHERE ing.prod_id = ? and ing_fecha <= ? 
                    group by T1.ing_id 
                    order by ing_fecha, T1.ing_id asc';
    $i = $pdo->prepare($sql);
    $i->execute(array($prod_id,$req_fecha));
    $producto_ingresos = $i->fetchAll();
    Database::disconnect();
    return $producto_ingresos;
}

function producto_duplicado($prod_id,$codigo,$codigo_presentacion){
    $productos = productos();
    $duplicado = false;
    if($codigo != null && $codigo_presentacion != null){
        foreach($productos as $producto){
            if ($producto['prod_cod'] == $codigo && $producto['codigo_presentacion'] == $codigo_presentacion && $producto['prod_id'] != $prod_id){
                $duplicado = true;
            }
        }
        return $duplicado;
    }
}

//Función para agregar nuevo producto en el sistema de forma manual.
function producto_nuevo($renglon_id,$codigo,$nombre,$caracteristicas,$minimo,$maximo,$nombre_presentacion,$cantidad_unidad,$codigo_presentacion,$status,$user_id){
    (($codigo == 0)? ($codigo_nuevo = null):($codigo_nuevo = $codigo));
    (($codigo_presentacion == 0)? ($codigo_presentacion_nuevo = null):($codigo_presentacion_nuevo = $codigo_presentacion));
    if(producto_duplicado(0,$codigo_nuevo,$codigo_presentacion_nuevo)) {
        throw new Exception('Ya existe combinación de código y código de presentación.');
    }else{
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO vp_catalogo_insumos (renglon_id,codigo,nombre,caracteristicas,minimo,maximo,nombre_presentacion,cantidad_unidad,codigo_presentacion,status,user_id) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($renglon_id, $codigo_nuevo, $nombre, $caracteristicas, $minimo, $maximo, $nombre_presentacion, $cantidad_unidad, $codigo_presentacion_nuevo, $status, $user_id));
        Database::disconnect();
    }
}

//Función para modificar un producto en el sistema de forma manual.
function producto_modificar($renglon_id,$codigo,$nombre,$caracteristicas,$minimo,$maximo,$nombre_presentacion,$cantidad_unidad,$codigo_presentacion,$status,$user_id,$id){
    (($codigo == 0)? ($codigo_nuevo = null):($codigo_nuevo = $codigo));
    (($codigo_presentacion == 0)? ($codigo_presentacion_nuevo = null):($codigo_presentacion_nuevo = $codigo_presentacion));
    if(producto_duplicado($id,$codigo_nuevo,$codigo_presentacion_nuevo)) {
        throw new Exception('Ya existe combinación de código y código de presentación.');
    }else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE vp_catalogo_insumos SET renglon_id = ?,codigo = ?,nombre = ?,caracteristicas = ?,minimo = ?,maximo = ?,nombre_presentacion = ?,cantidad_unidad = ?,codigo_presentacion = ?,status = ?,user_id = ? WHERE prod_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($renglon_id, $codigo_nuevo, $nombre, $caracteristicas, $minimo, $maximo, $nombre_presentacion, $cantidad_unidad, $codigo_presentacion_nuevo, $status, $user_id, $id));
        Database::disconnect();
    }
}

//funciones de facturas
function facturas() {
    $pdo = Database::connect();
    $sql = "SELECT T1.fac_id,fac_serie,fac_num,fac_fecha,fac_desc,fac_descuento,T1.orden_id,fac_1h,fac_control,fac_status,T1.prov_id,prov_nm,prov_nit, coalesce(sum(T3.ing_costo),0) as costo_total, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo-T3.ing_descuento)),0) AS porcentaje_descuento, coalesce(egresos,0) AS egresos,ing_cant, (ing_cant - COALESCE(egresos,0)) AS disponible, COALESCE(count(T3.ing_id),0) AS ingresos, (FLOOR(COALESCE(COUNT(T3.ing_id),0)/15) + 1) AS hojas
            FROM alm_factura AS T1
            LEFT JOIN df_proveedor AS T2 on T1.prov_id = T2.prov_id
            LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
            LEFT JOIN (SELECT sum(egr_cant) AS egresos, ing_id
                       FROM alm_egreso AS T5
                       LEFT JOIN alm_requisicion AS T6 on T5.req_id = T6.req_id
                       WHERE egr_status = 1 and req_status != 0
                       GROUP BY ing_id) AS egr on T3.ing_id = egr.ing_id
            GROUP BY T1.fac_id 
            order by fac_fecha desc, fac_1h desc";
    $p = $pdo->prepare($sql);
    $p->execute();
    $facturas = $p->fetchAll();
    Database::disconnect();
    return $facturas;
}

function factura_info($id){
    $pdo = Database::connect();
    $sql = 'SELECT T1.fac_id,fac_serie,fac_num,fac_fecha,T1.orden_id,fac_desc,fac_obs,fac_descuento,fac_1h,fac_control,fac_status,fac_rev,T1.prov_id,prov_nm,prov_nit, coalesce(sum(T3.ing_costo),0) as costo_total,  coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento, coalesce(egresos,0) AS egresos, ing_cant, (ing_cant - COALESCE(egresos,0)) AS disponible, COALESCE(count(T3.ing_id),0) AS ingresos, (FLOOR(COALESCE(COUNT(T3.ing_id),0)/15) + 1) AS hojas
            FROM alm_factura AS T1
            LEFT JOIN df_proveedor AS T2 on T1.prov_id = T2.prov_id
            LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
            LEFT JOIN (SELECT sum(egr_cant) AS egresos, ing_id
                       FROM alm_egreso AS T5
                       LEFT JOIN alm_requisicion AS T6 on T5.req_id = T6.req_id
                       WHERE egr_status = 1 and req_status = 1
                       GROUP BY ing_id) AS egr on T3.ing_id = egr.ing_id
            WHERE  T1.fac_id like ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $factura_info = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $factura_info;
}

function facturas_validadas() {
    $pdo = Database::connect();
    $sql ='SELECT count(fac_id) AS total FROM alm_factura WHERE fac_status = 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_validadas = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $facturas_validadas['total'];
}

function facturas_temporales() {
    $pdo = Database::connect();
    $sql ='SELECT count(fac_id) AS total FROM alm_factura WHERE fac_status = 2';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_temporales = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $facturas_temporales['total'];
}

function facturas_anuladas() {
    $pdo = Database::connect();
    $sql ='SELECT count(fac_id) AS total FROM alm_factura WHERE fac_status = 0';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_anuladas = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $facturas_anuladas['total'];
}

function facturas_total() {
    $pdo = Database::connect();
    $sql ='SELECT count(fac_id) AS total FROM alm_factura';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_total = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $facturas_total['total'];
}

function nuevo_1h() {
    $pdo = Database::connect();
    $sql ='SELECT T1.fac_id,COALESCE(T1.fac_1h,0) AS ultimo_1h, COALESCE(ingresos,0) AS ingresos ,  (COALESCE(T1.fac_1h,0) + FLOOR(COALESCE(INGRESOS,0)/15) + 1) AS nuevo_1h
           FROM alm_factura AS T1
           LEFT JOIN (SELECT T2.fac_id,count(ing_id) AS ingresos
                     FROM alm_ingreso AS T2
                     LEFT JOIN alm_factura AS T3 on T2.fac_id = T3.fac_id
                     WHERE ing_status = 1
                     GROUP BY T3.fac_id) AS ing on T1.fac_id = ing.fac_id
           ORDER BY fac_id DESC
           LIMIT 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_1h = $f->fetch(PDO::FETCH_ASSOC);
    $fac_1h = $facturas_1h['nuevo_1h'];
    Database::disconnect();
    if (number_format($fac_1h) == 0){$fac_1h = 1;}
    return $fac_1h;
}

function duplicado_1h($validar_1h,$id){
    $duplicado = FALSE;
    $id = number_format($id);
    foreach (facturas() as $factura){
        $fac_id = $factura['fac_id'];
        $fac_1h = $factura['fac_1h'];
        $hojas = $factura['hojas'];
        for($x = 1; $x <= $hojas; $x++){
            if ($fac_1h == $validar_1h &&  $fac_id != $id){
                    $duplicado=TRUE;
            }
            $fac_1h++;
        }
    }
    return $duplicado;
}

function validacion_1h(){
    $validar_1h = $_GET['fac_1h'];
    $fac_id = $_GET['fac_id'];
    $duplicado = duplicado_1h($validar_1h,$fac_id);
    if ($duplicado == 0 )
    {
        return 'true';
    }else{
        return 'false';
    }
}

function duplicado_control($validar_control,$id){
    $duplicado = FALSE;
    $id = number_format($id,0);
    foreach (facturas() as $factura){
        $fac_id = $factura['fac_id'];
        $fac_control = $factura['fac_control'];
        $hojas = $factura['hojas'];
        for($x = 1; $x <= $hojas; $x++){
            if (number_format($fac_control) == number_format($validar_control) && $fac_id != $id){
                $duplicado=TRUE;
            }
            $fac_control++;
        }
    }
    return $duplicado;
}

function nuevo_control() {
    $pdo = Database::connect();
    $sql ='SELECT T1.fac_id,COALESCE(T1.fac_control,0) AS ultimo_control, COALESCE(ingresos,0) AS ingresos ,  (COALESCE(T1.fac_control,0) + FLOOR(COALESCE(INGRESOS,0)/15) + 1) AS nuevo_control
           FROM alm_factura AS T1
           LEFT JOIN (SELECT T2.fac_id,count(ing_id) AS ingresos
                     FROM alm_ingreso AS T2
                     LEFT JOIN alm_factura AS T3 on T2.fac_id = T3.fac_id
                     WHERE ing_status = 1
                     GROUP BY T3.fac_id) AS ing on T1.fac_id = ing.fac_id
           ORDER BY fac_id DESC
           LIMIT 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $facturas_control = $f->fetch(PDO::FETCH_ASSOC);
    $fac_control = $facturas_control['nuevo_control'];
    Database::disconnect();
    if (number_format($fac_control) == 0){$fac_control = 1;}
    return $fac_control;
}

function factura_nueva(){
    $id = null;
    $fac_serie = $_POST['fac_serie'];
    $fac_num = $_POST['fac_num'];
    $fac_fecha = fecha_ymd($_POST['fac_fecha']);
    $prov_id = $_POST['prov_id'];
    $orden_id = $_POST['orden_id'];
    $fac_1h = $_POST['fac_1h'];
    $fac_control = $_POST['fac_control'];
    $fac_obs = $_POST['fac_obs'];
    $fac_descuento = $_POST['fac_descuento'];
    $fac_status = 2;
    $user_id = $_SESSION['user_id'];
    $fac_rev = 1;
    if (facturas_temporales() == 0){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alm_factura (fac_serie,fac_num,fac_fecha,prov_id,orden_id,fac_1h,fac_control,fac_obs,fac_descuento,fac_status,user_id,fac_rev) values(?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($fac_serie,$fac_num,$fac_fecha,$prov_id,$orden_id,number_format($fac_1h),$fac_control,$fac_obs,$fac_descuento,$fac_status,$user_id,$fac_rev));
        $id = $pdo->lastInsertId();
        Database::disconnect();
    }
    return $id;
}

function factura_ingresos_completos($id){
    $pdo = Database::connect();
    $sql = 'SELECT prod_id, fac_id
            FROM alm_ingreso
            WHERE fac_id like ?
            GROUP BY prod_id
            ORDER BY prod_id';
    $i = $pdo->prepare($sql);
    $i->execute(array($id));
    $factura_ingresos = $i->fetchAll();
    Database::disconnect();
    return $factura_ingresos;
}

function factura_modificar($fac_status,$id){
    $fac_serie = $_POST['fac_serie'];
    $fac_num = $_POST['fac_num'];
    $fac_fecha = fecha_ymd($_POST['fac_fecha']);
    $prov_id = $_POST['prov_id'];
    $orden_id = $_POST['orden_id'];
    $fac_1h = $_POST['fac_1h'];
    $fac_control = $_POST['fac_control'];
    $fac_desc = $_POST['fac_desc'];
    $fac_obs = $_POST['fac_obs'];
    $fac_descuento = $_POST['fac_descuento'];
    $user_id = $_SESSION['user_id'];
    $factura = factura_info($id);
    $duplicado = duplicado_1h($fac_1h,$id);
    if($factura['fac_status'] != 0 && $duplicado == 0){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_factura SET fac_serie = ?, fac_num = ?, fac_fecha = ?, prov_id = ?, fac_1h = ?, fac_control = ?, orden_id = ?, fac_desc = ?, fac_obs = ?, fac_descuento = ?, user_id = ?,fac_status = ?, fac_rev = fac_rev + 1 WHERE fac_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($fac_serie,$fac_num,$fac_fecha,$prov_id,$fac_1h,$fac_control,$orden_id,$fac_desc,$fac_obs,$fac_descuento,$user_id,$fac_status,$id));
        Database::disconnect();
    }
    if($fac_status == 1){
        $factura_ingresos = factura_ingresos_completos($id);
        foreach ($factura_ingresos as $factura_ingreso){
            kardex($factura_ingreso['prod_id']);
        }
    }
}

function factura_congelar($id){
    $fac_status = 0;
    $fac_serie = $_POST['fac_serie'];
    $fac_num = $_POST['fac_num'];
    $fac_fecha = fecha_ymd($_POST['fac_fecha']);
    $prov_id = $_POST['prov_id'];
    $orden_id = $_POST['orden_id'];
    $fac_1h = $_POST['fac_1h'];
    $fac_control = $_POST['fac_control'];
    $fac_desc = $_POST['fac_desc'];
    $fac_obs = $_POST['fac_obs'];
    $fac_descuento = $_POST['fac_descuento'];
    $user_id = $_SESSION['user_id'];
    $factura = factura_info($id);
    $duplicado = duplicado_1h($fac_1h,$id);
    if($factura['fac_status'] != 0 && $duplicado == 0){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_factura SET fac_serie = ?, fac_num = ?, fac_fecha = ?, prov_id = ?, fac_1h = ?, fac_control = ?, orden_id = ?, fac_desc = ?, fac_obs = ?, fac_descuento = ?, user_id = ?,fac_status = 1, fac_rev = fac_rev + 1 WHERE fac_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($fac_serie,$fac_num,$fac_fecha,$prov_id,$fac_1h,$fac_control,$orden_id,$fac_desc,$fac_obs,$fac_descuento,$user_id,$id));
        Database::disconnect();
        $fac_status = 1;
    }
    if($fac_status == 1){
        $factura_ingresos = factura_ingresos_completos($id);
        foreach ($factura_ingresos as $factura_ingreso){
            kardex($factura_ingreso['prod_id']);
        }
    }
}

function factura_anular($user_id,$fac_desc,$id){
    $factura = factura_info($id);
    if($factura['disponible'] == $factura['ing_cant'] && $factura['fac_status'] != 0){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_factura SET fac_status = 0, user_id = ?,fac_desc = ?, fac_rev = fac_rev + 1 WHERE fac_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($user_id,$fac_desc,$id));
        Database::disconnect();
        $factura_ingresos = factura_ingresos_completos($id);
        foreach ($factura_ingresos as $factura_ingreso){
            kardex($factura_ingreso['prod_id']);
        }
    }
}


//funciones de ingresos

//devuelve ingresos ingresos asociados a una factura
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function factura_ingresos($id){
    $pdo = Database::connect();
    $sql = 'SELECT T1.prod_id, renglon_id,T2.renglon_codigo,COALESCE(T2.codigo,"N/A") AS prod_cod,T2.nombre AS prod_nm,T2.caracteristicas AS prod_desc,T2.status AS prod_status,COALESCE(T2.codigo_presentacion,"N/A") AS med_id,T2.nombre_presentacion,T2.cantidad_unidad AS med_nm,T1.ing_id,ing_desc,ing_cant,((coalesce(ing_costo,0)- coalesce(ing_descuento) - coalesce(ing_costo*porcentaje_descuento))/coalesce(ing_cant,0)) AS costo_unitario,ing_costo AS costo_subtotal, (ing_descuento+(ing_costo*porcentaje_descuento)) AS descuento, (ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo,ing_descuento,ing_status,T1.fac_id,folio_alm,folio_inv,nom_id,(ing_cant - coalesce(egresos,0)) AS disponible,coalesce(egresos,0) AS egresos,fac_status,factura_subtotal,fac_descuento,porcentaje_descuento
            FROM alm_ingreso AS T1
            LEFT JOIN vp_catalogo_insumos AS T2 on T1.prod_id = T2.prod_id
            LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                        FROM alm_factura AS T1
                        LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                        GROUP BY T1.fac_id) AS fac on T1.fac_id = fac.fac_id
            LEFT JOIN (SELECT sum(egr_cant) AS egresos, ing_id
                       FROM alm_egreso AS T5
                       LEFT JOIN alm_requisicion AS T6 on T5.req_id = T6.req_id
                       WHERE egr_status = 1 and req_status not like 0
                       GROUP BY ing_id) AS egr on T1.ing_id = egr.ing_id
            WHERE T1.ing_status like 1 and T1.fac_id like ?
            ORDER BY T1.ing_id';
    $i = $pdo->prepare($sql);
    $i->execute(array($id));
    $factura_ingresos = $i->fetchAll();
    Database::disconnect();
    return $factura_ingresos;
}


//función que con el ID devuelve el detalle indivicual de un ingreso
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function ingreso_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.prod_id as prod_id,fac_fecha,T2.renglon_id,renglon_codigo,COALESCE(T2.codigo,"N/A") AS prod_cod,T2.nombre AS prod_nm,T2.caracteristicas AS prod_desc,T2.status AS prod_status,T2.nombre_presentacion,T2.cantidad_unidad AS med_nm,COALESCE(T2.codigo_presentacion,"N/A") AS med_id,fac_num,fac_serie,T1.ing_id,ing_desc,ing_cant,((coalesce(ing_costo,0)- coalesce(ing_descuento) - coalesce(ing_costo*porcentaje_descuento))/coalesce(ing_cant,0)) AS costo_unitario,ing_costo AS costo_subtotal, (ing_descuento+(ing_costo*porcentaje_descuento)) AS descuento, (ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo,ing_descuento,ing_status,T1.fac_id,folio_alm,folio_inv,nom_id,(ing_cant - coalesce(egresos,0)) AS disponible,coalesce(egresos,0) AS egresos,fac_status,factura_subtotal,fac_descuento,porcentaje_descuento
            FROM alm_ingreso AS T1
            LEFT JOIN vp_catalogo_insumos AS T2 on T1.prod_id = T2.prod_id
            LEFT JOIN (SELECT T1.fac_id,fac_status,fac_fecha, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento, fac_serie, fac_num
                        FROM alm_factura AS T1
                        LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                        GROUP BY T1.fac_id) AS fac on T1.fac_id = fac.fac_id
            LEFT JOIN (SELECT sum(egr_cant) AS egresos, ing_id
                       FROM alm_egreso AS T5
                       LEFT JOIN alm_requisicion AS T6 on T5.req_id = T6.req_id
                       WHERE egr_status = 1 and req_status not like 0
                       GROUP BY ing_id) AS egr on T1.ing_id = egr.ing_id
            WHERE T1.ing_status like 1 and fac_status not like 0 and T1.ing_id like ? ';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $ingreso_info = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $ingreso_info;
}

function ingreso_nuevo($id){
    $fac_id = $id;
    $prod_id = $_POST['prod_id'];
    $ing_desc = $_POST['ing_desc'];
    $ing_cant = $_POST['ing_cant'];
    $ing_costo = $_POST['ing_costo'];
    $ing_descuento = $_POST['ing_descuento'];
    $folio_alm = $_POST['folio_alm'];
    $folio_inv = $_POST['folio_inv'];
    $nom_id = $_POST['nom_id'];
    $ing_status = 1;
    $user_id = $_SESSION['user_id'];
    $ing_rev = 1;
    $factura = factura_info($id);
    if ($ing_cant > 0 && $factura['fac_status'] == 2) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alm_ingreso (prod_id,ing_desc,ing_cant,ing_costo,ing_descuento,fac_id,folio_alm,folio_inv,nom_id,ing_status,user_id,ing_rev) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($prod_id,$ing_desc,$ing_cant,$ing_costo,$ing_descuento,$fac_id,$folio_alm,$folio_inv,$nom_id,$ing_status,$user_id,$ing_rev));
        Database::disconnect();
    }
}

function ingreso_modificar($id){
    $ing_id = $id;
    $ing_desc = $_POST['ing_desc'];
    $ing_cant = $_POST['ing_cant'];
    $ing_costo = $_POST['ing_costo'];
    $ing_descuento = $_POST['ing_descuento'];
    $user_id = $_SESSION['user_id'];
    $folio_alm = $_POST['folio_alm'];
    $folio_inv = $_POST['folio_inv'];
    $nom_id = $_POST['nom_id'];
    $ingreso_info = ingreso_info($id);
    if($ingreso_info['egresos'] <= $ingreso_info['ing_cant'] && $ing_cant > 0 && $ingreso_info['prod_status'] == 1 && $ingreso_info['ing_status'] == 1 && $ingreso_info['fac_status'] == 2){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_ingreso SET  ing_desc = ?, ing_cant = ?, ing_costo = ?, ing_descuento = ?, folio_alm = ?, folio_inv = ?, nom_id = ?, user_id = ?, ing_rev = ing_rev + 1 WHERE ing_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($ing_desc, $ing_cant,$ing_costo,$ing_descuento,$folio_alm,$folio_inv,$nom_id,$user_id,$ing_id));
        Database::disconnect();
    }
}

function ingreso_borrar($id){
    $ing_id = $id;
    $user_id = $_SESSION['user_id'];
    $ingreso_info = ingreso_info($id);
    if($ingreso_info['disponible'] == $ingreso_info['ing_cant'] && $ingreso_info['prod_status'] == 1 && $ingreso_info['ing_status'] == 1 && $ingreso_info['fac_status'] == 2){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_ingreso SET ing_status = 0, user_id = ?, ing_rev = ing_rev + 1 WHERE ing_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($user_id,$ing_id));
        Database::disconnect();
    }
}


//Función que devuelve los egresos asociados a un ingreso.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function ingreso_egresos($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.prod_id, T2.renglon_id,T2.renglon_codigo,COALESCE(T2.codigo,"N/A") AS prod_cod,T2.nombre AS prod_nm,T2.caracteristicas AS prod_desc,T2.status AS prod_status,T2.nombre_presentacion,T2.cantidad_unidad AS med_nm,T1.ing_id,ing_status,ing_desc,ing_cant,((coalesce(ing_costo,0)- coalesce(ing_descuento) - coalesce(ing_costo*porcentaje_descuento))/coalesce(ing_cant,0)) AS costo_unitario, (ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo,T1.fac_id,fac_status,egr_id, req_id,req_num,coalesce(egresos,0) AS egresos,egr_fecha,fac_fecha as ing_fecha
            FROM alm_ingreso AS T1
            LEFT JOIN vp_catalogo_insumos AS T2 on T1.prod_id = T2.prod_id
            LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento, fac_fecha
                        FROM alm_factura AS T1
                        LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                        GROUP BY T1.fac_id) AS fac on T1.fac_id = fac.fac_id
            LEFT JOIN (SELECT egr_id, T5.req_id, egr_cant AS egresos, ing_id, req_num, egr_fecha
                       FROM alm_egreso AS T5
                       LEFT JOIN alm_requisicion AS T6 on T5.req_id = T6.req_id
                       WHERE egr_status = 1 and req_status not like 0
                       GROUP BY egr_id) AS egr on T1.ing_id = egr.ing_id
            WHERE T1.ing_status like 1 and fac_status not like 0 and egr_id is not null and T1.ing_id like ? 
            ORDER BY egr_fecha asc';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $ingreso_egresos = $q->fetchAll();
    Database::disconnect();
    return $ingreso_egresos;
}

//funciones de requisiciones
function requisiciones(){
    $pdo = Database::connect();
    $sql = "SELECT T1.req_id as req_id,req_num,req_status,req_fecha,req_obs,T1.req_user,T2.user_id,user_pref,user_nm1,user_ap1, T1.dep_id, dep_nm, total.prod_total AS prod_total, total.req_total AS req_total
            FROM alm_requisicion AS T1
            left join vp_user AS T2 on T2.user_id = T1.req_user
            left join vp_deptos AS T3 on T3.dep_id = T1.dep_id
            left join (SELECT T4.req_id, count(DISTINCT(concat(T4.prod_id))) AS prod_total, sum(T4.egr_cant * ((T5.ing_costo - T5.ing_descuento - (T5.ing_costo*porcentaje_descuento))/T5.ing_cant)) AS req_total
                       FROM alm_egreso AS T4
                       LEFT JOIN alm_ingreso AS T5 on T4.ing_id = T5.ing_id
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                FROM alm_factura AS T1
                                LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                GROUP BY T1.fac_id) AS T6 on T5.fac_id = T6.fac_id
                       WHERE T4.egr_status = 1 and T5.ing_status = 1 and T6.fac_status NOT LIKE 0
                       GROUP BY T4.req_id) as total on  T1.req_id = total.req_id
            order by req_fecha DESC,req_num DESC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $requisiciones = $p->fetchAll();
    Database::disconnect();
    return $requisiciones;
}

function requisicion_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT T1.req_id as req_id,req_num,req_status,req_fecha,req_obs,T1.req_user,T2.user_pref,T2.user_nm1,T2.user_ap1, T1.dep_id, dep_nm, coalesce(total.prod_total,0) AS prod_total, total.req_total AS req_total, T11.user_nm1 AS encargado_nm1, T11.user_ap1 AS encargado_ap1, egr_fecha
            FROM alm_requisicion AS T1
            left join vp_user AS T2 on T2.user_id = T1.req_user
            LEFT JOIN vp_user AS T11 on T1.user_id = T11.user_id
            left join vp_deptos AS T3 on T3.dep_id = T1.dep_id
            left join (SELECT T4.req_id, count(DISTINCT(concat(T4.prod_id))) AS prod_total, sum(T4.egr_cant * ((T5.ing_costo - T5.ing_descuento - (T5.ing_costo*porcentaje_descuento))/T5.ing_cant)) AS req_total, max(egr_fecha) as egr_fecha
                       FROM alm_egreso AS T4
                       LEFT JOIN alm_ingreso AS T5 on T4.ing_id = T5.ing_id
                       LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                FROM alm_factura AS T1
                                LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                GROUP BY T1.fac_id) AS T6 on T5.fac_id = T6.fac_id
                       WHERE T4.egr_status = 1 and T5.ing_status = 1 and T6.fac_status NOT LIKE 0
                       GROUP BY T4.req_id) as total on T1.req_id = total.req_id
            WHERE T1.req_id = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $requisicion = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $requisicion;
}

function requisiciones_validadas() {
    $pdo = Database::connect();
    $sql ='SELECT count(req_id) AS total FROM alm_requisicion WHERE req_status = 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $requisiciones_validadas = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $requisiciones_validadas['total'];
}

function requisiciones_temporales() {
    $pdo = Database::connect();
    $sql ='SELECT count(req_id) AS total FROM alm_requisicion WHERE req_status = 2';
    $f = $pdo->prepare($sql);
    $f->execute();
    $requisiciones_temporales = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $requisiciones_temporales['total'];
}

function requisiciones_anuladas() {
    $pdo = Database::connect();
    $sql ='SELECT count(req_id) AS total FROM alm_requisicion WHERE req_status = 0';
    $f = $pdo->prepare($sql);
    $f->execute();
    $requisiciones_anuladas = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $requisiciones_anuladas['total'];
}

function requisiciones_total() {
    $pdo = Database::connect();
    $sql ='SELECT count(req_id) AS total FROM alm_requisicion';
    $f = $pdo->prepare($sql);
    $f->execute();
    $requisiciones_total = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $requisiciones_total['total'];
}

function nuevo_req() {
    $pdo = Database::connect();
    $sql ='SELECT req_id,COALESCE(req_num,0) AS ultimo_req,  (COALESCE(req_num,0) +1 ) AS nuevo_req
           FROM alm_requisicion 
           ORDER BY req_id DESC
           LIMIT 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $requisicion_num = $f->fetch(PDO::FETCH_ASSOC);
    $req_num = $requisicion_num['nuevo_req'];
    Database::disconnect();
    if (number_format($req_num) == 0){$req_num = 1;}
    return $req_num;
}

function requisicion_nueva(){
    $req_num = $_POST['req_num'];
	$req_user = $_POST['req_user'];
    $req_fecha = fecha_ymd($_POST['req_fecha']);
    $req_obs = $_POST['req_obs'];
    $user_id = $_SESSION['user_id'];
    $dep_id = persona_info($req_user)['dep_id'];
    $pdo = Database::connect();
    $sql = "INSERT INTO alm_requisicion (req_num,req_user,dep_id,req_status,req_fecha,req_obs,user_id,req_rev) values(?, ?, ?, ?, ?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($req_num,$req_user,$dep_id,2,$req_fecha,$req_obs,$user_id,1));
    $id = $pdo->lastInsertId();
    Database::disconnect();
    return $id;
}

function requisicion_modificar($id){
    $req_num = $_POST['req_num'];
    $req_user = $_POST['req_user'];
    $dep_id = persona_info($req_user)['dep_id'];
    $req_fecha = fecha_ymd($_POST['req_fecha']);
    $req_obs = $_POST['req_obs'];
    $user_id = $_SESSION['user_id'];
    $requisicion = requisicion_info($id);
    $pdo = Database::connect();
    if ($requisicion['req_status'] != 0){
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE alm_requisicion SET req_num = ?, req_user = ?, dep_id = ?, req_fecha = ?, req_obs = ?, user_id = ?, req_status = ?, req_rev = req_rev + 1 WHERE req_id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($req_num,$req_user,$dep_id,$req_fecha,$req_obs,$user_id,2,$id));
    }
    Database::disconnect();
}

function requisicion_egresos_completos($id){
    $pdo = Database::connect();
    $sql = 'SELECT prod_id, req_id
            FROM alm_egreso
            WHERE req_id like ?
            GROUP BY prod_id
            ORDER BY prod_id';
    $i = $pdo->prepare($sql);
    $i->execute(array($id));
    $factura_ingresos = $i->fetchAll();
    Database::disconnect();
    return $factura_ingresos;
}

function requisicion_congelar($id){
    $req_num = $_POST['req_num'];
    $req_user = $_POST['req_user'];
    $dep_id = persona_info($req_user)['dep_id'];
    $req_fecha = fecha_ymd($_POST['req_fecha']);
    $req_obs = $_POST['req_obs'];
    $user_id = $_SESSION['user_id'];
    $requisicion = requisicion_info($id);
    $pdo = Database::connect();
    if ($requisicion['req_status'] != 0){
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE alm_requisicion SET req_num = ?, req_user = ?, dep_id = ?, req_fecha = ?, req_obs = ?, user_id = ?, req_status = ?, req_rev = req_rev + 1 WHERE req_id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($req_num,$req_user,$dep_id,$req_fecha,$req_obs,$user_id,1,$id));
    }
    Database::disconnect();

    $requisicion_egresos = requisicion_egresos_completos($id);
    foreach ($requisicion_egresos as $requisicion_egreso){
        kardex($requisicion_egreso['prod_id']);
    }
}

function requisicion_anular($id){
    $user_id = $_SESSION['user_id'];
    $req_obs = $_POST['req_obs'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'UPDATE alm_requisicion SET req_status = ?, req_obs = ?, user_id = ?, req_rev = req_rev + 1 WHERE req_id = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array(0,$req_obs,$user_id,$id));
    Database::disconnect();

    $requisicion_egresos = requisicion_egresos_completos($id);
    foreach ($requisicion_egresos as $requisicion_egreso){
        kardex($requisicion_egreso['prod_id']);
    }
}

//listado de egresosos asociados a una requisición agrupados por tipo de producto.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function requisicion_egresos_agrupados($id){
    $pdo = Database::connect();
    //Egresos agrupados por costo unitario
    $sql = 'SELECT egr_id,T1.prod_id, T1.ing_id, renglon_id,T2.renglon_codigo,COALESCE(T2.codigo,"N/A") AS prod_cod,T2.nombre AS prod_nm,T2.caracteristicas AS prod_desc,T2.nombre_presentacion,T2.cantidad_unidad AS med_nm,sum(egr_cant) AS egr_cant,T1.req_id,egr_fecha,sum(ing_cant) as ing_cant,sum(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) as ing_costo,T2.status AS prod_status,(sum((ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)))/sum(ing_cant)) AS costo_unitario,((sum((ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)))/sum(ing_cant))*sum(egr_cant)) AS costo_total,req_status,fac_status,ing_status
          FROM alm_egreso AS T1
          LEFT JOIN vp_catalogo_insumos AS T2 on T1.prod_id = T2.prod_id
          LEFT JOIN alm_ingreso AS T4 on T1.ing_id = T4.ing_id
          LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                     FROM alm_factura AS T1
                     LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                     GROUP BY T1.fac_id) AS T5 on T4.fac_id = T5.fac_id          
          LEFT JOIN alm_requisicion AS T6 on T1.req_id = T6.req_id
          WHERE T1.egr_status like 1 and ing_status = 1 and fac_status NOT LIKE 0 and T1.req_id = ?
          GROUP BY T1.prod_id
          ORDER BY egr_id desc';
    $e = $pdo->prepare($sql);
    $e->execute(array($id));
    $egresos_agrupados = $e->fetchAll();
    Database::disconnect();
    return $egresos_agrupados;
}

//listado de egresos asociados a una requisición por transacción individual.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function requisicion_egresos_unitarios($id){
    $pdo = Database::connect();
    $sql = 'SELECT egr_id,T1.prod_id, T1.ing_id,T2.renglon_id,T2.renglon_codigo,COALESCE(T2.codigo,"N/A") AS prod_cod,T2.nombre AS prod_nm,T2.caracteristicas AS prod_desc,T2.nombre_presentacion,T2.cantidad_unidad AS med_nm,sum(egr_cant) AS egr_cant,T1.req_id,egr_fecha,ing_cant,ing_costo,T2.status AS prod_status,((ing_costo - ing_descuento - (ing_costo*porcentaje_descuento))/ing_cant) AS costo_unitario,(((ing_costo - ing_descuento - (ing_costo*porcentaje_descuento))/ing_cant)*sum(egr_cant)) AS costo_total,req_status,fac_status,ing_status
              FROM alm_egreso AS T1
              LEFT JOIN vp_catalogo_insumos AS T2 on T1.prod_id = T2.prod_id
              LEFT JOIN alm_ingreso AS T4 on T1.ing_id = T4.ing_id
              LEFT JOIN (SELECT T1.fac_id,fac_status, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                         FROM alm_factura AS T1
                         LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                         GROUP BY T1.fac_id) AS T5 on T4.fac_id = T5.fac_id  
              LEFT JOIN alm_requisicion AS T6 on T1.req_id = T6.req_id
              WHERE T1.egr_status like 1 and ing_status = 1 and fac_status NOT LIKE 0 and T1.req_id = ?
              group by egr_id
              order by egr_fechahora, T1.prod_id desc';
    $e = $pdo->prepare($sql);
    $e->execute(array($id));
    $egresos_unitarios = $e->fetchAll();
    Database::disconnect();
    return $egresos_unitarios;
}

//devuelve el detalle de un egreso de producto.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function egreso_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT egr_id,T1.prod_id,egr_cant,egr_fecha,T1.ing_id,T1.req_id,req_num, existencia,renglon_id,T3.renglon_codigo,COALESCE(T3.codigo,"N/A") AS prod_cod,T3.nombre AS prod_nm,T3.caracteristicas AS prod_desc,T3.nombre_presentacion,T3.cantidad_unidad AS med_nm,egr_status,req_status,ing_status,fac_status,T3.status AS prod_status, fac_fecha
            FROM alm_egreso AS T1
            LEFT JOIN alm_requisicion AS T2 ON T1.req_id = T2.req_id
            LEFT JOIN vp_catalogo_insumos AS T3 ON T1.prod_id = T3.prod_id
            LEFT JOIN (SELECT T1.ing_id AS ing_id,ing.ingreso AS ingreso,sum(egr.egreso) AS egreso, (ingreso-sum(egreso)) AS existencia, ing.ing_status AS ing_status, ing.fac_status AS fac_status, fac_fecha
                        FROM alm_ingreso AS T1
                        LEFT JOIN (SELECT T2.ing_id,T2.prod_id,T2.ing_cant AS ingreso,T2.ing_status,T3.fac_status,fac_fecha
                          FROM alm_ingreso AS T2
                          LEFT JOIN alm_factura AS T3 ON T2.fac_id = T3.fac_id
                          WHERE T2.ing_status=1 AND T3.fac_status=1) AS ing ON T1.ing_id = ing.ing_id
                        LEFT JOIN (SELECT T4.ing_id,T4.prod_id,T4.egr_cant AS egreso
                          FROM alm_egreso AS T4
                          LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id
                          WHERE T4.egr_status = 1 AND T5.req_status NOT LIKE 0 ) AS egr ON T1.ing_id = egr.ing_id
                          GROUP BY T1.ing_id ORDER BY T1.ing_id ASC) AS existencia ON  T1.ing_id = existencia.ing_id
            WHERE egr_id = ? AND egr_status = 1 AND req_status NOT LIKE 0';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $egreso_info = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $egreso_info;
}

function egreso_nuevo($id){
    $req_id = $id;
    $prod_id = $_POST['prod_id'];
    $egr_cant = $_POST['egr_cant'];
    $egr_fecha = fecha_ymd($_POST['egr_fecha']);
    $user_id = $_SESSION['user_id'];
    $req_fecha = requisicion_info($id)['req_fecha'];
    $ingresos = producto_ingresos($prod_id,$req_fecha);
    $pdo = Database::connect();
    $sql = "INSERT INTO alm_egreso (prod_id,egr_cant,egr_fecha,req_id,ing_id,egr_status,user_id,egr_rev) values(?, ?, ?, ?, ?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    foreach ($ingresos as $ingreso){
        if ($egr_cant > 0 ):
            $ingreso_existencia = $ingreso["ing_cant"] - $ingreso["egresos"];
            if($ingreso_existencia > 0):
                if ($ingreso_existencia >= $egr_cant){
                    $q->execute(array($prod_id,$egr_cant,$egr_fecha,$req_id,$ingreso['ing_id'],1,$user_id,1));
                    $egr_cant = 0;
                }else{
                    $q->execute(array($prod_id,$ingreso_existencia,$egr_fecha,$req_id,$ingreso['ing_id'],1,$user_id,1));
                    $egr_cant = $egr_cant-$ingreso_existencia;
                }
            endif;
        endif;
    }
    Database::disconnect();
}

function egreso_modificar($id){
    $egr_id = $id;
    $egr_cant = $_POST['egr_cant'];
    $egr_fecha = date("Y-m-d",strtotime($_POST['egr_fecha']));
    $user_id = $_SESSION['user_id'];
    $egreso = egreso_info($id);
    $disponible = $egreso['existencia'] + $egreso['egr_cant'];
    if ($disponible >= $egr_cant && $egreso['prod_status'] == 1 && $egreso['egr_status'] == 1 && $egreso['req_status'] == 2 && $egreso['ing_status'] == 1 && $egreso['fac_status'] == 1){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_egreso SET egr_cant = ?, egr_fecha = ?, user_id = ?, egr_rev = egr_rev + 1 WHERE egr_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($egr_cant,$egr_fecha,$user_id,$egr_id));
        Database::disconnect();
    }
}

function egreso_eliminar($id){
    $egr_id = $id;
    $user_id = $_SESSION['user_id'];
    $egreso = egreso_info($id);
    if($egreso['prod_status'] == 1 && $egreso['egr_status'] == 1 && $egreso['req_status'] == 2 && $egreso['ing_status'] == 1 && $egreso['fac_status'] == 1){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE alm_egreso SET egr_status = 0, user_id = ?, egr_rev = egr_rev + 1 WHERE egr_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($user_id,$egr_id));
        Database::disconnect();
    }
}

//funciones kardex

//Detalle de todas las transacciones de un producto.
//TODO: Eliminar necesitad de alias en columnas con nombre de anterior tabla.
function producto_inventario($id){
    $pdo = Database::connect();
    $sql="SELECT prod.prod_id, prod.status AS prod_status, prod.renglon_id,prod.renglon_codigo,COALESCE(prod.codigo,'N/A') AS prod_cod, prod.nombre AS prod_nm, prod.caracteristicas AS prod_desc,prod.nombre_presentacion,prod.cantidad_unidad AS med_nm,prov_nm,prov_nit,fac_serie,fac_num,req_num,user_nm1,user_ap1,ie_tipo AS tipo ,ie_fac_id,ie_req_id, ie_prod,ie_ing_id,ie_ing_cant,ie_ing_costo, (ie_ing_costo/ie_ing_cant) AS ie_costo_unitario, ie_egr_cant, ie_existencia, ie_existencia_costo, ie_egr_id,ie_fecha,ing_fecha, egr_fecha
            FROM vp_catalogo_insumos AS prod
            LEFT JOIN (SELECT 'ing' AS ie_tipo, T1.prod_id AS ie_prod,fac_id AS ie_fac_id, ing_ing_id AS ie_ing_id,ing_cant AS ie_ing_cant,ing_costo AS ie_ing_costo, null as ie_req_id, 0 AS ie_egr_cant,
                       0 AS ie_existencia, 0 AS ie_existencia_costo, 0 AS ie_egr_id, ing_fecha AS ie_fecha, ing_fecha as ing_fecha, NULL as egr_fecha
                       FROM vp_catalogo_insumos AS T1
                       LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T2.fac_id AS fac_id, T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo, fac_fecha AS ing_fecha
                                  FROM alm_ingreso AS T2
                                  LEFT JOIN (SELECT T1.fac_id,fac_status, fac_fecha, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                             FROM alm_factura AS T1
                                             LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                             GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id
                                  WHERE T2.ing_status=1 AND T3.fac_status=1 order by T3.fac_fecha) AS ing on T1.prod_id = ing.ing_prod
                       GROUP BY ie_ing_id
                       UNION
                       SELECT 'egr' AS ie_tipo, T1.prod_id AS ie_prod,NULL AS ie_fac_id, ing_ing_id AS ie_ing_id,ing_cant AS ie_ing_cant,ing_costo AS ie_ing_costo,req_id AS ie_req_id, egr_cant AS ie_egr_cant,
                       (ing_cant-(COALESCE(egr_cant,0))) AS ie_existencia, ((ing_costo/ing_cant)*(ing_cant-(COALESCE(egr_cant,0)))) AS ie_existencia_costo, egr_egr_id AS ie_egr_id, egr_fecha AS ie_fecha, ing_fecha as ing_fecha, egr_fecha as egr_fecha
                       FROM vp_catalogo_insumos AS T1
                       LEFT JOIN (SELECT T2.ing_id AS ing_ing_id,T3.fac_id AS ing_fac_id, T2.ing_cant as ing_cant,T2.prod_id As ing_prod ,(ing_costo - ing_descuento - (ing_costo*porcentaje_descuento)) AS ing_costo, fac_fecha AS ing_fecha
                                  FROM alm_ingreso AS T2
                                  LEFT JOIN (SELECT T1.fac_id,fac_status, fac_fecha, coalesce(sum(T3.ing_costo),0) as factura_subtotal, coalesce(fac_descuento,0) AS fac_descuento, coalesce((sum(T3.ing_costo-T3.ing_descuento) - T1.fac_descuento),0) AS factura_total, coalesce((T1.fac_descuento/sum(T3.ing_costo)),0) AS porcentaje_descuento
                                             FROM alm_factura AS T1
                                             LEFT JOIN alm_ingreso AS T3 on T1.fac_id = T3.fac_id and ing_status = 1
                                             GROUP BY T1.fac_id) AS T3 ON T2.fac_id = T3.fac_id
                                  WHERE T2.ing_status=1 AND T3.fac_status=1 order by T3.fac_fecha) AS ing on T1.prod_id = ing.ing_prod
                       LEFT JOIN (SELECT T4.egr_cant AS egr_cant,T4.req_id AS req_id, T4.prod_id AS egr_prod,T4.ing_id AS egr_ing_id, T4.egr_id AS egr_egr_id, req_fecha AS egr_fecha
                                  FROM alm_egreso AS T4
                                  LEFT JOIN alm_requisicion AS T5 ON T4.req_id = T5.req_id
                                  WHERE T4.egr_status = 1 AND T5.req_status = 1 order by T5.req_fecha) AS egr on egr_ing_id = ing_ing_id
                        GROUP BY ie_egr_id
                        ) AS movimiento on ie_prod = prod.prod_id
            LEFT JOIN alm_factura As T7 on ie_fac_id = T7.fac_id
            LEFT JOIN alm_requisicion AS T8 on ie_req_id = T8.req_id
            LEFT JOIN df_proveedor AS T9 on T7.prov_id = T9.prov_id
            LEFT JOIN vp_user AS T10 on T8.req_user = T10.user_id
            WHERE ie_fecha IS NOT NULL and prod_id like ?
            GROUP BY concat(ie_ing_id,ie_egr_id)
            ORDER BY ie_fecha asc,tipo desc, req_num asc";
    $e = $pdo->prepare($sql);
    $e->execute(array($id));
    $producto_inventario = $e->fetchAll();
    Database::disconnect();
    return $producto_inventario;
}


function producto_movimientos($id){
    $movimientos = producto_inventario($id);
    $movimientos_total = count($movimientos);
    return $movimientos_total;
}

function producto_kardex_num_asc($id){
    $pdo = Database::connect();
    $sql ='SELECT kx_id,kx_num,prod_id 
           FROM alm_kardex
           WHERE prod_id = ? and kx_status = 1
           ORDER BY kx_num ASC ';
    $f = $pdo->prepare($sql);
    $f->execute(array($id));
    $producto_kardex_num_asc = $f->fetchAll();
    Database::disconnect();
    return $producto_kardex_num_asc;
}

function producto_kardex_total($id){
    $pdo = Database::connect();
    $sql ='SELECT count(kx_id) AS total 
           FROM alm_kardex
           WHERE prod_id = ? and kx_status = 1';
    $f = $pdo->prepare($sql);
    $f->execute(array($id));
    $producto_kardex_total = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $producto_kardex_total['total'];
}

function nuevo_kardex_num() {
    $pdo = Database::connect();
    $sql ='SELECT kx_id,COALESCE(kx_num,0) AS ultimo_kardex
           FROM alm_kardex 
           ORDER BY kx_id DESC
           LIMIT 1';
    $f = $pdo->prepare($sql);
    $f->execute();
    $nuevo_kardex = $f->fetch(PDO::FETCH_ASSOC);
    $kx_num = $nuevo_kardex['ultimo_kardex'] + 1;
    Database::disconnect();
    if (number_format($kx_num) == 0){$kx_num = 1;}
    return $kx_num;
}

function kardex($id){
    $producto_movimientos = producto_movimientos($id);
    $producto_kardex_total = producto_kardex_total($id);
    $producto_kardex_num_asc = producto_kardex_num_asc($id);
    if ($producto_movimientos > 0){
        if ($producto_movimientos <= 25){
            if($producto_kardex_total == 0){
                kardex_nuevo($id);
            }else if($producto_kardex_total > 1){
                $control = 0;
                foreach($producto_kardex_num_asc as $producto_kardex_num){
                    $control++;
                    if ($control > 1){
                        kardex_anular($producto_kardex_num['kx_id']);
                    }
                }
            }
        }else{
            $hojas = ceil(($producto_movimientos -24)/23) + 1;
            if ($producto_kardex_total < $hojas){
                $hojas = $hojas - $producto_kardex_total;
                for($x = 1;$x <= $hojas;$x++){
                    kardex_nuevo($id);
                }
            }else if($producto_kardex_total > $hojas){
                $control = 0;
                foreach($producto_kardex_num_asc as $producto_kardex_num){
                    $control++;
                    if ($control > $hojas){
                        kardex_anular($producto_kardex_num['kx_id']);
                    }
                }
            }
        }
    }
}

function kardex_nuevo($id){
    $pdo = Database::connect();
    $sql = "INSERT INTO alm_kardex (kx_num,prod_id,kx_status,kx_rev) values(?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array(nuevo_kardex_num(),$id,1,1));
    Database::disconnect();
}

function kardex_anular($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'UPDATE alm_kardex SET kx_status = 0, kx_rev = kx_rev + 1 WHERE kx_id = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
}

