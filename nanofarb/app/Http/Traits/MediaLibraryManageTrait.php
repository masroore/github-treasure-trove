<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 07.01.19
 * Time: 1:03.
 */

namespace App\Http\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\Models\Media;
use Validator;

trait MediaLibraryManageTrait
{
    protected function manageMedia(Model $entity, Request $request)
    {
        if (!method_exists($entity, 'getMediaFieldsMultiple') && !method_exists($entity, 'getMediaFieldsSingle')) {
            throw new Exception("Method 'getMediaFieldsMultiple' or 'getMediaFieldsSingle' not found in model class " . class_basename($entity));
        }

        // Multiple fields
        foreach ($entity->getMediaFieldsMultiple() as $field) {

            //$request->validate($entity->getMediaFieldsValidation($field));
            $validator = Validator::make($request->only($field), $entity->getMediaFieldsValidation($field));

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile($field)) {
                //$entity->addMultipleMediaFromRequest([$field])->each(function ($fileAdder) use ($field) {
                //    $fileAdder->toMediaCollection($field);
                //});
                foreach ($request->file($field) as $file) {
                    $this->addMedia($entity, $file, $field);
                }
            }

            if (($weight = $request->get($field . '_weight')) && is_array($weight)) {
                foreach ($weight as $key => $value) {
                    $entity->media()->where('id', $key)->update(['order_column' => $value]);
                }
            }

            if (($ids = $request->get($field . '_deleted')) && is_array($ids)) {
                array_map(function ($id) use ($entity): void {
                    $id ? $entity->deleteMedia($id) : null;
                }, $ids);
            }
            //$entity->media()->whereIn('id', $ids)->delete();
        }

        // Single field
        foreach ($entity->getMediaFieldsSingle() as $field) {

            //$request->validate($entity->getMediaFieldsValidation($field));
            $validator = Validator::make($request->only($field), $entity->getMediaFieldsValidation($field));

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile($field)) {
                $entity->getMedia($field)->each(function ($e): void {
                    $e->delete();
                });

                $this->addMedia($entity, $request->file($field), $field);
            }

            if ($id = $request->get($field . '_deleted')) {
                $entity->deleteMedia($id);
            }
        }
    }

    protected function addMedia(Model $entity, UploadedFile $uploadedFile, string $collectionName): Media
    {
        $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = $uploadedFile->getClientOriginalExtension();

        // TODO: str_slug!
        $fileName = str_slug($originalName, '_') . '.' . $originalExtension;
        $sanitizeFileName = sanitize_file_name($fileName);

        return $entity->addMedia($uploadedFile)
            ->usingFileName($sanitizeFileName)
            //->usingName($sanitizeFileName) // Use for Title && Alt
            ->toMediaCollection($collectionName);
    }
}
