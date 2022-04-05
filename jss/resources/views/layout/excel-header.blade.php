<!DOCTYPE html>
<?php
    $os = session()->get('os');
    $str_space = '';

    if($os == 'windows'){
        $str_space = '&nbsp;';
        header( 'Content-Type: application/vnd.ms-excel' );
    }else{
        $str_space = '&#160;';
        header( 'Content-Type: application/vnd.oasis.opendocument.spreadsheet' );
    }

    header( 'Content-Disposition: attachment; filename="'.$excel_name.'.xls"' );

    $isIE = (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)) ? 1 : 0;
    if($isIE){
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }else{
        header('Pragma: no-cache'); // public
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    }
?>
<html lang="cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')
</body>
</html>
