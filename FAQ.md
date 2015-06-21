Here you will find Frequently Asked Questions (FAQ).

# Install #
  * [Why do you need my ftp login details during install?](FAQ#Why_do_you_need_my_ftp_login_details_during_install?.md)
  * [What do I need to fill in for 'PB path'?](FAQ#What_do_I_need_to_fill_in_for_'PB_path'?.md)
  * [What do you mean with CHMOD?](FAQ#What_do_you_mean_with_CHMOD?.md)

# Usage #
  * [After update the download folder is still empty, what is wrong?](FAQ#After_update_the_download_folder_is_still_empty,_what_is_wrong?.md)
  * [Why are all pages are blank?](FAQ#Why_are_all_pages_are_blank?.md)
  * [My update page ran for a while and timed out, what to do?](FAQ#My_update_page_ran_for_a_while_and_timed_out,_what_to_do?.md)
  * [What is a cron job?](FAQ#What_is_a_cron_job?.md)
  * [How can I update using a cron job?](FAQ#How_can_I_update_using_a_cron_job?.md)

# Miscellaneous #
  * [Who are you?](FAQ#Who_are_you?.md)
  * [I can not find my answer, I need further help](FAQ#I_can_not_find_my_answer,_I_need_further_help.md)



---


# Install #
### Why do you need my ftp login details during install? ###
Those ftp login details are needed to download the screenshots from your gameserver and store them on your webserver. Once they are stored you can easily browse through your screens using PBSViewer.

### What do I need to fill in for 'PB path'? ###
During install PB path needs to be filled in. The PB path is referring to the pb directory on your game server. PBSViewer is going to connect through ftp to your gameserver to download the latest screenshots. Those screenshots are then stored on your webserver.

### What do you mean with CHMOD? ###
With CHMOD you set the permissions of your file or directory. You can CHMOD by using FTP, there are a lot of tutorials about how to CHMOD. A couple of those tutorials are shown below:
  * http://www.stadtaus.com/en/tutorials/chmod-ftp-file-permissions.php
  * http://www.siteground.com/tutorials/ftp/ftp_chmod.htm

# Usage #
### After update the download folder is still empty, what is wrong? ###
That is hard to say, multiple things can be wrong.

Here is a list of things that can go wrong:
  * Wrong pb path has been filled in during install, please check this
  * You are running old version of PHP, PBSViewer is made for PHP 5
  * Something went wrong with CHMODDING, please check if all the files and directories are CHMODDED correctly

### Why are all pages are blank? ###
Probably this has to do with the PHP version you are using. PBSViewer is designed to run on PHP 5. If you are using PHP 5, but still getting blank pages, then you might want to check if all the directories and files are CHMODDED correctly.

### My update page ran for a while and timed out, what to do? ###
There are 2 things you can do actually. The first solution is to increase the time limit in ACP, increase the 'Script load time' value.

The second solution is that you make a back-up of your logs and screens on your gameserver. Then delete those screens and logs and play in your game server for a while (to get some screens and logs) and then start updating. The amount of files you have to download now is probably smaller, so it should work right now.

### What is a cron job? ###
A cron job is a job scheduler that can be used to update PBSViewer periodically. More information can be found here:
http://en.wikipedia.org/wiki/Cron

### How can I update using a cron job? ###
In order to be able to update PBSViewer using a cron job you need to do several things. The command that you should use for your cron job looks like this:
```
"/usr/bin/php SomePath/PBSViewer/update.php YourCronkey"
```

You can find your cronkey in the ACP. An example of how a cron command looks like is given below:
```
"/usr/bin/php /var/www/vhosts/mydomain.com/httpdocs/PBSViewer/update.php 2223s46b8275bcde7e2dg6e91597af13"
```

# Miscellaneous #
### Who are you? ###
So you want to know more about me? I would like to refer you to my personal blog:
http://www.beesar.com/about/

### I can not find my answer, I need further help ###
In case you can not find your answer here please try to [contact BandAhr](http://www.beesar.com/contact/) and ask him for help. Please use the [contact form](http://www.beesar.com/contact/) to ask your question(s).