
<!DOCTYPE html>
<html>
<head>
	<title>A.Slacker - Twitter API WS</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


<div class="container">
    <h2>A.Slacker - Twitter API Intento 2</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="50px">No</th>
                <th>Twitter Id</th>
                <th>Message</th>
                <th>Images</th>
                <th>Favorite</th>
                <th>Retweet</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data))
                @foreach($data['data']['statuses'] as $llave => $valor)
                    <tr>
                        <td>{{ ++$llave }}</td>
                        <td>{{ $valor['id'] }}</td>
                        <td>{{ $valor['full_text'] }}</td>
                        <td>
                            @if(!empty($valor['extended_entities']['media']))
                                @foreach($valor['extended_entities']['media'] as $v)
                                    <img src="{{ $v['media_url_https'] }}" style="width:100px;">
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $valor['favorite_count'] }}</td>
                        <td>{{ $valor['retweet_count'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">There are no data.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


</body>
</html>