## Разворачивание проекта на Ubuntu

Для разворачивания проекта потребуются MySQL, PHP 8.1, Nginx, Composer

### Установка MySQL, создание базы данных и пользователя ([ссылка на статью](https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-20-04-ru))

1. `sudo apt update`
2. `sudo apt upgrade`
3. Установка MySQL: `sudo apt install mysql-server`
4. Проверить правильность установки: `mysql --version`
5. Установить пароль для root-пользователя MySQL: `sudo mysql_secure_installation`

Создание базы данных и пользователя (немного отличается от статьи):
1. Запустить приложение MySQL: `sudo mysql`. Терминал будет выглядеть следующим образом:
```
mysql>
```
2. Команда для создания базы данных с названием `gpn`:
```
create database gpn;
```
3. Команда для создания пользователя `gpn_user` с паролем `rvn8giBT`:
```
create user 'gpn_user'@'localhost' identified with mysql_native_password BY 'rvn8giBT';
```
4. Передать пользователю привелегии на базу данных:
```
grant all privileges on gpn.* to 'gpn_user'@'localhost';
```
5. Выйти из MySQL: `exit`

Проверить, что сервис запущен: `systemctl status mysql.service`

Также доступны команды (на всякий случай):
- `systemctl start mysql.service`
- `systemctl restart mysql.service`
- `systemctl stop mysql.service`

### Установка PHP 8.1

Выполнить следующие команды:
```
sudo apt install php8.1-fpm
```

```
sudo apt install php8.1-common php8.1-mysql php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-imagick php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-redis php8.1-intl -y
```

Проверить правильность установки: `php -v`. В консоли будет выведена информация о текущей версии php. 

В случае, если несколько версий php установлено на сервере, попробовать команду: `php8.1 -v`.

### Установка Composer ([ссылка на статью: Шаг 2](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04-ru))

```
cd ~

curl -sS https://getcomposer.org/installer -o composer-setup.php

php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

composer
```

### Установка Nginx ([ссылка на статью](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04-ru))

Важно: Nginx должен смотреть на каталог проекта public (указывается в строке `root /var/www/html/gazpromneft-supply-helper/public;`)

### Добавить проект на сервер

Скопировать проект в каталог `/var/www/html/gazpromneft-supply-helper` любым возможным способом, например:
- FileZilla
- scp command ([документация](https://linuxize.com/post/how-to-use-scp-command-to-securely-transfer-files/))

### Запуск проекта Laravel

1. Перейти в каталог с проектом: `cd /var/www/html/gazpromneft-supply-helper`
2. Установить необходимые пакеты через composer, в случае отсутствия каталога `vendor`: `composer install` или `composer install --ignore-platform-reqs`
3. Создать копию файла `.env.example` с новым названием `.env`: `cp .env.example .env`
4. Сгенерировать ключ приложения: `php artisan key:generate`
5. Внести правки в `.env` файл: `nano .env` и изменить: 
- Название приложения:
```
APP_NAME="Интерактивный помощник"
```
- Подключение к базе данных (использовать название БД, имя пользователя и пароль, которые были указаны при установке и настройке MySQL):
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=gpn
DB_USERNAME=gpn_user
DB_PASSWORD=rvn8giBT
```
- SMTP для отправки почты:
```
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=SSL
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

4. `php artisan storage:link`
5. `php artisan optimize` (выполняется после любых изменений файла `.env`)
6. `php artisan migrate --seed` (запуск миграций базы данных и заполнения данными: пользователь-админ и первоначальные настройки). 
В случае, если необходимо стереть базу данных полностью, можно выполнить команду `php artisan migrate:fresh --seed`.

Данные для пользователя-админа для входа на веб-портал:
```
Email: admin@admin
Пароль: password
```

В проекте есть доступ к базе данных через adminer. Для входа используются данные от базы данных
```
http://localhost/adminer-Kwma4UrPULkK0pGtc2.php

где localhost - ip-адрес сервера или доменное имя сервера
```

### Добавление css-стилей

Файл .css для добавление дополнительных стилей: `public/css/additional-style.css`

### Запуск проекта из архива

1. Выполнить установку php, mysql, nginx (если разворачивается на сервере). 
2. Скопировать архив проекта и разархивировать.
3. В каталоге проекта выполнить все пункты из блока "Запуск проекта Laravel", кроме 6 пункта (про миграции БД). Возможно, необходимо удалить каталог `vendor`, и установить заново (пункт 2: `composer install`). Файл `.env` в архиве уже присутствует, поэтому можно редактировать его, указав подключение к базе данных MySQL, и SMTP для почты.
4. Базу данных заполнить из дампа БД - файл `gpn_dump.sql`. (`mysql -u root -p gpn < gpn_dump.sql`, где `root` - пользователь у которого есть доступ к базе данных, `gpn` - название базы данных, `gpn_dump.sql` - название файла с дампом БД).