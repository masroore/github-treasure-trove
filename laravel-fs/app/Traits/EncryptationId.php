<?php

namespace App\Traits;

use App\Helpers\Encryptor;

trait EncryptationId
{
    /**
     * Funcion que recupera el id del modelo y lo encripta.
     *
     * @param $value valor del id autonumerico
     *
     * @return string con el valor del id encriptado
     */
    public function getCryptIdAttribute()
    {
        return Encryptor::encrypt($this->attributes['id']);
    }
}
