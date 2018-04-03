# Alternative Isoforms Database of Cucumber

### 安装

1. 下载源码
```shell
## shell
git clone https://github.com/liub1993/cucumber.git
cd cucumber
composer install

// 安装cnpm
brew install npm
npm install -g cnpm --registry=https://registry.npm.taobao.org
cnpm install

php artisan key:generate
```

2. 配置MySQL
```sql
### sql
create database alt_iso;
### 如遇到安全问题时执行下面的SQL
set global validate_password_policy=0;
set global validate_password_length=1;
### @@@@

### 测试环境，生产上线后修改为复杂的密码
### 设置 validate_password_length=8 validate_password_policy=1
### 修改 .env
grant all on alt_iso.* to 'test'@'%' identified by '111111';
```

3. 启动服务
```shell
## shell
sudo php artisan serve
open http://127.0.0.1:8000
``` 
