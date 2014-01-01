<!DOCTYPE html>
<html>
@include("head")
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="administrator">Surekey by Bloupih</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="http://twitter.com/Bloupih">Bloupih's Twitter</a></li>
                <li><a href="https://github.com/Bloupih?tab=repositories">Bloupih's github</a></li>
                <li><a href="http://www.youtube.com/user/TheXpl0ze">Bloupih's videos</a></li>
                <li><a href="http://blog.erlem.fr">Erlem's blog</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->username }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::route("user/settings") }}">Paramètres</a></li>
                        <li><a href="{{ URL::route("user/logout") }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
@yield("content")
@include("footer")
</body>
</html>