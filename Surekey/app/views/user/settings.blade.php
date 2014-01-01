@extends("layout_admin")
@section("content")
<div id="container" style="margin-top:120px;color:black;">
    <div class="row">
        <div  class=" col-lg-offset-1 col-lg-10 alert-success">
            <h1>Caractéristiques de l'utilisateur : {{ $user->username }}</h1>
        </div>
    </div>
    <div class="row">
        <div class=" col-lg-offset-1 col-lg-10 alert-success" style="color:black;">

            <ul class="list-group">
                <li class="list-group-item">Id : {{ $user->id }}</li>
                <li class="list-group-item">Pseudo : {{ $user->username }}</li>
                <li class="list-group-item">Email : {{ $user->email }}</li>
                <li class="list-group-item">Security Level : {{ $user->securitylevel }}</li>
                <li class="list-group-item">date d'inscription : {{ $user->created_at }}</li>
            </ul>

        </div>
    </div>
</div>
<div id="container" style="margin-top:10px;color:black;margin">
    <div class="row">
        <div  class=" col-lg-offset-1 col-lg-10 alert-success">
            <h1>Device de l'utilisateur : {{ $user->username }}</h1>
        </div>
    </div>
    <div class="row">
        <div class=" col-lg-offset-1 col-lg-10 alert-success" style="color:black;">

            <table class="table-bordered table-responsive" style="width:100%">
                <tr>
                    <th>Device</th>
                    <th>Password</th>
                    <th>Description</th>
                    <th>Date d'ajout</th>
                    <th>Action</th>
                </tr>
                @foreach($devices as $device)
                <tr>
                    <td>{{ $device->device }}</td>
                    <td>{{ $device->password }}</td>
                    <td>{{ $device->description }}</td>
                    <td>{{ $device->created_at }}</td>
                    <td><a href="deleteDevice?deviceId={{ $device->id }}"><input style="width:100%;background-color:#faebcc;border:1px solid black" type="button" name="addDevice" name="delLink" value="Supprimer Device" /></a></td>
                </tr>
                @endforeach
                <tr>
                    <form method="POST" action="addDevice">
                        <td><input  style="width:90%" type="text" name="device" placeholder="identifiant unique ( regarder sur le telephone )"></td>
                        <td>généré automatiquement</td>
                        <td colspan="2"></td>
                        <td><input style="width:100%;background-color:#faebcc;border:1px solid black" type="submit" name="addDevice" value="ajouter Device"></td>
                    </form>
                </tr>
            </table>
            <br/>
        </div>
    </div>
</div>
@stop