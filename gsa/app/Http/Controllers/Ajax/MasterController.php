<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Libraries\MapsSchema;
use App\Map;
use App\PerangkatDaerah;
use App\Summary;
use App\TagsMap;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterController extends Controller
{
    public function delete(Request $request): void
    {
        $client = new Client([
            'base_uri' => 'https://bappeko.surabaya.go.id/geoserver/rest/',
            'auth' => ['admin', 'Bappek0Pr1m3'],
            'synchronous' => true,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'debug' => true,
        ]);

        $id = $request->id;
        $map_name = $request->map_name;
        Schema::dropIfExists('maps.' . $map_name);
        $result = Map::destroy($id);

        $layerName = urlencode($map_name);
        $client->delete('layers/' . $layerName);
        $client->delete('workspaces/bappeko/datastores/bappeko_2019/featuretypes/' . $layerName);
    }

    public function tag(Request $request)
    {
        $map = Map::find($request->id);
        $skpd = PerangkatDaerah::where('kode', $map->skpd_kode)->pluck('skpd_nama');
        $tagged_pd = DB::select('SELECT m.*, t.id as tag_id FROM master_skpd m INNER JOIN tags_map t ON m.kode = t.skpd_id WHERE t.map_id = ' . $request->id . ' ');
        $view_table_tagged = (string) view('pages.master_peta.ajax.tagged_pd', compact('tagged_pd'));
        $tagged_pd_cbo = [];
        $i = 0;
        foreach ($tagged_pd as $t) {
            $tagged_pd_cbo[] = $t->kode;
            ++$i;
        }
        $tagged_pd_cbo[] = $map->skpd_kode;
        $skpd_non_tag = PerangkatDaerah::whereNotIn('kode', $tagged_pd_cbo)->get();
        $view_cbo_tagged = (string) view('pages.master_peta.ajax.cbo_tagged', compact('skpd_non_tag'));

        return response()->json(['skpd' => $skpd, 'view_table_tagged' => $view_table_tagged, 'view_cbo_tagged' => $view_cbo_tagged, 'id' => $request->id], 200);
    }

    public function save_tag(Request $request)
    {
        $tags = TagsMap::create([
            'map_id' => $request->map_tag,
            'skpd_id' => $request->pd,
        ]);

        return redirect('/master')->with('message', 'updated_tag');
    }

    public function delete_tag(Request $request): void
    {
        $tags = TagsMap::find($request->id)->delete();
    }

    public function update_attr(Request $request)
    {
        $sql = 'ALTER TABLE maps.' . $request->map_name . '
                RENAME COLUMN ' . $request->prev_column_name . ' TO ' . $request->next_column_name;
        if (!DB::statement($sql)) {
            return 'gagal execute query';
        }
        $client = new Client([
            'base_uri' => 'https://bappeko.surabaya.go.id/geoserver/rest/',
            'auth' => ['admin', 'Bappek0Pr1m3'],
            'synchronous' => true,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'debug' => true,
        ]);
        $query_find_srid = DB::select("SELECT Find_SRID('maps', '" . $request->map_name . "', 'geom');");
        $map_srid = $query_find_srid[0]->find_srid;

        $description = '';
        $body = (object) [
            'featureType' => [
                'name' => $request->map_name,
                'nativeName' => $request->map_name,
                'title' => $request->map_name,
                'description' => htmlentities($description, ENT_COMPAT),
                'nativeCRS' => 'EPSG:' . $map_srid,
                'srs' => 'EPSG:' . $map_srid,
                'projectionPolicy' => 'REPROJECT_TO_DECLARED',
                'enabled' => true,
                'circularArcPresent' => true,
            ],
        ];

        $layerName = urlencode($request->map_name);
        $client->delete('layers/' . $layerName);
        $client->delete('workspaces/bappeko/datastores/bappeko_2019/featuretypes/' . $layerName);

        $client->post(
            'workspaces/bappeko/datastores/bappeko_2019/featuretypes.json',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($body)),
                ],
                'body' => json_encode($body),
            ]
        );
    }

    public function delete_attr(Request $request)
    {
        $sql = 'ALTER TABLE maps.' . $request->map_name;
        $sql .= ' DROP COLUMN ' . $request->column_name;
        if (!DB::statement($sql)) {
            return 'gagal execute query';
        }
        $client = new Client([
            'base_uri' => 'https://bappeko.surabaya.go.id/geoserver/rest/',
            'auth' => ['admin', 'Bappek0Pr1m3'],
            'synchronous' => true,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'debug' => true,
        ]);
        $query_find_srid = DB::select("SELECT Find_SRID('maps', '" . $request->map_name . "', 'geom');");
        $map_srid = $query_find_srid[0]->find_srid;

        $description = '';
        $body = (object) [
            'featureType' => [
                'name' => $request->map_name,
                'nativeName' => $request->map_name,
                'title' => $request->map_name,
                'description' => htmlentities($description, ENT_COMPAT),
                'nativeCRS' => 'EPSG:' . $map_srid,
                'srs' => 'EPSG:' . $map_srid,
                'projectionPolicy' => 'REPROJECT_TO_DECLARED',
                'enabled' => true,
                'circularArcPresent' => true,
            ],
        ];

        $layerName = urlencode($request->map_name);
        $client->delete('layers/' . $layerName);
        $client->delete('workspaces/bappeko/datastores/bappeko_2019/featuretypes/' . $layerName);

        $client->post(
            'workspaces/bappeko/datastores/bappeko_2019/featuretypes.json',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($body)),
                ],
                'body' => json_encode($body),
            ]
        );
    }

    public function summary_save(Request $request): void
    {
        dd($request->all());
    }

    public function edit_peta(Request $request)
    {
        $map = Map::find($request->id);
        $query_projeksi = collect(DB::select("SELECT Find_SRID('maps', '" . $map->table_name . "', 'geom')"))->first();
        $projeksi = $query_projeksi->find_srid;

        return response()->json(['map' => $map, 'projeksi' => $projeksi], 200);
    }

    public function kelola(Request $request)
    {
        $maps_schema = new MapsSchema();
        $form_data = $maps_schema->AllColumnData($request->map_name);
        $map_name = $request->map_name;
        $view_table = (string) view('pages.master_peta.ajax.kelola', compact('form_data', 'map_name'));
        $summary = Summary::where('table_name', $request->map_name)->get();
        $view_summary = '';
        $is_summary_exists = 'yes';
        $view_summary = (string) view('pages.master_peta.ajax.keterangan_summary', compact('summary', 'map_name'));
        $view_attribut_query = (string) view('pages.master_peta.ajax.attribut_query', compact('form_data', 'map_name'));
        $view_attribut_query_edit = (string) view('pages.master_peta.ajax.attribut_query_edit', compact('form_data', 'map_name'));

        return response()->json(['view' => $view_table, 'map_name' => $map_name, 'view_attribut_query' => $view_attribut_query, 'is_summary_exists' => $is_summary_exists, 'view_summary' => $view_summary, 'view_attribut_query_edit' => $view_attribut_query_edit], 200);
    }
}
