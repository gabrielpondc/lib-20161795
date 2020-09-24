import pymysql
import jieba
import re
import konlpy
from konlpy.tag import Kkma
from collections import Counter
# encoding: utf-8
conn = pymysql.connect( # 创建数据库连接
    host='gujiakai.softether.net', # 要连接的数据库所在主机ip
    user='root', # 数据库登录用户名
    password='gjk19961226', # 登录用户密码
   database='library', # 连接的数据库名，也可以后续通过cursor.execture('user test_db')指定
    charset='utf8mb4' # 编码，注意不能写成utf-8
)

t=Kkma()
cursor = conn.cursor()
i = int(str(50000)+input("도서번호 뒤3번 입력하시오:"))
print(str(i))
cursor.execute("DELETE from tags where book_id=%s",i)
cursor.execute("select introduction from book_info where book_id=%s",i)
res=cursor.fetchall()
cut_words=""
res=str(res)
nouns = t.nouns(res)
cut_words=""
for con in nouns:
    scon=str(con)
    print(str(i),scon)
    cursor.execute("INSERT INTO tags (book_id,tag) VALUES('%s','%s')" % (str(i),scon))
conn.commit()    


