#!/bin/bash/
mysqldump --user=vih --password=qdq65txp --host=mysql.vih.dk vih > /home/vih/backup/mysql/vih.sql
tar -zcvf /home/vih/backup/mysql/vih_sql.tar.gz /home/vih/backup/mysql/vih.sql
date | mutt -s "vih mysql backup" -a /home/vih/backup/mysql/vih_sql.tar.gz lars@vih.dk
