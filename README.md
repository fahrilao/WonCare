## Remove Temp Chunked Uploads

```bash
php artisan uploads:clean-chunks
```

OR

```bash
php artisan uploads:clean-chunks --hours=2
```

OR

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Add the above line to your crontab to run the command every minute.
