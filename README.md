# DRP onschool web project

## Introduction
**A simple Web project we write in PHP with MVC architecture (UI/UX sucks btw).**

## Architect and utility
### Architect
- Model View Control

### Technology 
- pure PHP, auto load with psr-4
- Mysql with pdo_mysql 
- Redis caching with predis-redis
- Web containerization with docker


### Main features
- Manage 4 entities: Users | Recipes | Ingredients | Ingredient Nutritions
- CRUD with base security and validation.
- View pagination.
- Admin page: Update | Delete | Active/Deactive | Insert 
- A very basic BMI calculator

## How to start 
We did containerize our web, all you have to do is start docker and run this command ```docker-compose up -d``` if 
you're already installed docker, or else go install docker and run that command, simply enough. 

[![web demo](showcase/img.png)](https://youtu.be/GMnn82IMSHM)