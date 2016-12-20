#Patient Tracking Web

##Installation Instruction

1. SSH to server;
2. Install [LAMP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04), [Git](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-14-04), [Composer](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04) (If need);
3. Install database file;
4. Go to /var/www/html (Root directory of Apache);
5. Run ```git clone https://github.com/qinjie/PatientTracking-Web```;
6. Go to PatientTracking-Web folder;
7. Run ```php init```;
8. Run ```chmod -R 777 api/runtime api/web/assets backend/runtime backend/web/assets frontend/runtime frontend/web/assets console/runtime```, to allow temporary folders be writable;
9. Config database in file in ```common/config/mail-local.php```;
10. Run ```composer install``` to install all the library; <br>
    If can't run ```composer install```, run this first:<br>
	```composer global require "fxp/composer-asset-plugin:1.0.3"```;
11. The server address is something like this:
    * Frontend: ```<server_ip>/PatientTracking-Web/frontend/web```;
    * Backend: ```<server_ip>/PatientTracking-Web/backend/web```;
    * API: ```<server_ip>/PatientTracking-Web/api/web/index.php/v1```.