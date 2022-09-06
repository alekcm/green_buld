<!DOCTYPE html>
<html lang="ru">
<body style="margin:0;padding:0;">
<div style="background:#fff">
    <div style="max-width:100%;margin:0 auto;">
        <table border="0" cellpadding="0" style="max-width:420.0pt">
            <tbody>
            <tr>
                <td style="padding:0 22.5pt 0 22.5pt">
                    <p style="margin:0;margin-bottom:.0001pt;line-height:111%">
                        <b>
                            <span style="font-size:19.0pt;line-height:111%;font-family:Arial,sans-serif">
                                {{ trans('message.forgot_password.email.title') }}
                            </span>
                        </b>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
        <p style="background:white">
            <span style="font-size:12.0pt;font-family:Times New Roman,serif;display:none"></span>
        </p>
        <table border="0" cellpadding="0" style="max-width:420.0pt">
            <tbody>
            @php
                $data = [
                    trans('message.forgot_password.email.email') => $email ?? '',
                    trans('message.forgot_password.email.password') => $password ?? '',
                ];
            @endphp
            @foreach($data as $label => $value)
                <tr>
                    <td style="padding:0 22.5pt 11.25pt 22.5pt">
                        <p style="margin:0;margin-bottom:.0001pt;line-height:17.25pt">
                            <b>
                            <span style="font-size:12.0pt;font-family:Arial,sans-serif;color:#006FB9">
                                {{ $label }}
                            </span>
                            </b>
                        </p>
                        <p style="margin:0cm;margin-bottom:.0001pt;line-height:17.25pt">
                        <span style="font-size:12.0pt;font-family:Arial,sans-serif;color:black">
                            {{ $value }}
                        </span>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

