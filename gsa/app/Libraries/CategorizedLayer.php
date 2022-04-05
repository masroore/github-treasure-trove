<?php

namespace App\Libraries;

use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategorizedLayer
{
    private $map_name;

    private $sld_path;

    private $workspace;

    public function __construct()
    {
        $this->sld_path = 'public/sld/';
        $this->workspace = urlencode(env('GEOSERVER_WORKSPACE'));
    }

    public function create($map_name, $data, $jumlah_data, $type, $color, $column_name, $label_show)
    {
        $this->map_name = $map_name;
        //STYLE RULE
        $rule = '';
        switch ($type) {
            case 'Point':
                $rule .= '<FeatureTypeStyle>';
                $shape = 'circle';
                $size = 12;
                for ($i = 0; $i < $jumlah_data; ++$i) {
                    $rule .= $this->createPointSymbolizer($shape, $color[$i], $size, $data[$i]->kolom, $column_name);
                }
                if ($label_show !== null) {
                    $rule .= '<Rule>';
                    $rule .= $this->createTextSymbolizer($label_show, 12, '#ecf0f1', 0, 5, true);
                    $rule .= '</Rule>';
                }
                $rule .= '</FeatureTypeStyle>';

                break;
            case 'LineString':
                $width = 2.5;
                for ($i = 0; $i < $jumlah_data; ++$i) {
                    $rule .= $this->createLineSymbolizer($color[$i], $width, $data[$i]->kolom, $column_name);
                }

                if ($label_show !== null) {
                    $rule .= '<Rule>';
                    $rule .= $this->createTextSymbolizer($label_show, 12, '#ecf0f1', 1, 1, false);
                    $rule .= '</Rule>';
                }

                break;
            case 'Polygon':
                $opacity = 0.5;
                $width = 1.5;
                $rule .= '<FeatureTypeStyle>';
                for ($i = 0; $i < $jumlah_data; ++$i) {
                    $kolom_fix = str_replace('&', 'dan', $data[$i]->kolom);
                    $rule .= $this->createPolygonSymbolizer($color[$i], $opacity, '#000000', $width, $kolom_fix, $column_name);
                }

                if ($label_show !== null) {
                    $rule .= '<Rule>';
                    $rule .= $this->createTextSymbolizer($label_show, 12, '#ecf0f1', 1, 1, true);
                    $rule .= '</Rule>';
                }
                $rule .= '</FeatureTypeStyle>';

                break;
        }

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
    private function createPointSymbolizer($shape, $color, $size, $kolom, $column_name)
    {
        $point = '';
        $point .= '<Rule>';
        $point .= '<Name>' . $kolom . '</Name>';

        $point .= '<ogc:Filter>';
        if ($kolom == null || $kolom == '') {
            $point .= '<ogc:PropertyIsNull>';
            $point .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $point .= '</ogc:PropertyIsNull>';
        } else {
            $point .= '<ogc:PropertyIsEqualTo>';
            $point .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $point .= '<ogc:Literal>' . $kolom . '</ogc:Literal>';
            $point .= '</ogc:PropertyIsEqualTo>';
        }
        $point .= '</ogc:Filter>';

        $point .= '<PointSymbolizer><Graphic>';
        $point .= '<Mark>';
        $point .= '<WellKnownName>' . $shape . '</WellKnownName>';

        $point .= '<Fill>';
        $point .= '<CssParameter name="fill">#' . $color . '</CssParameter>';
        $point .= '</Fill>';

        $point .= '</Mark>';
        $point .= '<Size>' . $size . '</Size>';
        $point .= '</Graphic></PointSymbolizer>';

        $point .= '</Rule>';

        return $point;
    }

    //LINE SYMBOLIZER
    public function createLineSymbolizer($color, $width, $kolom, $column_name)
    {
        $line = '<FeatureTypeStyle>';
        $line .= '<Rule>';
        $line .= '<Name>' . $kolom . ' </Name>';

        $line .= '<ogc:Filter>';
        if ($kolom == null || $kolom == '') {
            $line .= '<ogc:PropertyIsNull>';
            $line .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $line .= '</ogc:PropertyIsNull>';
        } else {
            $line .= '<ogc:PropertyIsEqualTo>';
            $line .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $line .= '<ogc:Literal>' . $kolom . '</ogc:Literal>';
            $line .= '</ogc:PropertyIsEqualTo>';
        }
        $line .= '</ogc:Filter>';

        $line .= '<LineSymbolizer>';
        $line .= '<Stroke>';
        $line .= '<CssParameter name="stroke">#' . $color . '</CssParameter>';
        $line .= '<CssParameter name="stroke-width">' . $width . '</CssParameter>';
        $line .= '</Stroke>';

        $line .= '</LineSymbolizer>';
        $line .= '</Rule>';
        $line .= '</FeatureTypeStyle>';

        return $line;
    }

    //POLYGON SYMBOLIZER
    public function createPolygonSymbolizer($fcolor, $opacity, $scolor, $width, $kolom, $column_name)
    {
        $polygon = '<Rule>';
        $polygon .= '<Name>' . $kolom . ' </Name>';

        $polygon .= '<ogc:Filter>';
        if ($kolom == null || $kolom == '') {
            $polygon .= '<ogc:PropertyIsNull>';
            $polygon .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $polygon .= '</ogc:PropertyIsNull>';
        } else {
            $polygon .= '<ogc:PropertyIsEqualTo>';
            $polygon .= '<ogc:PropertyName>' . $column_name . '</ogc:PropertyName>';
            $polygon .= '<ogc:Literal>' . $kolom . '</ogc:Literal>';
            $polygon .= '</ogc:PropertyIsEqualTo>';
        }
        $polygon .= '</ogc:Filter>';

        $polygon .= '<PolygonSymbolizer>';
        $polygon .= '<Fill>';
        $polygon .= '<CssParameter name="fill">#' . $fcolor . '</CssParameter>';
        $polygon .= '<CssParameter name="fill-opacity">' . $opacity . '</CssParameter>';
        $polygon .= '</Fill>';

        $polygon .= '<Stroke>';
        $polygon .= '<CssParameter name="stroke">' . $scolor . '</CssParameter>';
        $polygon .= '<CssParameter name="stroke-width">' . $width . '</CssParameter>';
        $polygon .= '</Stroke>';

        $polygon .= '</PolygonSymbolizer>';
        $polygon .= '</Rule>';

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
            $text .= '<AnchorPointY>0.5</AnchorPointY>';
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
