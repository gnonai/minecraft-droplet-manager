<?php
/* 

Minecraft Droplet Manager

http://spcampbell.github.io/minecraft-droplet-manager/

Single click control of a minecraft server droplet
hosted on Digital Ocean. Starts it up when ready to play
and tears it down when done. Automatically creates a latest
snapshot before destroying droplet.

Let the kids play without needing your help and costing you a fortune.

Released under MIT License - 2015 - spcampbell

Inspired by the work of S-rc-C-d-
http://hi.srccd.com/post/hosting-minecraft-on-digitalocean

*/

session_start();

$getready = isset($_GET['ready']) ? $_GET['ready'] : '';
$hma = isset($_SESSION['hmauthenticated']) ? $_SESSION['hmauthenticated'] : false;
$whatlevel = isset($_SESSION['hmauthlvl']) ? $_SESSION['hmauthlvl'] : '';

if ($hma !== true || $whatlevel != "A") header( 'Location: index.php?logout=yes' );
if ($getready != "yes") header( 'Location: index_minecraft.php?ready=yes' ); //doing this so there are no callbacks

if ($whatlevel != "A") header( 'Location: index.php?logout=yes' );
?>

<!DOCTYPE html>
<html lang="en" ng-app="domcmgrApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft Droplet Manager</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/angular-busy.min.css" rel="stylesheet">
    <link href="css/cover.css" rel="stylesheet">
    <link href="css/domcmgr.css" rel="stylesheet">
</head>
<body ng-controller="DomcmgrController" ng-cloak>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="inner cover">
                    <div class="row">
                        <div class="col-md-12"><h1>Minecraft Droplet Manager</h1></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><p><a class="btn btn-default btn-xs" type="button" href="index.php?logout=yes">Logout</a></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div cg-busy="{promise:initPromise,message:'Loading',backdrop:false,delay:10,minDuration:700}">
                        <div class="row">
                            <div class="col-md-12"><p class="lead">Server: {{ servername | uppercase }}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><p class="lead">Status: {{ serverstatus | uppercase }}</p></div>
                        </div>
                    </div>
                    
					<div ng-show="serverupshow">
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6" id="serverstats">
                                <p>{{ cpu }} CPU - {{ ram }} RAM - {{ storage }} HDD</p>
                                <p>UP {{ up }} HRS - COST ${{ cost }}</p>
                            </div>
                            <div class="col-md-3">&nbsp;</div>
                        </div>
						<div class="row">
							<div class="col-md-12">
                                <p class="lead">Play Minecraft at: {{ serverlocation }} 
                                <span>&nbsp;</span>
                                <a tooltip="Copy address to clipboard">
                                <button class="btn btn-default btn-xs" clip-copy="serverlocation" clip-click="clipdone()" clip-click-fallback="fallback(copy)"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></button>
                                </a>
                                </p>
                            </div> 
						</div>
                        <div class="clipdonebox fadeanim" ng-show="clipdoneshow"><button type="button" class="btn btn-default btn-sm">Server address was copied to clipboard</button></div>
						<div class="row">
							<div class="col-md-12"><p class="lead">Admin Console:  <a data-ng-href="https://{{ serverip }}:8080" target="_blank">https://{{ serverip }}:8080</a></p></div>
						</div>
						<div class="row">
							<div class="col-md-12">&nbsp;</div>
						</div>					
						<div class="row" ng-hide="serveroutput">
							<div class="col-md-12">
                                <button type="button" class="btn btn-danger" data-ng-click="archive()">Click to Archive Server</button>
								<p>Make sure and archive the server<BR>when done for more than a couple of hours</p>
							</div>
						</div>
                    </div>		
                    
                     <div ng-show="serverdownshow">
					 	<div class="row">
				            <div class="col-md-12">&nbsp;</div>
						</div>	
                         
                        <div id="progressmodal" ng-show="serveroutput">
                            <div class="row" ng-repeat="line in output">
                                <div class="col-md-12"><p class="lead">{{ line }}</p></div>
                            </div>	
                            <div cg-busy="{promise:outputPromise,message:'Please wait',backdrop:false,delay:10,minDuration:700}">
                                <div class="row">
                                    <div class="col-md-12">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">&nbsp;</div>
                                </div>
                            </div>
                        </div> 
                         
						<div class="row" ng-hide="serveroutput">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" data-ng-click="startUp()">Click to Start Playing</button>
                            </div>
						</div>  
                    </div>		
                    
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>       
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.8/angular.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.12.0.min.js"></script>
    <script src="js/ZeroClipboard.min.js"></script>
    <script src="js/ng-clip.min.js"></script>
    <script src="js/angular-busy.min.js"></script>
    <script src="app/app.js"></script>
    <script src="app/controllers/domcmgrController.js"></script>
    <script src="app/services/doapiFactory.js"></script>
</body>
</html>
