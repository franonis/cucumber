<!DOCTYPE html>
<html>
    <head>
        <title>404 Resource Not Found</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.css') }}">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            
            .footer-button {
                font-size: 50px;
                margin-top: 10%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Resource Not Found!</div>
                <div class="footer-button">
                    <a href="{{ url('/') }}">
                        <button class="button button-primary button-circle button-giant button-longshadow"><i class="fa fa-home"></i></button></a>
                    <a href="{{ url()->previous() }}">
                        <button class="button button-highlight button-circle button-giant button-longshadow"><i class="fa fa-arrow-circle-left"></i></button></a>
                </div>
            </div>
        </div>
    </body>
</html>
