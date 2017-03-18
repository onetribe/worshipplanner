<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>muso - {{ __('common.tag_line') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="/css/public.css" rel="stylesheet" type="text/css">
    </head>
    <body class="welcome-page">
        <div class="flex-center position-ref full-height">
            @include('layouts._public_top_links')

            <div class="content">
                <div class="logo">
                    <img src="/images/muso_logo_white.png" />
                </div>

                <div class="links">
                    {{ __('common.tag_line') }}
                </div>
            </div>
        </div>
    </body>
</html>
