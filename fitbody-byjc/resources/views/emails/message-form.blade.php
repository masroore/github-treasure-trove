@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px 20px 10px 20px; font-family: sans-serif; font-size: 18px; font-weight: bold; line-height: 20px; color: #555555; text-align: center;">
                Poruka sa weba.<br>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 20px 0 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="width: 26%">Ime:</td>
                        <td style="width: 74%"><b>{{ $contact->name }}</b></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><b>{{ $contact->email }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px 20px 30px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                <p>{!! $contact->message !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: center;">
                <a href="{{ route('index') }}" style="display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px; background-color: #c23138; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none; -webkit-text-size-adjust: none;">
                    Idi na stranicu
                </a>
            </td>
        </tr>
    </table>
@endsection
