<?php

class IndexController {

    public function Index() {

        if (Session::loggedIndex()) {
            $i= substr(Session::get('roles_id'),-1,1); 

            $array_pages= array('?c=reportes&a=pulso','?c=recepcion','?c=reportes','?c=informes&a=calibrar','?c=informes', (Session::get('plantas_id')=='126') ? '?c=clienteinformes&a=continental' : '?c=clienteinformes' ,'?c=recepcion', '?c=informes');
            redirect($array_pages[$i]);
        } else {
            include view('login.index');
            exit;
        }
    }

}