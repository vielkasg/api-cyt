<?php

namespace App\Controllers;

use Core\CoreBaseController;

class Franjas extends CoreBaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\FranjasModel();
    }

    public function listaFranjas($page, $perPage)
    {
        return $this->getResponse($this->model->getAllFranjas($page, $perPage));
    }

    public function getCatalogoRutas()
    {
        return $this->getResponse($this->model->getCatalogoRutas());
    }
}
