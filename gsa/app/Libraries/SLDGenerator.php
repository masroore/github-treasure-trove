<?php

namespace App\Libraries;

use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SLDGenerator
{
    private $map_name;

    private $sld_path;

    private $workspace;

    public function __construct()
    {
        $this->sld_path = 'public/sld/';
        $this->workspace = urlencode(env('GEOSERVER_WORKSPACE'));
    }

    public function create($options)
    {
        $this->map_name = $options['map_name'];
        //STYLE RULE
        $rule = '<FeatureTypeStyle>';
        $rule .= '<Rule>';
        $rule .= '<Title> ' . $this->map_name . ' </Title>';

        switch ($options['map_type']) {
            case 'Point':
                $shape = $options['point_shape'];
                $color = $options['color_start'];
                $size = $options['size_start'];

                $rule .= $this->createPointSymbolizer($shape, $color, $size);

                break;
            case 'LineString':
                $color = $options['color_start'];
                $width = $options['stroke_width'];

                $rule .= $this->createLineSymbolizer($color, $width);

                break;
            case 'Polygon':
                $fcolor = $options['color_start'];
                $opacity = $options['opacity'];
                $scolor = $options['stroke_color'];
                $width = $options['stroke_width'];

                $rule .= $this->createPolygonSymbolizer($fcolor, $opacity, $scolor, $width);

                break;
        }

        if ($options['useText'] == 'true') {
            $attr = $options['label_attribute'];
            $size = $options['label_size'];
            $color = $options['label_color'];
            $offsetX = $options['label_offsetX'];
            $offsetY = $options['label_offsetY'];
            $PointPlacement = true;

            $rule .= $this->createTextSymbolizer($attr, $size, $color, $offsetX, $offsetY, $PointPlacement);
        }

        $rule .= '</Rule>';
        $rule .= '</FeatureTypeStyle>';

        //CREATING SLD FILE
        $sld = '<?xml version="1.0" encoding="ISO-8859-1"?>';
        $sld .= '<StyledLayerDescriptor version="1.0.0" ';
        $sld .= 'xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd" ';
        $sld .= 'xmlns="http://www.opengis.net/sld" ';
        $sld .= 'xmlns:ogc="http://www.opengis.net/ogc" ';
        $sld .= 'xmlns:xlink="http://www.w3.org/1999/xlink" ';
        $sld .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
        $sld .= '<NamedLayer>';
        $sld .= '<Name>' . $this->workspace . ':' . $this->map_name . '</Name>';
        $sld .= '<UserStyle>';
        $sld .= '<Title>' . $this->map_name . '</Title>';
        $sld .= $rule;
        $sld .= '</UserStyle>';
        $sld .= '</NamedLayer>';
        $sld .= '</StyledLayerDescriptor>';
        $sld_name = $this->map_name . uniqid();
        $file_name = $sld_name . '.sld';
        Storage::put($this->sld_path . $file_name, $sld);
        //return $sld_name;
        $array = ['name' => $sld_name, 'file' => storage_path('app') . '/' . $this->sld_path . $file_name];

        return $array;
    }

    //GET ATTRIBUTE LIST
    private function getAttributeList()
    {
        $attributes = DB::table('information_schema.columns')
            ->select('column_name', 'data_type')
            ->where('table_name', $this->map_name)
            ->get();

        $data = [];
        foreach ($attributes as $attribute) {
            if ($attribute->column_name !== 'gid' && $attribute->column_name !== 'geom') {
                $data['attributes'][] = [
                    'name' => $attribute->column_name,
                    'type' => $attribute->data_type,
                ];
            }
        }

        return $data;
    }

    //POINT SYMBOLIZER
    private function createPointSymbolizer($shape, $color, $size)
    {
        $point = '<PointSymbolizer><Graphic>';
        $point .= '<Mark>';
        $point .= '<WellKnownName>' . $shape . '</WellKnownName>';
        if ($size != 0) {
            $point .= '<Fill>';
            $point .= '<CssParameter name="fill">' . $color . '</CssParameter>';
            $point .= '</Fill>';
        }
        $point .= '</Mark>';
        $point .= '<Size>' . $size . '</Size>';
        $point .= '</Graphic></PointSymbolizer>';

        return $point;
    }

    //LINE SYMBOLIZER
    public function createLineSymbolizer($color, $width)
    {
        $line = '<LineSymbolizer>';
        if ($width != 0) {
            $line .= '<Stroke>';
            $line .= '<CssParameter name="stroke">' . $color . '</CssParameter>';
            $line .= '<CssParameter name="stroke-width">' . $width . '</CssParameter>';
            $line .= '</Stroke>';
        }
        $line .= '</LineSymbolizer>';

        return $line;
    }

    //POLYGON SYMBOLIZER
    public function createPolygonSymbolizer($fcolor, $opacity, $scolor, $width)
    {
        $polygon = '<PolygonSymbolizer>';
        $polygon .= '<Fill>';
        $polygon .= '<CssParameter name="fill">' . $fcolor . '</CssParameter>';
        $polygon .= '<CssParameter name="fill-opacity">' . $opacity . '</CssParameter>';
        $polygon .= '</Fill>';
        if ($width != 0) {
            $polygon .= '<Stroke>';
            $polygon .= '<CssParameter name="stroke">' . $scolor . '</CssParameter>';
            $polygon .= '<CssParameter name="stroke-width">' . $width . '</CssParameter>';
            $polygon .= '</Stroke>';
        }
        $polygon .= '</PolygonSymbolizer>';

        return $polygon;
    }

    //TEXT SYMBOLIZER
    public function createTextSymbolizer($attr, $size, $color, $offsetX, $offsetY, $PointPlacement = true)
    {
        $text = '<TextSymbolizer>';

        $data = $this->getAttributeList();
        $data_type = 'text';
        foreach ($data['attributes'] as $attribute) {
            if ($attribute['name'] == $attr) {
                $data_type = $attribute['type'];
            }
        }

        $arr_numTypes = ['decimal', 'numeric', 'real', 'double precision'];

        if (in_array($data_type, $arr_numTypes)) {
            $text .= '<Label>';
            $text .= '<ogc:Div>';
            $text .= '<ogc:Mul>';
            $text .= '<ogc:PropertyName>' . $attr . '</ogc:PropertyName>';
            $text .= '<ogc:Literal>100</ogc:Literal>';
            $text .= '</ogc:Mul>';
            $text .= '<ogc:Literal>100</ogc:Literal>';
            $text .= '</ogc:Div>';
            $text .= '</Label>';
        } else {
            $text .= '<Label><ogc:PropertyName>' . $attr . '</ogc:PropertyName></Label>';
        }

        $text .= '<Font>';
        $text .= '<CssParameter name="font-family">URW Gothic L Demi</CssParameter>';
        $text .= '<CssParameter name="font-size">' . $size . '</CssParameter>';
        $text .= '<CssParameter name="font-style">normal</CssParameter>';
        $text .= '<CssParameter name="font-weight">bold</CssParameter>';
        $text .= '</Font>';
        $text .= '<LabelPlacement>';

        if ($PointPlacement == true) {
            $text .= '<PointPlacement>';
            $text .= '<AnchorPoint>';
            $text .= '<AnchorPointX>0.5</AnchorPointX>';
            $text .= '<AnchorPointY>0</AnchorPointY>';
            $text .= '</AnchorPoint>';
            $text .= '<Displacement>';
            $text .= '<DisplacementX>' . $offsetX . '</DisplacementX>';
            $text .= '<DisplacementY>' . $offsetY . '</DisplacementY>';
            $text .= '</Displacement>';
            $text .= '</PointPlacement>';
        } else {
            $text .= '<LinePlacement>';
            $text .= '<PerpendicularOffset>' . $offsetY . '</PerpendicularOffset>';
            $text .= '</LinePlacement>';
        }

        $text .= '</LabelPlacement>';
        $text .= '<Fill><CssParameter name="fill">' . $color . '</CssParameter></Fill>';
        $text .= '<VendorOption name="autoWrap">60</VendorOption>';
        $text .= '<VendorOption name="maxDisplacement">150</VendorOption>';
        $text .= '</TextSymbolizer>';

        return $text;
    }
}
