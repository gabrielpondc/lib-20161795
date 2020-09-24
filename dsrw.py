import pymysql
import re
from collections import Counter
import datetime
import threading
# encoding: utf-8
conn = pymysql.connect( # 创建数据库连接
    host='gujiakai.softether.net', # 要连接的数据库所在主机ip
    user='root', # 数据库登录用户名
    password='gjk19961226', # 登录用户密码
   database='virus', # 连接的数据库名，也可以后续通过cursor.execture('user test_db')指定
    charset='utf8mb4' # 编码，注意不能写成utf-8
)
now_time = datetime.datetime.now()
cursor = conn.cursor()
cursor.execute("select kr.dia-(b.dia+b.cur+b.de) ondia,kr.dia-(kr.de+kr.cur),kr.de,kr.cur from (SELECT * FROM krhistory WHERE DATEDIFF(time,NOW())=-2) b,kr")
res=cursor.fetchall()
for con in res:
  newdia=int(con[0])
  dia=int(con[1])
  de=int(con[2])
  cur=int(con[3])
last_time = now_time + datetime.timedelta(days=-1)
last_year = last_time.date().year
last_month = last_time.date().month
last_day = last_time.date().day
last_time = datetime.datetime.strptime(str(last_year)+"-"+str(last_month)+"-"+str(last_day), "%Y-%m-%d")
last=str(last_time).replace(' 00:00:00','')
print(last)
#cursor.execute("INSERT INTO krhistory (time,sus,dia,cur,de) VALUES('%s','%s','%s','%s','%s')" % (last,newdia,dia,cur,de))
#conn.commit()
