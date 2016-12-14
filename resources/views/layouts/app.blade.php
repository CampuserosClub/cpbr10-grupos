<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vire um curador #CPBR10</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <div class="text-center visible-xs">
                        <a href="http://campuseirosclub.com/" target="_blank">
                            <img src="https://i.imgur.com/au8IA6w.png" height="120px" />
                        </a>
                    </div>
                    <div class="hidden-xs">
                        <a href="http://campuseirosclub.com/" target="_blank">
                            <img src="https://i.imgur.com/au8IA6w.png" height="120px" />
                        </a>
                    </div>
                </div>

                <span align="center">
                    <h1>Vire um curador<br /><small>#CPBR10</small></h1>
                </span>
            </div>
        </nav>

        @yield('content')

        <style>
        footer {
            background: #eee;
            color: #333;
        }
        footer a {
            color: #333;
            font-weight: bold;
        }

        footer .adsense {
            min-height: 5px;
            /*min-width: 300px;*/
        }
        </style>
        <footer class="navbar-fixed-bottom text-center small">
            <div class="container">
                <p>
                    <br />
                    Developed by <a href="https://twitter.com/jaonoctus" target="_blank">@jaonoctus</a> and <a href="https://www.facebook.com/LucasNicolauOliveira" class="alert-link" target="_blank">Lucas</a>
                    <span class="hidden-xs">|</span><span class="visible-xs"><br /></span>
                    Made with <i class="fa fa-heart-o"></i>.
                    We are on <a href="https://github.com/CampuserosClub/cpbr10-curadores" class="alert-link" target="_blank">GitHub</a>
                </p>
            </div>
        </footer>
    </div>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript"> var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date(); (function(){ var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0]; s1.async=true; s1.src='https://embed.tawk.to/5850d297f9976a1964d35dd5/default'; s1.charset='UTF-8'; s1.setAttribute('crossorigin','*'); s0.parentNode.insertBefore(s1,s0); })(); </script>
    <!--End of Tawk.to Script-->

    <!-- Scripts -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-88929539-1', 'auto');
      ga('send', 'pageview');

    </script>
    <script src="/js/app.js"></script>
</body>
</html>
