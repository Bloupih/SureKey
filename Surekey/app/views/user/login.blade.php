@extends("layout")
@section("content")
<div class="container">
    <div id="form-login">
        <ul id="loginTab" class="nav tabs">
            <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
            <li><a href="#register" data-toggle="tab">Register</a></li>
            <li><a href="#reset" data-toggle="tab">Reset password</a></li>
        </ul>
        <div id="loginTabContent" class="tab-content form-login-content">
            <div class="tab-pane fade active in" id="login">
                <h1>Login</h1> 
                @if ($error = $errors->first("password"))
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $error }}
                    </div>
                @else
                    <p>Default login : admin / admin</p>
                @endif                
                {{ Form::open(["route" => "user/login"]) }}
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        {{ Form::text("loginUsername", Input::get("loginUsername"), ["class" => "form-control", "id" => "loginUsername", "placeholder" => "Username", "autofocus" => true]) }}
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        {{ Form::password("loginPassword", ["class" => "form-control", "id" => "loginPassword", "placeholder" => "Password"]) }}
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-dashboard"></span></span>
                        {{ Form::password("loginUniquePassword", ["class" => "form-control", "id" => "loginUniquePassword", "placeholder" => "Unique Password"]) }}
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                    {{ Form::submit("Sign In", ["class" => "btn btn-primary btn-lg btn-block", "id" => "loginButton"]) }}
                {{ Form::close() }}
            </div>
            <div class="tab-pane fade" id="register">
                <h1>Register</h1> 
                <p>Aeneanero sit amet quam egestas semp ultricies mi vitae est. Vestibulum erat wisi, condimentum sed.</p>
                <form role="form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" id="registerUsername" placeholder="Username">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" class="form-control" id="registerPassword" placeholder="Password">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" class="form-control" id="registerRepeatPassword" placeholder="Repeat Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Register Now</button>
                </form>
            </div>
            <div class="tab-pane fade" id="reset">
                <h1>Reset password</h1> 
                <p>Aeneanero sit amet quam egestas semp ultricies mi vitae est. Vestibulum erat wisi, condimentum sed.</p>
                <form role="form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" id="resetUsername" placeholder="Username">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" class="form-control" id="resetEmail" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Recover Password</button>
                </form>
            </div>
        </div>
    </div> <!-- /form-login -->
</div> <!-- /container -->
@stop