Чтобы получить список валют принудительно
-------------------

```
php yii currency/get-currencies
```

Чтобы валюты обновлялись каждый день прописать в crontab
-------------------

```
* * * * * php /path/to/yii yii schedule/run --scheduleFile=@console/config/schedule.php 1>> /dev/null 2>&1
```

Чтобы создать администратора
-------------------

```
php yii admin/create "username" "email" "password"
```
