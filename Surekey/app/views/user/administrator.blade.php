@extends("layout_admin")
@section("content")

<div class="container">
    <div style="margin-top:120px;color:black;" class="col-lg-12 alert-success">



        <h1>SureKey</h1>
        <p>SureKey est une application qui permet d'augmenter la sécurité lors de la connexion de l'un de vos utilisateur sur vos sites.</p>
        <p> Comment tester les applications :</p>
        <ul>
            <li>Deployer l'application web. (cf : php artisan migrate & seed + Installation de Composer )</li>
            <li>Installer sur votre telephone android (ou une VM) l'application SureKey.</li>
            <li>Se connecter sur le site web avec les identifiants : Admin / admin </li>
            <li>Dans les paramètres utilisateur (en haut à droite, cliquez sur "admin", section paramètres), ajoutez un nouveau device :<ul><li><b>Identifiant unique</b>: l'identifiant qui vous est donné par l'application android (en orange)</li><li>Les autres champs sont remplis automatiquement</li></ul></li>
            <li>Sur l'application Android, dans les parametres :<ul><li>Pseudo : Admin</li><li>mot de passe : admin</li><li>Mot de passe device : le mot de passe généré sur le panel utilisateur après ajout du Device. (ex : 95cwk2g5z06tpc4e ) </li></ul></li>
            <li> Appuyer sur "sign in". Si un toast "Connecté !" apparait après chargement, votre device est bien synchronisé avec votre compte web !</li>
        </ul>
        <br/>
       <p> A partir de maintenant, votre device est relié à votre compte. Deconnectez-vous du site web, et tentez de vous reconnecter avec les log : Admin/admin : cela vous retourne une erreur .<br/>
       Pour pouvoir vous connecter sur le site , vous devez utiliser l'application Android pour generer un nouveau code ( celui en rouge ) qui ne pourra être utilisé qu'une seule fois.<br/>
       Après avoir obtenu votre code, tentez de vous connecter à nouveau en entrant dans le troisième champ du formulaire web le code obtenu. Cela fonctionne , et le code a expiré des lors que vous l'avez utilisé.<br/>
       Si vous generez plusieurs codes à la suite, seul le dernier code généré sera utilisable. Les précédents expirent à chaque fois qu'un nouveau code est généré
       </p>
       <p>
           Si vous supprimez le device dans vos paramètres utilisateurs, vous n'aurez plus besoin de l'application android pour vous connecter.<br/>
           Si vous ajoutez plusieurs device, vous pourrez obtenir des codes uniques à partir de chacun d'entre eux (vous devez tous les synchroniser en entrant le login / password / password_device adequat).<br/>
           Si vous supprimez un device et qu'il en reste un ou plus après suppression, vous ne pourrez pas vous connecter sans mot de passe à utilisation unique.
       </p>
        <br/>

        <h4>Explications techniques</h4>
            <p>Technos utilisés :</p>
            <ul>
                <li>Application web :
                    <ul>
                        <li>Laravel4 ( PHP POO , Blade, Eloquent, Composer)</li>
                        <li>JSON</li>
                        <li>bdd Mysql(via PHPMyAdmin)</li>
                        <li>BootStrap3</li>
                    </ul>
                </li>
                <li>Application Android
                    <ul>
                        <li>Java Android</li>
                        <li>XML</li>
                    </ul>
                </li>
            </ul>
            <p>Le processus de traitement / génération du mot de passe est le suivant :</p>
                <ul>
                    <li>Reception d'une requète GET du telephone contenant 3 parametres : <ul><li>pseudo : le nom du compte</li><li>password : le mot de passe du compte (crypté)</li><li>device : l'identifiant unique du device</li></ul></li>
                    <li>Si le pseudo est présent dans la db, et que le device existe et est associé au pseudo indiqué, on utilise le mot de passe du device pour décrypter le mot de passe du compte. </li>
                    <li>Si le couple login/decrypt(password) éxiste, on passe à la génération du mot de passe</li>
                    <li>le mot de passe est un objet Key : <ul><li>id : l'id de la clef</li><li>content : la valeure de la clef . String(10) générée aléatoirement</li><li>accountid : le compte associé à cette clef</li><li>deviceid : la primary key du device qui a permis de générer cette clef</li><li>status : le status de la clef (1 = valide, 0 = expired)</li></ul></li>
                    <li>la propriété "contenu", en clair dans la base, est cryptée avec un algorythme AES utilisant le mot de passe du device avant d'être retourné au format JSON.</li>
                    <li>le device récupère la clé au format JSON, la parse, puis la décrypte  grâce au mot de passe du device. Enfin, il l'affiche</li>
                    <li>Si la connexion sur le site est validée avec cette clef fraichement crée , le status de la clef devient expiré ( 0 )</li>
                </ul>
        <br/>
        <h4>Sources</h4>
        <p>Interface et authentification simple : JF Erlem. (Erlem's Laravel tutorial : <a href="http://blog.erlem.fr/programmation/developpement-web/framework/33-laravel/63-laravel-4-cas-pratique-authentification">Erlem's blog</a> </p>
        <p>ApiCrypter AES : cwill-dev. (Cwill-dev AES tutorial : <a href="http://blog.cwill-dev.com/2012/10/09/encryption-between-javaandroid-and-php/">Cwill-dev's blog</a></p>
        <p>Authentification renforcée, panel utilisateur et application android : Xpl0ze ( <a href="http://youtube.com/TheXpl0ze">Videos</a> /<a href="http://xpl0zion.com/"> Site</a> / <a href="http://twitter.com/Bloupih">Twitter</a> )</p>
    </div>
</div>
@stop