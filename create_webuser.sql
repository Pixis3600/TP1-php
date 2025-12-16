CREATE USER IF NOT EXISTS 'webuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'Not24get';
GRANT ALL PRIVILEGES ON `voitures`.* TO 'webuser'@'localhost';
FLUSH PRIVILEGES;

SELECT user, host, plugin FROM mysql.user WHERE user = 'webuser';
