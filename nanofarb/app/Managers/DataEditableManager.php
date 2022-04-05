<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 11.02.19
 * Time: 18:11.
 */

namespace App\Managers;

use Illuminate\Database\Eloquent\Model;

class DataEditableManager
{
    /**
     * @param string $fieldName Ex.: email, title, data[city], data[delivery][method],...
     * @param null|array|string $dataValue
     *
     * @return bool
     */
    public function save(Model $entity, string $fieldName, $dataValue = null)
    {
        if (preg_match('/^data\[\S+]$/i', $fieldName)) {
            $fieldName = trim(preg_replace('/]?\[/i', '->', $fieldName), ']');
            $entity->setAttribute($fieldName, $dataValue);
        } else {
            $entity->setAttribute($fieldName, $dataValue);
        }

        return $entity->save();
    }
}
