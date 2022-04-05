<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 07.01.19
 * Time: 1:32.
 */

namespace App\Models\Traits\HasMedia;

interface HasMedia extends \Spatie\MediaLibrary\HasMedia\HasMedia
{
    public function getPerformOnImageCollections(): array;

    public function getMediaFieldsSingle(): array;

    public function getMediaFieldsMultiple(): array;

    public function setMediaFieldsSingle(array $mediaFieldsSingle);

    public function setMediaFieldsMultiple(array $mediaFieldsMultiple);

    /**
     * @return mixed
     */
    public function getMediaFieldsValidation(?string $field = null): array;

    /**
     * @return mixed
     */
    public function setMediaFieldsValidation(array $rules = []);

    /**
     * @return mixed
     */
    public function addMediaFieldsValidation(array $rules = []);
}
