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
        <h3 style="text-align:left">氏名: {{ $name }} </h3>
        <h3 style=" ">回答日: {{ $created_at }}</h3>
        <h4>項目: 職種適性</h4>
        <h4 style="">
            提案された適性職業 : {{ $result }}
        </h4>
        <h4>回答内容 : </h4>
        <table style="font-size: 14px;  width:80%;">
            <thead>
                <tr>
                    <th>提案NO</th>
                    <th>回答</th>
                </tr>
            </thead>

            <tbody>
                {{ $cnt = 0 }}
                @foreach ($quiz_array as $quiz)
                    <tr>
                        <td style="text-align: center;">{{ $cnt = $cnt + 1 }}</td>
                        <td style="padding-left: 50vw; padding-top:2px; ">{{ $quiz }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



    </div>
</body>

</html>
