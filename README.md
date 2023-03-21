# zesty-challenge

Code Assessment given by https://www.simplyzesty.com/

PHP version used : 8.1
In order to test my work you will obviously need a virtual machine. (XAMP, WAMP, Vagrant, Docker).

I personally used docker for this test and if you want to use it too, you will need to download Docker desktop app and after on your terminal direct to this project folder and run `docker-compose up`.

This project is also using SQL database. I am leaving a dump file in the root folder for you to import.

Once virtual host is up and database is prepared. Go to the `sql.php` and change sql connection details accordingly.

After setting up both you should be able to access the project.

Main parts of the project to review would be `store.php`, `sql.php` and `index.php`.

To answer a question why would I put `weight` and Order by it the weekdates.
because some people like to display their working hours starting from the sunday.

What would I do if I would have more time on the project:

1.rather than changing timezones I would install timezone API. I would get users ip address using PHP and would do a request to get a timezone user is downloading the website from. Obviously it is not the most accurate as users can use other softwares to change their IP address but it is much better than using select feature.

2.I would spend more time on timetable as it has some errors when working hours pass to another day.

3.I would make admin page for the user where they can edit their opening times as well as toggle `active` row to display that day as CLOSED.

Pages I have used to guide me:

https://stackoverflow.com/questions/5454779/how-to-convert-php-date-formats-to-gmt-and-vice-versa
https://www.php.net/manual/en/language.oop5.interfaces.php

and a usual memory refresher:
https://www.w3schools.com/php/php_mysql_connect.asp
