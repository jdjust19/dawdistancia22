<?php
require_once './src/Peticion.php';
require_once './src/Activo.php';
require_once 'Smarty.class.php'; // Esta línea no debe ponerse en conf.php
/**
* @author Juan Diego Justicia del Moral jjusmor@gmail.com
* @version 1.0
* 
*/

/**
* Esta función nos muestra la pantalla de añadir activos
* a traves de una plantilla y tambien se encarga de realizar el almacenamiento
* @param Peticion $peticion
* @param Smarty $smarty
* @param PDO $db
* @return float
*/
function controladorAddActivo(Peticion $peticion, Smarty $smarty,PDO $db){
    $values=array();
    $errores=array();
    $result=-2;
    try {
        $values['nombre'] = $peticion->getString('nombre');
        $values['descripcion'] = $peticion->getString('descripcion');
        $values['empresamnt'] = $peticion->getString('empresamnt');
        $values['personamnt'] = $peticion->getString('personamnt');
        $values['telefonomnt'] = $peticion->getString('telefonomnt');
        $activo = new Activo(null, $values['nombre'],$values['descripcion'],$values['empresamnt'],$values['personamnt'],$values['telefonomnt']);
        $errores=$activo->checkCoherente();   
        if(count($errores)===0){
            $result = $activo->guardar($db);
        }
    $smarty->assign('activo',$activo);

    } catch (Exception $th) {}
    $smarty->assign('values',$values);
    $smarty->assign('result',$result);
    $smarty->assign('errores',$errores);

    $smarty->assign('ROOTPATH',ROOTPATH);
    $smarty->display('addactivo.tpl');

}

/**
* Esta función nos lista el número de activos
* @param Peticion $peticion
* @param Smarty $smarty
* @param PDO $db
*/
function controladorListarActivos(Peticion $peticion, Smarty $smarty, PDO $db){
    $activos = Activo::getAllActivos($db);
    $smarty->assign('ROOTPATH',ROOTPATH);
    $smarty->assign('activos',$activos);
    $smarty->display('listaractivos.tpl');
}

