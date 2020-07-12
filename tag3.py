#-*- coding:utf-8 -*-
import sys
import pymysql
import re
import konlpy
from konlpy.tag import Kkma
from collections import Counter
import os
#需要用sys库来接受php传过来的两个参数$var和$var1

data=open(r"C:\Users\GabrielPondC\Desktop\web\library\1.txt","w")
conn = pymysql.connect( # 创建数据库连接
    host='gujiakai.softether.net', # 要连接的数据库所在主机ip
    user='root', # 数据库登录用户名
    password='gjk19961226', # 登录用户密码
   database='library', # 连接的数据库名，也可以后续通过cursor.execture('user test_db')指定
    charset='utf8mb4' # 编码，注意不能写成utf-8
)
cursor = conn.cursor()
def ceshi(i):
    conn = pymysql.connect( # 创建数据库连接
    host='gujiakai.softether.net', # 要连接的数据库所在主机ip
    user='root', # 数据库登录用户名
    password='gjk19961226', # 登录用户密码
   database='library', # 连接的数据库名，也可以后续通过cursor.execture('user test_db')指定
    charset='utf8mb4' # 编码，注意不能写成utf-8
)
    cursor = conn.cursor()
    t = Kkma()
    cursor.execute("select introduction from book_info where book_id=%s",i)
    res=cursor.fetchall()
    cut_words=""
    res=str(res)
    nouns = t.nouns(res)
    cut_words=""
    return nouns
if __name__ == "__main__":
    data=open(r"C:\Users\GabrielPondC\Desktop\web\library\1.txt","w",encoding='utf-8')
    res = ceshi(50000014)
    for con in res:
        print(con)
        data.write(con)
data.close()

