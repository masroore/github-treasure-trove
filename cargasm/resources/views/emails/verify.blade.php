@extends('emails.layout')
@section('content')
    <tr>
        <td align="center" class="letter-content" valign="top"
            style="padding:0;margin:0;padding-bottom: 45px;">
            <img style="max-width: 100%;" src="{{ asset('images/logo.png')}}" alt="">
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="padding:0;margin:0;">
            <table style="background: #FFFFFF;border-radius: 5px;overflow: hidden;padding:50px"
                   class="letter-content" align="center" width="100%" border="0" cellpadding="0"
                   cellspacing="0" data-editable="text">
                <tr>
                    <td style="padding-bottom:28px;">
                            <span class="letter-title"
                                  style="display:block;font-family:Arial,sans-serif;color:#333333;font-size:24px;font-weight:bold;line-height:28px;">
                                {{$greeting}}
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="padding:0;margin:0;">
                            <tr>
                                <td valign="top" align="left" style="margin:0;padding:0">

                                        <span class="letter-user"
                                              style="line-height:22px;display:block;padding-right:0px;padding-bottom:0;padding-left:0px;font-family:Arial,sans-serif;color:#333333;font-size:14px;font-weight:normal;">
                                            {{$firstPart}}
                                            <a href="{{config('app.url')}}"
                                                                           style="color:#E62128;text-decoration: underline;">{{config('app.name')}}</a>,
                                            {{$secondPart}}

                                        </span>
                                    <a class="letter-button" target="_blank" href="{{$actionUrl}}"
                                       style="text-transform: uppercase;text-align:center;font-family:Arial,sans-serif;background-color:#E62128;border-radius:5px;text-decoration: none;color: #ffffff;font-size: 14px;border: none;transition: 0.3s;padding: 16px 35px;margin:30px 0 40px;display: inline-block;">
                                        {{$actionText}}</a>
                                    <p
                                        style="font-family:Arial,sans-serif;font-size: 14px;line-height: 22px;color: #999999; margin: 0 0 26px;">
                                        {{$textTeam}}</p>
                                    <span class="letter-user"
                                          style="padding-top:30px;line-height:22px;display:block;padding-right:0px;padding-bottom:0;padding-left:0px;font-family:Arial,sans-serif;color:#333333;font-size:14px;font-weight:normal;border-top:1px solid #E6E6E6;">
                                            {{trans('auth.mail.footer')}}
                                            <a href="{{$actionUrl}}"
                                               style="display:block;word-break: break-all;color:#3f73d9;text-decoration: underline;">{{$actionUrl}}</a>
                                        </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="letter-content"
            style="padding-right:0px;padding-bottom:0;padding-top:18px;padding-left:0px;margin:0;">
                <span class="letter-real"
                      style="line-height: 18px;display:block;padding-right:0px;padding-left:0px;font-family:Arial,sans-serif;color:#999999;font-size:12px;font-weight:normal;">
                    Если вы считаете, что это сообщение было отправлено
                    вам по ошибке, <a
                        style="color: #999999;text-decoration:underline;font-family:Arial,sans-serif;"
                        href="#">откажитесь от
                        подписки</a>
                </span>
            <span class="letter-real"
                  style="line-height: 21px;display:block;padding-right:0px;padding-left:0px;font-family:Arial,sans-serif;color:#999999;font-size:12px;font-weight:normal;">
                    Для получения дополнительной информации см. нашу <a href="#"
                                                                        style="color: #999999;text-decoration:underline;font-family:Arial,sans-serif;">политику
                        конфиденциальности</a>.
                </span>
            <span
                style="margin-top:15px;text-align:left;line-height:18px;display:block;padding-right:0px;padding-top:0px;padding-left:0px;font-family:Arial,sans-serif;color:#999999;font-size:12px;font-weight:normal;">
                    {{trans('auth.mail.copyright',['site' => config('app.name')])}}
                </span>
        </td>
    </tr>
@endsection

