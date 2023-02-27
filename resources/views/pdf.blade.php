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

    <div>
        <h1>氏名: {{ $name }}</h1>

        @if($quiz1 != '')
        <h5>項目: {{ explode('-', $quiz1)[0] }}</h5>
        <table style="font-size: 12px;">
            <thead>
                <tr>
                    <th>提案NO</th>
                    <th>回答</th>
                </tr>
            </thead>

            <tbody>
                {{ $cnt = 0 }}
                @foreach(explode(',', $quiz1) as $quiz)

                <tr>
                    <td style="text-align: center;">{{ $cnt = $cnt+1 }}</td>
                    <td style="padding-left: 10px;">{{ $quiz_array[$quiz] }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
        
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? '提案№' : ( $type == 'sales' ? 'ランク' : '状況')}}: {{$no1}}</h5>
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? 'お勧め進路' : '説明概要'}}: {{$res1}}</h5>

        
        @endif

        @if($quiz2 != '')
        <h5>項目: {{ explode('-', $quiz2)[0] }}</h5>
        <table style="font-size: 12px;">
            <thead>
                <tr>
                    <th>提案NO</th>
                    <th>回答</th>
                </tr>
            </thead>

            <tbody>
                {{ $cnt = 0 }}
                @foreach(explode(',', $quiz1) as $quiz)

                <tr>
                    <td style="text-align: center;">{{ $cnt = $cnt+1 }}</td>
                    <td style="padding-left: 10px;">{{ $quiz_array[$quiz] }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
        
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? '提案№' : ( $type == 'sales' ? 'ランク' : '状況')}}: {{$no2}}</h5>
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? 'お勧め進路' : '説明概要'}}: {{$res2}}</h5>

        
        @endif

        @if($quiz3 != '')
        <h5>項目: {{ explode('-', $quiz3)[0] }}</h5>
        <table style="font-size: 12px;">
            <thead>
                <tr>
                    <th>提案NO</th>
                    <th>回答</th>
                </tr>
            </thead>

            <tbody>
                {{ $cnt = 0 }}
                @foreach(explode(',', $quiz1) as $quiz)

                <tr>
                    <td style="text-align: center;">{{ $cnt = $cnt+1 }}</td>
                    <td style="padding-left: 10px;">{{ $quiz_array[$quiz] }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
        
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? '提案№' : ( $type == 'sales' ? 'ランク' : '状況')}}: {{$no3}}</h5>
        <h5 style="padding-left:10px;">{{ $type == 'recruiment' ? 'お勧め進路' : '説明概要'}}: {{$res3}}</h5>

        
        @endif


    </div>

</body>

</html>