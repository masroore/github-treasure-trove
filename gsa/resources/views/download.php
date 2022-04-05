<?php
$folder   = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_SPECIAL_CHARS);
$filename = filter_input(INPUT_GET, 'map', FILTER_SANITIZE_SPECIAL_CHARS) . '.zip';
$filepath = env( 'TEMP_FOLDER' ) . "/" . $folder . "/" . $filename;

if ( !is_file( $filepath ) ) {
	echo 'ERROR: File tidak ditemukan '.$filepath;
} else if ( is_dir( $filepath ) ) {
	echo 'ERROR: Download gagal.';
} else {
	download( $filename, $filepath );
}

function download( $filename, $filepath ) {
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=". $filename );
	header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: binary");
	header('Connection: Keep-Alive');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	set_time_limit(0);
	readfile( $filepath );
}