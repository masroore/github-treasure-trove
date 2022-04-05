<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 18.04.19
 * Time: 16:06.
 */

namespace App\Managers;

use Illuminate\Http\Request;

class MetaTagManager
{
    public function updateOrCreateForEntity($node, Request $request): void
    {
        $metaTag = $node->metaTag()->updateOrCreate([], $request->get('meta_tag'));

        $ogImgName = md5($metaTag->id);
        $fileObj = null;

        if ($request->og_image_deleted && file_exists(public_path($request->og_image_deleted))) {
            unlink(public_path($request->og_image_deleted));
            $metaTag->setAttribute('og_image', null);
            $metaTag->save();
        }

        if ($request->hasFile('og_image')) {
            $ogImgGenerator = new \App\Helpers\OgImageGenerator();

            $fileObj = $ogImgGenerator->saveUserFile($request->file('og_image'), $ogImgName);
        } elseif (empty($metaTag->og_image) && empty($request->og_image_deleted)) {
            $imgData = $node->generateMetaTagOgImgData();

            $fileObj = $this->generateOgImg($imgData, $ogImgName);
        }

        if ($fileObj) {
            $metaTag->setAttribute('og_image', 'storage/og/' . $fileObj->basename);
            $metaTag->save();
        }
    }

    protected function generateOgImg(array $imgData, $ogImgName)
    {
        $ogImgGenerator = new \App\Helpers\OgImageGenerator();

        if (isset($imgData['title'])) {
            $ogImgGenerator->setTitle($imgData['title']);
        }

        if (isset($imgData['subtitle'])) {
            $ogImgGenerator->setCategoryTitle($imgData['subtitle']);
        }

        if (isset($imgData['img']) && file_exists($imgData['img'])) {
            $ogImgGenerator->setLogoPath($imgData['img']);
        }

        return $ogImgGenerator->save($ogImgName);
    }

    public function saveOgImageForPath($metaTag, Request $request): void
    {
        $ogImgName = md5($metaTag->id);
        $fileObj = null;

        if ($request->og_image_deleted && file_exists(public_path($request->og_image_deleted))) {
            unlink(public_path($request->og_image_deleted));
            $metaTag->setAttribute('og_image', null);
            $metaTag->save();
        }

        if ($request->hasFile('og_image')) {
            $ogImgGenerator = new \App\Helpers\OgImageGenerator();

            $fileObj = $ogImgGenerator->saveUserFile($request->file('og_image'), $ogImgName);
        } elseif (empty($metaTag->og_image) && empty($request->og_image_deleted)) {
            $imgData = [
                'title' => $metaTag->title,
                'subtitle' => config('app.name'),
                'img' => '',
            ];

            $fileObj = $this->generateOgImg($imgData, $ogImgName);
        }

        if ($fileObj) {
            $metaTag->setAttribute('og_image', 'storage/og/' . $fileObj->basename);
            $metaTag->save();
        }
    }
}
