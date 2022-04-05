<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Libraries\CategorizedLayer;
use App\Libraries\MapsSchema;
use App\Map;
use App\MapFoto;
use App\PerangkatDaerah;
use App\Summary;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AnalisaController extends Controller
{
    private $maps_schema;

    public function __construct()
    {
        $this->maps_schema = new MapsSchema();
    }

    public function map_data(Request $request)
    {
        $map = Map::where('table_name', $request->table_name)->first();
        $map_own = Map::where('table_name', $request->table_name)->where('skpd_kode', Auth::user()->unit_id)->first();
        $tot_data = DB::select('SELECT count(*) as jum FROM maps.' . $request->table_name . '');
        $sumber_data = PerangkatDaerah::where('kode', $map->skpd_kode)->first();
        $is_exist_summary = 'no';
        $summary = Summary::where('table_name', $request->table_name)->orderBy('deskripsi_summary', 'asc')->get();
        $view_summary = '';

        $tot_luas = 0;
        if ($map->type !== 'Point') {
            if ($map->type == 'Polygon') {
                $luas = DB::select('SELECT SUM(ST_AREA(ST_AsText(geom))) AS jum from maps.' . $request->table_name . ' WHERE st_isvalid(geom) = TRUE ');
                $tot_luas = number_format($luas[0]->jum, 2, ',', '.');
            } else {
                $luas = DB::select('SELECT SUM(ST_LENGTH(ST_AsText(geom))) AS jum from maps.' . $request->table_name . ' WHERE st_isvalid(geom) = TRUE ');
                $tot_luas = number_format($luas[0]->jum, 2, ',', '.');
            }
        }

        if (count($summary) > 0) {
            $is_exist_summary = 'yes';
            $view_summary = (string) view('ajax.home.keterangan_summary', compact('summary', 'tot_luas', 'map'));
        }
        $is_allow = 'no';
        if (!empty($map_own)) {
            $is_allow = 'yes';
        }
        if (Auth::user()->user_level == 7) {
            $is_allow = 'yes';
        }
        if (Auth::user()->user_level == 4) {
            $is_allow = 'no';
        }
        $foto = MapFoto::where('map_id', $map->id)->where('attribut_id', $request->attr_id)->get();
        //$view = (String) view('ajax.home.show_foto',compact('foto'));
        return response()->json(['is_allow' => $is_allow, 'type' => $map->type, 'data' => $map, 'view_summary' => $view_summary, 'is_exist_summary' => $is_exist_summary], 200);
    }

    public function added_item(Request $request)
    {
        $map = DB::select("SELECT map.*, master_skpd.skpd_nama FROM map INNER JOIN master_skpd ON map.skpd_kode = master_skpd.kode WHERE map.table_name = '" . $request->table_name . "'");

        return response()->json(['map_data' => $map], 200);
    }

    public function modal_setting(Request $request)
    {
        $total_data = DB::select('SELECT COUNT(*) AS jum FROM maps.' . $request->table_name);
        foreach ($total_data as $t) {
            $total_data = $t;
        }
        $form_data = $this->maps_schema->AllColumnData($request->table_name);
        $view_attribut = (string) view('pages.analisa.ajax.option_query', compact('form_data'));
        $total_data = $total_data->jum;
        $map = DB::select("SELECT map.*, master_skpd.skpd_nama FROM map INNER JOIN master_skpd ON map.skpd_kode = master_skpd.kode WHERE map.table_name = '" . $request->table_name . "'");
        $map_type = $map[0]->type;
        $tot_luas = 0;
        if ($map_type !== 'Point') {
            if ($map_type == 'Polygon') {
                $luas = DB::select('SELECT SUM(ST_AREA(ST_AsText(geom))) AS jum from maps.' . $request->table_name . ' WHERE st_isvalid(geom) = TRUE ');
                $tot_luas = number_format($luas[0]->jum, 2, ',', '.');
            } else {
                $luas = DB::select('SELECT SUM(ST_LENGTH(ST_AsText(geom))) AS jum from maps.' . $request->table_name . ' WHERE st_isvalid(geom) = TRUE ');
                $tot_luas = number_format($luas[0]->jum, 2, ',', '.');
            }
        }
        $view = (string) view('pages.analisa.ajax.tentang', compact('total_data', 'map', 'tot_luas'))->render();

        return response()->json(['html' => $view, 'attribut' => $view_attribut, 'map_data' => $map, 'attr_data' => $form_data], 200);
    }

    public function label_styling(Request $request)
    {
        $form_data = $this->maps_schema->AllColumnData($request->map_name);
        $view_attribut = (string) view('pages.analisa.ajax.label_styling', compact('form_data'));

        return response()->json(['view' => $view_attribut], 200);
    }

    public function query(Request $request)
    {
        $type_attr = $this->maps_schema->getColumnType($request->attribut_query, $request->table_name);
        $status = 'success';
        if ($request->hitungan !== 'count_all' && !in_array($type_attr, $this->array_num_type)) {
            $status = 'failed';
            $res_query = 'failed';
        } else {
            $res_query = $this->maps_schema->clientQuery($request->hitungan, $request->attribut_query, $request->table_name, $request->group_kecamatan, $request->filter_query_is_aktif, $request->operator_filter_query, $request->attribut_filter_query, $request->value_filter_query);
            $res_fix = number_format($res_query['res'], 2, ',', '.');
        }
        session(['data_query' => $res_query['query']]);

        return response()->json(['res' => $res_fix, 'status' => $status, 'kecamatan' => $request->group_kecamatan]);
    }

    public function buffer(Request $request)
    {
        $res = DB::select('SELECT ST_X(ST_TRANSFORM(geom,900913)) AS long,ST_Y(ST_TRANSFORM(geom,900913)) AS lat FROM maps.' . $request->map_name);

        return response()->json(['res' => $res]);
    }

    public function all_data(Request $request)
    {
        $column = $this->maps_schema->AllColumnData($request->table_name);
        $table_name = $request->table_name;
        $html = (string) view('pages.analisa.ajax.all_data', compact('column', 'table_name'));

        return response()->json(['html' => $html]);
    }

    public function cbo_categorized(Request $request)
    {
        $form_data = $this->maps_schema->AllColumnData($request->table_name);
        $map_name = $request->map_name;
        $view_table = (string) view('pages.analisa.ajax.cbo_categorized', compact('form_data'));
        $view_label = (string) view('pages.analisa.ajax.cbo_categorized_label', compact('form_data'));

        return response()->json(['view' => $view_table, 'view_label' => $view_label], 200);
    }

    public function categorized_layer(Request $request)
    {
        $map = Map::where('table_name', $request->map_name)->first();
        $shape = $map->type;
        $kolom_name = $request->kolom;
        $kolom = DB::select('SELECT DISTINCT ' . $request->kolom . ' AS kolom FROM maps.' . $request->map_name . ' ORDER BY ' . $request->kolom . ' ASC');
        $jumlah_data = count($kolom);
        $color_style = [];
        for ($i = 0; $i < $jumlah_data; ++$i) {
            $color = $this->random_color();

            if (in_array($color, $color_style)) {
                --$i;
            } else {
                $color_style[] = $color;
            }
        }
        $luas = 'none';
        if ($request->is_tampil_luas == 'yes' && $map->type == 'Polygon') {
            $luas = DB::select('SELECT SUM(ST_AREA(ST_AsText(geom))) AS jum from maps.' . $request->map_name . ' WHERE st_isvalid(geom) = TRUE GROUP BY ' . $request->kolom . ' ORDER BY ' . $request->kolom . ' ASC');
        }
        $view = (string) view('pages.analisa.ajax.res_categorized', compact('color_style', 'kolom', 'shape', 'luas'))->render();
        $sld = new CategorizedLayer();
        $sld_file = $sld->create($map->table_name, $kolom, $jumlah_data, $shape, $color_style, $kolom_name, $request->attr_label);
        $client = new Client([
            'base_uri' => 'https://bappeko.surabaya.go.id/geoserver/rest/',
            'auth' => ['admin', 'Bappek0Pr1m3'],
        ]);
        $body = (object) [
            'style' => [
                'name' => $sld_file['name'],
                'filename' => $sld_file['file'],
            ],
        ];
        $client->post(
            'styles',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($body)),
                ],
                'body' => json_encode($body),
            ]
        );
        $body_style = (object) [
            'layer' => [
                'defaultStyle' => ['name' => $sld_file['name']],
            ],
        ];
        $cmd = 'curl -v -u admin:Bappek0Pr1m3 -XPUT -H "Content-type: application/vnd.ogc.sld+xml" -d @' . $sld_file['file'] . ' http://localhost:8080/geoserver/rest/styles/' . $sld_file['name'];
        exec($cmd);
        $client->put(
            'layers/bappeko:' . $request->map_name . '.json',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($body_style)),
                ],
                'body' => json_encode($body_style),
            ]
        );
        $map = Map::where('table_name', $request->map_name)->update([
            'is_default' => 'not',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['view' => $view, 'sld' => $sld_file['name']], 200);
    }

    public function datatables_all_data($table_name, Request $request)
    {
        $column = $this->maps_schema->AllColumnData($table_name);
        $map = DB::select('SELECT * FROM maps.' . $table_name);

        return Datatables::of($map)
            ->editColumn('gid', function ($m) {
                return '<button class="btn btn-outline-info" onClick="centerOn(' . $m->gid . ',19)">' . $m->gid . ' </button>';
            })
            ->removeColumn('geom')
            ->rawColumns(['gid'])
            ->make(true);
    }

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}
