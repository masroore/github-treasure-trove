<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OfferPopup extends Model
{
    use HasTranslations;

    public $translatable = ['heading', 'subheading', 'description', 'button_text'];

    protected $fillable = [
        'enable_popup',
        'image',
        'heading',
        'heading_color',
        'subheading',
        'subheading_color',
        'description',
        'description_text_color',
        'enable_button',
        'button_text',
        'button_text_color',
        'button_link',
        'button_color',
    ];
}
