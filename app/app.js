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

(function() {
    
    var app = angular.module('domcmgrApp', ['ui.bootstrap','ngClipboard','ngAnimate','cgBusy']);
    
    app.config(['ngClipProvider', function(ngClipProvider) {
      ngClipProvider.setPath("ZeroClipboard.swf");
    }]);
    
}());