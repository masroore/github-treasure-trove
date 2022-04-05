<?php

namespace App\Models\Traits;

use App\Http\Resources\Control\LanguageResource;
use Illuminate\Support\Str;

trait HasTranslation
{
    use HasLang;

    protected static function bootHasTranslation(): void
    {
        static::created(function ($model): void {
            if (empty($model->translation_uuid)) {
                $model->translation_uuid = Str::uuid();
                $model->save();
            }
        });
    }

    public function translations()
    {
        return $this->hasMany(static::class, 'translation_uuid', 'translation_uuid')
            //->where('id', '<>', $this->id)
;
    }

    public function getTranslationsList()
    {
        $languages = get_languages();
        $res = [];
        $hasCurrent = false;

        foreach ($languages as $lang) {
            $model = $this->translations->where('lang', $lang->lang)->first();
            $status = $this->getTranslationStatus($lang->lang, $model);

            $res[] = [
                'type' => Str::snake(class_basename(static::class)),
                'status' => $status,
                'model' => [
                    'id' => optional($model)->id,
                    'lang' => $lang->lang,
                    //'translation_uuid' => optional($model)->translation_uuid,
                ],
                'language' => new LanguageResource($lang),
                //'name' => $lang->name,
            ];
            if ($status === 'current') {
                $hasCurrent = true;
            }
        }

        if ($hasCurrent === false && isset($res[0]['status'])) {
            $res[0]['status'] = 'current';
        }

        return $res;
    }

    protected function getTranslationStatus(string $langcode, $model = null): string
    {
        if (empty($model)) {
            return 'empty';
        }

        if ($this->lang === $langcode) {
            return 'current';
        }

        return 'translation';
    }
}
