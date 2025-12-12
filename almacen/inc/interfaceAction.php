<?php
/**
 * Created by Stuart C.
 * Date: 21/09/2016
 * Time: 5:34 PM
 */

namespace almacen\inc;


interface interfaceAction
{
    public function infoAll(); //devuelve todos los elementos del tipo de la clase
    public function infoByID($id); //devuelve la información de un objecto especifico
    public function countTotal(); //devuelve la cantidad de los elementos del objeto
    public function countStatus($status); //devuelve la cantidad de los elementos con determinado status.
}

