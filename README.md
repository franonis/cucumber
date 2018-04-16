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

sudo chmod -R 777 storage bootstrap/cache
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
flush privileges;
```

3. 配置nginx
```shell
# 安装nginx
yum install nginx
# 启动nginx
/etc/init.d/nginx start
```

4. 启动服务
```shell
## shell
sudo php artisan serve
open http://127.0.0.1:8000
``` 

### 开发流程
1. 建立migrations
```shell
php artisan make:migration create_table_feature_definitions
## 编辑CreateTableFeatureDefinitions

php artisan make:migration create_table_protein_features
### 编辑 CreateTableProteinFeatures

php artisan make:migration createGeneToUniprotTable
### 编辑 CreateGeneToUniprotTable

// 初次迁移
php artisan migrate

// 删除表后再迁移
php artisan migrate:refresh
```


### 导入数据
```sql
LOAD DATA LOCAL INFILE "feature_definitions" INTO TABLE feature_definitions FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n';
LOAD DATA LOCAL INFILE "Protein_features" INTO TABLE protein_features FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n';
LOAD DATA LOCAL INFILE 'uniprot.txt' INTO TABLE gene_to_uniprot;
```


### 注意事项
1. 生产环境下需要修改复杂的MySQL的密码
```sql
### SQL
create database alt_iso;
set global validate_password_policy=1;
set global validate_password_length=8;
grant all on alt_iso.* to '*****'@'127.0.0.1' identified by '********';
flush privileges;
````

2. 修改.env文件，设置 `APP_DEBUG=false` 并修改MySQL配置