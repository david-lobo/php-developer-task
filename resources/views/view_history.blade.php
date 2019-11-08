<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>

        <form action="/export" method="post" id="student_form">
            {{ csrf_field() }}

            <div class="header">
                <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>
                @if (session('alert'))
                    <div class="alert alert-warning">
                        {{ session('alert') }}
                    </div>
                @endif
            </div>

            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th>Filename</th>
                        <th>Size(bytes)</th>
                        <th>Last Modified</th>
                        <th>Download</th>
                    </tr>

                    @if(  count($files) > 0 )
                    @foreach($files as $file)
                    <tr>
                        <td>{{ $file['name'] }}</td>
                        <td>{{ $file['size'] }}</td>
                        <td>{{ $file['last_modified'] }}</td>
                        <td><a target="_blank" href="/download?file={{ $file['name'] }}">Download</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    @endif
                </table>
            </div>

        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>
          $(document).ready(function() {


          });
        </script>
    </body>

</html>
