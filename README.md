# Lazada Price Monitor

A webapp to monitor prices on Lazada using submitted product links. A live demo can be accessed through http://lazada.hellolittlered.org/
  - Inputted products list included
  - Product data includes the product name, highlights, description, and images.
  - Includes price history and a graphic chart to visualize the price change.
  - Data updated everytime the product page is reloaded, every one hour when the page opened, and every one hour through the server.
  - Multi-thread/multi-level comments with upvotes and downvotes. Comments on the product page is sorted by score (upvote - downvote). You can't give both upvote and downvote for the comment, only one.
  
# How To Install
  - Download or clone this repository, put it one your server directory. On localhost, if you use xampp, put the repository on the htdocs folder of your xampp.
  - Create a database named **lazada_monitoring** on mysql. Update **application/config/database.php** according to your mysql/database setup.
  - Change your application base url on **application/config/config.php**. set **$config['base_url']** to your url
  ```$config['base_url'] = 'http://localhost/lazada/';```
  - To create the tables, run **APP_URL/migrate** on your browser. APP_URL is the url of where you install the app. For example on my localhost, the url is **localhost/scrapper** so the migration link is **localhost/scrapper/migrate**.


**warning:** make sure you are connected to the internet when running the application

# Create an Update Schedule
 If you want to app to be able to update the prices even when the page is opened, you need to set up a cron job or a schedule on your server. Your schedule need to curl **APP_URL/scrapper**. There are several ways to curl a link on crob jobs or task scheduler.
 - If you are using cPanel, you can go to cron jobs > add new cron job and set the settings
 - If you are using linux server, read [this file](https://awc.com.my/uploadnew/5ffbd639c5e6eccea359cb1453a02bed_Setting%20Up%20Cron%20Job%20Using%20crontab.pdf) as a guide to set up cron jobs.
On both cPanel and linux, set the command as:
```curl APP_URL/scrapper```
  - If you are using Windows, read [this guide](https://www.drupal.org/docs/7/setting-up-cron-for-drupal/configuring-cron-jobs-with-windows).

##### Note:
If you don't want the prices to be updated when you reload the product page, If you want the prices to be updated only using the scheduler/cron job (server side only), set **$config['client_side_update']** on **application/config/config.php** to false:
```
$config['client_side_update'] = false;
```

# Screenshots
Screenshots of parts of the product page:
![N|Solid](https://preview.ibb.co/gQw1RV/sc1.png)
![N|Solid](https://preview.ibb.co/krsVLq/sc2.png)
![N|Solid](https://preview.ibb.co/dTEALq/sc3.png)