<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Create PDF</title>
    <style>
        body {
            font-family: ipag;
        }
    </style>
</head>

<body>

    <div style="padding-left: 10%;">
        <h3 style="text-align:left">氏名: {{ $name }} &nbsp;&nbsp;&nbsp;<span
                style="text-align:right; font-size:12px;">回答日: {{ $created_at }}</span></h3>
        <h4>項目: {{ explode('-', $quiz1)[0] }}</h4>
        <table style="font-size: 14px; margin:auto; width:80%;">
            <!-- <thead>
                <tr>
                    <th>提案NO</th>
                    <th>回答</th>
                </tr>
            </thead> -->

            <tbody>
                {{ $cnt = 0 }}
                @foreach (explode(',', $quiz1) as $quiz)
                    <tr>
                        <td style="text-align: center;">{{ $cnt = $cnt + 1 }}</td>
                        <td style="padding-left: 50vw; padding-top:2px; ">{{ $quiz_array[trim($quiz)] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 style="padding-left:10px;">
            {{ $type == 'recruiment' ? '提案№' : ($type == 'sales' ? 'ランク' : '状況') }}: {{ $no1 }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $type == 'recruiment' ? 'お勧め進路' : '説明概要' }}:
            {{ $res1 }}</h4>

    </div>
</body>

</html>
