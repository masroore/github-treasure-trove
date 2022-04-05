<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

class MapsSchema
{
    public function AllColumnData($table_name)
    {
        $data_table = DB::select("SELECT cols.column_name, cols.data_type,
                                        (select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment
                                            from information_schema.columns cols
                                            where cols.table_name='" . $table_name . "' ");

        return $data_table;
    }

    public function getColumnType($column_name, $table_name)
    {
        $type_attr = DB::select("SELECT cols.column_name, cols.data_type,
                                        (select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment
                                            from information_schema.columns cols
                                            where cols.table_name='" . $table_name . "' AND cols.column_name ='" . $column_name . "' ");
        $type = $type_attr[0]->data_type;

        return $type;
    }

    public function clientQuery($hitungan, $attribut, $table_name, $kec, $is_filter, $operator_filter, $attribut_filter, $value_filter)
    {
        $value = '';
        $query = 'SELECT * FROM maps.' . $table_name;
        if ($hitungan == 'count_all') {
            $res = 'SELECT COUNT(*) AS jum FROM maps.' . $table_name;
        } elseif ($hitungan == 'sum') {
            $res = 'SELECT SUM(' . $attribut . ') AS jum FROM maps.' . $table_name;
        } elseif ($hitungan == 'min') {
            $res = 'SELECT MIN(' . $attribut . ') AS jum FROM maps.' . $table_name;
        } elseif ($hitungan == 'max') {
            $res = 'SELECT MAX(' . $attribut . ') AS jum FROM maps.' . $table_name;
        } elseif ($hitungan == 'avg') {
            $res = 'SELECT AVG(' . $attribut . ') AS jum FROM maps.' . $table_name;
        }

        if ($kec !== 'null') {
            $res .= ' c LEFT JOIN maps.batas_kecamatan_query kec ON ST_WITHIN(ST_TRANSFORM(c.geom,32749),kec.geom) WHERE kec.gid = ' . $kec . ' ';
            $query .= ' c LEFT JOIN maps.batas_kecamatan_query kec ON ST_WITHIN(ST_TRANSFORM(c.geom,32749),kec.geom) WHERE kec.gid = ' . $kec . ' ';
        }

        if ($is_filter == 'on') {
            $search_col_type = DB::select("SELECT cols.column_name, cols.data_type,
                                        (select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment
                                            from information_schema.columns cols
                                            where cols.table_name='" . $table_name . "' AND cols.column_name = '" . $attribut_filter . "'");
            $attr_type = $search_col_type[0]->data_type;
            if ($kec !== 'null') {
                if ($operator_filter !== 'like') {
                    if ($operator_filter == 'IS NOT NULL' || $operator_filter == 'IS NULL') {
                        $res .= ' AND ' . $attribut_filter . ' ' . $operator_filter;
                        $query .= ' AND ' . $attribut_filter . ' ' . $operator_filter;
                    } else {
                        if ($attr_type == 'character varying') {
                            $res .= ' AND ' . $attribut_filter . ' ' . $operator_filter . " '" . $value_filter . "'";
                            $query .= ' AND ' . $attribut_filter . ' ' . $operator_filter . " '" . $value_filter . "'";
                        } else {
                            $res .= ' AND ' . $attribut_filter . ' ' . $operator_filter . ' ' . $value_filter;
                            $query .= ' AND ' . $attribut_filter . ' ' . $operator_filter . ' ' . $value_filter;
                        }
                    }
                } else {
                    $res .= ' AND ' . $attribut_filter . " ILIKE '%" . $value_filter . "%'";
                    $query .= ' AND ' . $attribut_filter . " ILIKE '%" . $value_filter . "%'";
                }
            } else {
                if ($operator_filter !== 'like') {
                    if ($operator_filter == 'IS NOT NULL' || $operator_filter == 'IS NULL') {
                        $res .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter;
                        $query .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter;
                    } else {
                        if ($attr_type == 'character varying') {
                            $res .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter . " '" . $value_filter . "'";
                            $query .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter . " '" . $value_filter . "'";
                        } else {
                            $res .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter . ' ' . $value_filter;
                            $query .= ' WHERE ' . $attribut_filter . ' ' . $operator_filter . ' ' . $value_filter;
                        }
                    }
                } else {
                    $res .= ' WHERE ' . $attribut_filter . " ILIKE '%" . $value_filter . "%' ";
                    $query .= ' WHERE ' . $attribut_filter . " ILIKE '%" . $value_filter . "%' ";
                }
            }
        }
        $res = DB::select($res);

        return ['is_filter' => $is_filter, 'res' => $res[0]->jum, 'query' => $query];
    }

    public function generate_query($request, $data)
    {
        $values = 'INSERT INTO maps.' . $request->table_name . ' (';
        $count_arr = count($data);
        $i = 1;
        foreach ($data as $f) {
            if ($i > 1) {
                if ($count_arr == $i) {
                    $values .= $f->column_name . '';
                } else {
                    $values .= $f->column_name . ', ';
                }
            }
            ++$i;
        }
        $values .= ') VALUES (';
        $i = 1;
        foreach ($data as $f) {
            if ($i > 1) {
                $val = $f->column_name;
                if ($f->column_name == 'geom') {
                    if ($count_arr == $i) {
                        $values .= "ST_GeomFromText(ST_AsText(ST_Transform(ST_GeomFromText('" . $request->$val . "',900913)," . $request->srid . ')),' . $request->srid . ')';
                    } else {
                        $values .= "ST_GeomFromText(ST_AsText(ST_Transform(ST_GeomFromText('" . $request->$val . "',900913)," . $request->srid . ')),' . $request->srid . '),';
                    }
                } else {
                    if ($count_arr == $i) {
                        $values .= "'" . pg_escape_string($request->$val) . "' ";
                    } else {
                        $values .= "'" . pg_escape_string($request->$val) . "',";
                    }
                }
            }
            ++$i;
        }
        $values .= ');';

        return $values;
    }

    public function generate_edit_query($request, $data)
    {
        $values = 'UPDATE maps.' . $request->table_name . ' SET ';
        $count_arr = count($data);
        $i = 1;
        $stat = true;
        foreach ($data as $f) {
            if ($i == $count_arr && $f->column_name !== 'geom') {
                $stat = false;
            }
            ++$i;
        }
        $i = 1;
        foreach ($data as $f) {
            if ($stat == true) {
                if ($i > 1) {
                    if ($f->column_name !== 'geom') {
                        if ($i == $count_arr - 1) {
                            $col_name = $f->column_name;
                            $values .= $f->column_name . "= '" . pg_escape_string($request->$col_name) . "'";
                        } else {
                            $col_name = $f->column_name;
                            $values .= $f->column_name . "= '" . pg_escape_string($request->$col_name) . "', ";
                        }
                    }
                }
            } else {
                if ($i > 1) {
                    if ($f->column_name !== 'geom') {
                        if ($i == $count_arr) {
                            $col_name = $f->column_name;
                            $values .= $f->column_name . "= '" . pg_escape_string($request->$col_name) . "'";
                        } else {
                            $col_name = $f->column_name;
                            $values .= $f->column_name . "= '" . pg_escape_string($request->$col_name) . "', ";
                        }
                    }
                }
            }
            ++$i;
        }
        $values .= ' WHERE gid = ' . $request->gid . ' ';

        return $values;
    }
}
