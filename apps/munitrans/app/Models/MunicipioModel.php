<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class MunicipioModel extends Model
{
    protected $table = 'sq_municipios';
    protected $databasePrefix = "municir5_";

    public function getDataMunicipioToConnection(int $codeMunicipio)
    {
        $municipioData = $this->asArray()->where(['cod' => $codeMunicipio])->first();
        if (!$municipioData) throw new Exception("No se encuentra informacion sobre este municipio");
        return [
            "codigo" => $codeMunicipio,
            "usuario" => $municipioData['usuario'],
            "clave" => base64_decode($municipioData['clave']),
            "cloudDB" => $this->databasePrefix . $municipioData['db'],
            "munidataDB" => $this->databasePrefix . $municipioData['dbmunicipia']
        ];
    }
}
