# PBSViewer (No longer maintained)*
This program **‘PBSViewer’** also known as Punkbuster (pb) Screenshot Viewer will download [punkbuster](http://www.evenbalance.com/) screens from your gameserver. Those downloaded screens are published on your website. Next to this you can search for pb screens by name or guid.

*Due to lack of time I decided to no longer maintain PBSViewer. I really enjoyed helping the gaming community and learned a lot! At the moment I'm working on several other projects, one of my favorite projects is www.playnow.gs, a game server hosting company.

# Table of contents
  * [See latest changes](../wiki/Changelog.md)
  * [Frequently Asked Questions (FAQ)](../wiki/FAQ.md)
  * [Request a new feature](../wiki/FeatureRequest.md)
  * [Supported Games](../wiki/SupportedGames.md)

# Quick start
* [Download latest version here](https://github.com/brettrijnders/pbsviewer/archive/v2.3.0.1.zip)
* The change log is located here: [changelog](../wiki/Changelog.md)

# System recommendations

  - PHP version 5.0 or higher, did not tested it for lower versions
  - MySQL version 4.0 or higher.
  - Web hosting that supports .htaccess files.
  - Punkbuster server with ftp acces to your pb screens directory.

# Supported Games

- America's Army 2.8.5
- America's Army 3
- Battlefield 2
- Battlefield 2142
- Battlefield Bad company 2
-  Battlefield Play 4 Free
- Battlefield 3
- Call of Duty 4

Probably it can also be used for other [punkbuster](http://www.evenbalance.com/) supported games. For more info please visit the [supported games page](../wiki/SupportedGames.md).

# Latest key Features
  - Download pb screens from your gameserver and show them on your website.
  - Shows your pb screens independently to your visitors, without user/admin intervention.
  - Easy search for screens, search supports wildcards. You can search by guid or name.
  - Great image enhancement tools, you can easily make an image darker or brighter.
  - Secure Admin login.
  - PBSViewer has an Admin Control Panel (ACP), here you can easily configure your PBSViewer.
  - Option to make PBSViewer private, only those who know password can use PBSViewer.
  - Automated checking of md5 hashes of screens, it can automatically check if screens have been altered or not.
  - Get aliases of player.
  - Easy installation script included.
  - Reset feature included to delete all screens and logs.

## Install
  - Check for ss ceiling, read pbsv.cfg file during install
  - Add detailed error message about ftp connection if something goes wrong during or after install

## Misc
  - Multi-server support, servers can be added in admin menu
  - Separate page where admin can keep track of all statistics, for example total download size of all .png files.
  - Bandwidth limiter to prevent that admin reach his/her limit of web hosting
  - History of player and screens

## Thank you
A list of the people who have helped me can be found on the [ThankYouList](../wiki/ThankYouList.md) page.

# Contact
For contact details see the following link:
http://www.brettrijnders.nl

# Copyright and license
PBSViewer is developed by Brett Rijnders (http://www.brettrijnders.nl) and is released under the GPL licence ( see 'licence.txt').
