Сделано на основе Yii2, шаблон basic.

# Установка
Клонировать репозиторий, указать в настройках доступ к база данных, запустить миграцию.

'DocumentRoot' в конфиге виртуального хоста должен указать на папку web.

# Настройки
Путь для файла с логами и регулярное выражения для их чтения указан в файле basic/config/params.php, как параметры как параметры 'log_file' и 'log_parse_reg' соответственно.

Параметр 'log_file'  по по-умолчанию указывает на файл logs/access.log.

Доступ к базе данных прописан в basic/config/db.php.

# Cron 

Команда для чтения лога запускается через basic/yii parse-log. 

# API 

## Базовое использование
Получить логи через Api в формате JSON:
```
curl -i -g --user 100token: "http://gds/api"
```

**где:**

	http://gds - имя домена, где развернут сайт

	100token - 'accessToken' пользователя, по которому мы его авторизуем 

## Фильтрация логов
Если нужно отфильтровать логи по интервалу дат или/и по имени хоста, нужно добавить к url запроса параметр 'search' c подпараметрами.
```
curl -i -g --user 100token: "http://gds/api?search[begin]=2017-01-19&search[end]=2017-01-21&search[host]=127"
```

подпараметры в параметре 'search':

	'begin' - начало временного интервала
	'end' - конец временного интервала
	'host' - c какой строки должно начинаться имя хоста

*Примечание: для получения логов за один день достаточно указать его в подпараметрах 'begin' и 'end'.*
