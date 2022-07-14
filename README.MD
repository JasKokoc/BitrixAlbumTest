Докер-окружение DS
====================
Предназначено для запуска проекта на локальной машине в среде Linux/Docker.


Иниицализация:
================
После клонирования репозитория
```
git submodule init
git submodule update
cd docker
./up.sh
```

подождать, пока запустится, затем обновим бд из репозитория 

```
./dctl.sh db renew
```

и установим composer-зависимости

```
./dctl.sh run composer install
```
Скачается и применится последний после этого проект можно увидеть по адресу http://localhost

По-умолчанию окружение ожидает подключений по 80 порту. Этот порт не должны использовать иные приложения.


Вход в админку
=================
http://localhost/bitrix
```
Логин: admin
Пароль: adminadmin
```

Миграции
==================
```
docker/dctl.sh mg                   #выводит список всех команд миграций
docker/dctl.sh mg add               #создаёт миграцию
docker/dctl.sh mg create            #создаёт миграцию (alias для add)
docker/dctl.sh mg up                #применяет миграции
docker/dctl.sh mg up 3              #применяет 3 новых миграции
docker/dctl.sh mg down              #делает down последней применённой миграции
docker/dctl.sh mg down 3            #делает down последним 3-ём применённым миграциям
docker/dctl.sh mg ls                #выводит список всех миграций
docker/dctl.sh mg ls --new          #выводит список всех новых миграций
docker/dctl.sh mg ls --installed    #выводит список всех применённых миграций
docker/dctl.sh mg redo name         #переприменяет миграцию
docker/dctl.sh mg refresh name      #переприменяет миграцию
docker/dctl.sh mg downup name       #переприменяет миграцию
docker/dctl.sh mg down-up name      #переприменяет миграцию
```


Запуск cs_fixer для фикса кода
=============
```
./php_cs_fixer.sh #проверка репозитория
./php_cs_fixer.sh fix #автоматическое исправление ошибок
```

При разворачивании на новом проекте заменить значение переменной по-умолчанию в файле .php_cs.



