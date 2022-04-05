<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaintable';

    protected $fillable = ['user_id', 'complaint_text', 'theme'];

    public function getThemeStr(): string
    {
        return self::complaintList()[$this->theme] ?? '';
    }

    public static function complaintList(): array
    {
        return [
            'insult' => 'Оскорбление',
            'child_porno' => 'Детская порнография',
            'drug' => 'Пропаганда наркотиков',
            'adult' => 'Материал для взрослых',
            'weapons' => 'Продажа оружия',
            'violence' => 'Насилие',
            'suicide' => 'Призыв к суициду',
            'fraud' => 'Мошенничество',
            'extremism' => 'Экстремизм',
            'other' => 'Другое',
        ];
    }

    public static function complaintUserList(): array
    {
        return [
            'robot' => 'Робот',
            'insult' => 'Оскорбление',
            'child_porno' => 'Детская порнография',
            'drug' => 'Пропаганда наркотиков',
            'adult' => 'Материал для взрослых',
            'weapons' => 'Продажа оружия',
            'violence' => 'Насилие',
            'suicide' => 'Призыв к суициду',
            'fraud' => 'Мошенничество',
            'extremism' => 'Экстремизм',
            'other' => 'Другое',
        ];
    }

    public function complaintable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
