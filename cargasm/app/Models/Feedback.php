<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Feedback extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'feedbacks';

    protected $guarded = ['id'];

    public const FEEDBACK_NEW = 'new';
    public const FEEDBACK_PROCESSING = 'processing';
    public const FEEDBACK_CLOSE = 'close';
}
