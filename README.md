Library
=======

Master: [![Build Status](https://travis-ci.org/PulsarV/Library.svg?branch=master)](https://travis-ci.org/PulsarV/Library) Dev: [![Build Status](https://travis-ci.org/PulsarV/Library.svg?branch=dev)](https://travis-ci.org/PulsarV/Library)

Master: [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PulsarV/Library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PulsarV/Library/?branch=master) Dev: [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PulsarV/Library/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/PulsarV/Library/?branch=dev)


### Installation
Project requires installed npm & RabbitMQ server.

For setup project use simple configuration script ```./config.sh``` in project directory (run ```chmod +x ./config.sh``` before)

For using RabbitMQ run ```./bin/console rabbitmq:consumer change_category``` in project directory

### Console commands

Move all books from one catogory to another
```
./bin/console library:change:category
```
Delete all books that have the specified tag
```
./bin/console library:remove:books:by-tag
```
Delete category that have the specified name         
```
./bin/console library:remove:category
```

### API
Return all books that name is similar to "Name"
```
/api/book/Name
```    
Return all books that have the specified tags
```
/api/book/tag/Tag1,Tag2
```
Return all books that contain in specified category
```
/api/book/category/Category1
```
Return all books that contain in specified category and have the specified tag
```
/api/book/category/Category1/tag/Tag1
```              