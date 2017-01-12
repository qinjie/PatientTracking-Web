#Patient Tracking Web
Web service has responsibility to:
* Collect data from [Floor server](https://github.com/qinjie/PatientTracking-Python#floor): API services;
* Send data to [Android applications](https://github.com/qinjie/PatientTracking-Android): API services;
* Display residents' location, information: Frontend side;
* Manage residents and their location data: Backend side.

## Environments
* Staging/Demonstration: [http://128.199.93.67/PatientTracking-Web]()
  * Frontend: [http://128.199.93.67/PatientTracking-Web/frontend/web]()
  * Backend: [http://128.199.93.67/PatientTracking-Web/backend/web]()
  * API: [http://128.199.93.67/PatientTracking-Web/api/web/index.php/v1]()

## Software Requirements
* [Git](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-14-04)
* [Composer](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)

### Windows
* [XAMPP](https://www.apachefriends.org/)

### Linux
* [LAMP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04)

### Mac OSX
* [MAMP](https://www.mamp.info)
  
### PHP 
* Tested with 7.0.8, min Version 5.4.0

##Installation Instruction

1. If you use remote server, SSH to server;
2. Import the MySQL database file in ```docs/database.sql```;
  * For a local server use phpMyAdmin, which comes with XAMPP/MAMP/LAMP can be used to import the database; 
3. Go to ```/var/www/html``` (Root directory of Apache);
  * For a local server go to the document root of XAMPP/MAMP/LAMP (Named ```htdocs```);
4. Run ```git clone https://github.com/qinjie/PatientTracking-Web```;
5. Go to PatientTracking-Web folder;
6. Run ```php init```;
7. Run ```chmod -R 777 api/runtime api/web/assets backend/runtime backend/web/assets frontend/runtime frontend/web/assets console/runtime```, to allow temporary folders be writable;
8. Config database in file in ```common/config/mail-local.php```;
9. Run ```composer install``` to install all the library;
10. The server address is something like this:
    * Frontend: ```<server_ip>/PatientTracking-Web/frontend/web```;
    * Backend: ```<server_ip>/PatientTracking-Web/backend/web```;
    * API: ```<server_ip>/PatientTracking-Web/api/web/index.php/v1```.  
11. Python background process is described [Here](https://github.com/qinjie/PatientTracking-Python)