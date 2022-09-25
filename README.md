
Installation Manual



1 - In your hosting, create a database with the name xtreamserver (note that, depending on the hosting, it creates with a prefix before, for example: UI941322_xtreamserver)

2 - Create the user/password with the ALL GRANT permission for the created database (note that, depending on the hosting, it creates with a prefix before, for example: UI941322_usuario)

3 - Unzip the system file in a location on your computer

4 - Access PhpMyadmin from your hosting in the database created

5 - In the folder xtreamserver/Database/, in the place where you unpacked the system file, locate the file xtreamserver.sql and import or copy its contents and paste in PhpMyadmin and run to create the system tables

6 - Edit the related.php file that is inside the xtreamserver/controls/ folder in the place where you unpacked the system file and inform the data regarding your hosting and the database and user created, as the lines below (line 2 to line 6)

$address = "localhost"; // here is the server address of your hosting

$usuario = " "; // here is the user you created for your database

$password = " "; // here is the password you created for your database user

$bank = "xtreamserver"; // here you put the database created

7 - Configure the api.php file that is inside the xtreamserver/ folder in the place where you decompressed the system file, in line 51, as described below:

$url = 'http://seusistema.com.br:80/api.php'; // here you put the address you chose for your system, followed by :80 which is the port

8 - Configure the files fast_backup.php and fast_restore.php that are inside the folder xtreamserver/ in the place where you unpacked the system file, lines 5, 6, 7 and 8 with the user information, password, database and host that you created in your hosting

9 - After that, you just upload all the files and folders that are inside the xtreamserver/ folder in the location where you unzipped the system file, to your domain/hosting folder
