<?php
/**
 * User: Stuart C.
 * Date: 22/09/2016
 * Time: 12:22 PM
 */

namespace almacen\inc;


interface interfaceRequisicion extends interfaceAction
{
    public function newReqNum();
    public function createReq($req_num,$req_user,$dep_id,$req_fecha,$req_obs,$user_id);
    public function updateReq($req_num,$req_user,$dep_id,$req_fecha,$req_obs,$user_id,$req_status,$req_id);
    public function countReqEgr($req_id);
    public function updateKardexReqProd(); //actualiza kardex de productos en requisicion al ser modificada.
}