<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 08.11.18
 * Time: 16:05.
 */

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class OgImageGenerator
{
    const RATE = 2;

    protected $background = '#ffffff'; //'#008764';

    protected $fontColor = '#6A6A6A'; //'#ffffff';

    protected $fontSizeTitle = 32;

    protected $fontSizeCategory = 36;

    protected $width = 600;

    protected $height = 315;

    protected $title = '';

    protected $categoryTitle = '';

    protected $logoPath;

    protected $titleFont;

    protected $titleCategoryFont;

    protected $quality = 80;

    protected $path;

    /**
     * OgImageGenerator constructor.
     */
    public function __construct()
    {
        $this->logoPath = public_path('its-client/img/logo-big.png');
        $this->titleFont = public_path('its-client/fonts/Roboto-Regular.ttf');
        $this->titleCategoryFont = public_path('its-client/fonts/Roboto-Medium.ttf');
        $this->path = storage_path('app/public/og');
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function setBackground(string $background)
    {
        $this->background = $background;

        return $this;
    }

    public function setCategoryTitle(string $categoryTitle)
    {
        $this->categoryTitle = $categoryTitle;

        return $this;
    }

    public function setLogoPath(string $logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function save(string $name)
    {
        $img = Image::canvas($this->width * static::RATE, $this->height * static::RATE, $this->background);

        $img = $this->generateTitle($img);

        $img = $this->generateCategoryTitle($img);

        $watermark = Image::make($this->logoPath)->resize(145 * static::RATE, 40 * static::RATE); // width, height
        $img->insert($watermark, 'bottom-right', 40 * static::RATE, 50 * static::RATE); // left, top

        return $img->save($this->checkMakeDir($this->path) . "/$name.jpg", $this->quality);
    }

    protected function checkMakeDir(string $path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    /**
     * @param $img
     *
     * @return mixed
     */
    protected function generateCategoryTitle($img)
    {
        return $img->text(mb_strtoupper($this->categoryTitle), 40 * static::RATE, 270 * static::RATE, function ($font): void {
            $font->size(28 * static::RATE);
            $font->file($this->titleFont);
            $font->color($this->fontColor);
            $font->align('left');
            $font->valign('bottom');
        });
    }

    protected function generateTitle($img)
    {
        $maxLen = 42;
        $fontHeight = 20 * static::RATE;

        $lines = explode("\n", wordwrap(str_limit($this->title, 120, ''), $maxLen));

        $x = 30 * static::RATE;
        $y = 30 * static::RATE;

        foreach ($lines as $line) {
            $img->text($line, $x, $y, function ($font): void {
                $font->size($this->fontSizeTitle * static::RATE);
                $font->file($this->titleCategoryFont);
                $font->color($this->fontColor);
                $font->align('left');
                $font->valign('top');
            });
            $y += $fontHeight * 2;
        }

        return $img;
    }

    public function saveUserFile($file, string $name)
    {
        $img = Image::make($file)->resize($this->width * static::RATE, $this->height * static::RATE);

        return $img->save($this->checkMakeDir($this->path) . "/$name.jpg", $this->quality);
    }
}
