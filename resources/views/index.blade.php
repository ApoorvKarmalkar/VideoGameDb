<!DOCTYPE html>
<html>
<head>
    <title>Video Game DataBase</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="searchBar">
        <div id="brand">
            <a href="#"><span class="fas fa-gamepad"></span> VGDB</a>
        </div>
        <div id="search">
            <form method="get" action="/game">
                <input id="searchBar" type="text" class="form-control" name="searchTitle" placeholder="Search Game Title...">
            </form>
        </div>
    </div>
    <div id="mainContent">
        <nav id="sidebar" class="navbar d-none d-md-block">
                <ul class="navbar-nav">
                    <li><a class="nav-link" href="#">Home</a></li>
                    <li><a class="nav-link" href="#">Reviews</a></li>
                    <li><a class="nav-link" href="#">Trending</a></li>
                    <li><a class="nav-link" href="#">Upcoming</a></li>
                </ul>
        </nav>
        <div id="gameWrapper">
            @if(isset($_GET['searchTitle']))
                <div class="row">
                    @foreach($output->results as $result)
                        @if(stripos($result->name, $_GET['searchTitle']) !== false)
                            <div class="cardWrapper col-md-4 col-xl-3">
                                <div class="card bg-dark text-white">
                                    <img class="card-img-top" src="{{$result->background_image}}">
                                    <div class="card-body">
                                        <div class="platformRatingWrapper">
                                            @php
                                                $playstationFlag = $xboxFlag = 0;
                                            @endphp
                                            @foreach($result->platforms as $plat)
                                                @if(stripos($plat->platform->name, 'PC') !== false)
                                                    <span class="fab fa-windows fa-sm platformIcons"></span>
                                                @endif
                                                @if(stripos($plat->platform->name, 'PlayStation') !== false && $playstationFlag == 0)
                                                    <span class="fab fa-playstation fa-sm platformIcons"></span>
                                                    @php
                                                        $playstationFlag = 1;
                                                    @endphp
                                                @endif
                                                @if(stripos($plat->platform->name, 'Xbox') !== false && $xboxFlag == 0)
                                                    <span class="fab fa-xbox fa-sm platformIcons"></span>
                                                    @php
                                                        $xboxFlag = 1;
                                                    @endphp
                                                @endif
                                                @if(stripos($plat->platform->name, 'Linux') !== false)
                                                    <span class="fab fa-linux fa-sm platformIcons"></span>
                                                @endif
                                                @if(stripos($plat->platform->name, 'macOS') !== false)
                                                    <span class="fab fa-apple fa-sm platformIcons"></span>
                                                @endif
                                                @if(stripos($plat->platform->name, 'Android') !== false)
                                                    <span class="fab fa-android fa-sm platformIcons"></span>
                                                @endif
                                            @endforeach
                                            @if($result->metacritic)
                                                <span class="ratingIcon">{{$result->metacritic}}</span>
                                                @if($result->metacritic < 75 && $result->metacritic >= 40)
                                                    <script>
                                                        $(".ratingIcon").css({"color":"#fdca52", "border-color":"#fdca52"});
                                                    </script>
                                                @elseif($result->metacritic < 40)
                                                    <script>
                                                        $(".ratingIcon").css({"color":"#d62020", "border-color":"#d44444"});
                                                    </script>
                                                @endif
                                            @endif
                                        </div>
                                        <a class="gameTitleLink stretched-link" href="#"><h2>{{$result->name}}</h2></a>
                                        <ul class="gameInfo">
                                            <li class="aboutItem">
                                                <span class="aboutTag">Release Date:</span>
                                                <span class="aboutData">{{$result->released}}</span>
                                            </li>
                                            <li class="aboutItem">
                                                <span class="aboutTag">Genres:</span>
                                                <span class="aboutData">
                                @foreach($result->genres as $genre)
                                                        {{$genre->name}}
                                                        @if(next($result->genres))
                                                            {{','}}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </li>
                                            <li class="aboutItem">
                                                <span class="aboutTag">Average Playtime:</span>
                                                <span class="aboutData">{{$result->playtime}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $("document").ready(function () {
        $("#searchBar").keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $("form").submit();
            }
        });
    });
</script>

</body>
</html>
