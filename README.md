# 🎓 Farpost Project — Symfony Backend

## 📋 Project Overview  
Это **бэкэнд-приложение**, разработанное в рамках **Farpost Project School**.Проект построен на **Symfony 7** и предоставляет **REST API** для взаимодействия с фронтендом.Основная цель — получить практический опыт в веб-разработке, управлении базами данных и проектировании API.

## 💡Project Idea
Цель проекта — создать стандартный **REST API backend** для взаимодействия с фронтендом.
Backend предоставляет необходимые эндпоинты для сайта с отключениями электричества/света/газа и.т.д.

## 🧠 Structure & Logic
Проект организован по стандартной архитектуре Symfony с использованием **Doctrine ORM** для управления базой данных **PostgreSQL**.
- Слой данных: Сущности и репозитории для управления данными.
- Слой бизнес-логики: Сервисы для обработки логики приложения.
- Контроллеры (API Layer):
  - GET /api/blackouts/active — получить список текущих (за последний час) отключений 
  - POST /api/blackouts — добавить новое отключение
  - GET /api/blackouts/stats/{period} — статистика отключений за период (день, неделя, месяц)
  - GET /api/organizations — получить список организаций и количество домов, которые они обслуживают
- Схема таблиц:
<img width="1064" height="717" alt="image" src="https://github.com/user-attachments/assets/6e475a63-9539-4c46-975e-8574e6b778a7" />

## ⚙️ Setup & Installation
1. Склонируйте репозиторий:<br>
```
git clone git@github.com:EmotionlessDev/farpost-backend.git
cd farpost-backend
```
2. Создайте файл `.env.local` на основе `.env` и настройте параметры базы данных PostgreSQL.
3. Запустите контейнеры Docker:<br>
```
make dc-up
```
4. Накатите миграции:<br>
```
bin/console doctrine:migrations:migrate
```
5. Приложение должно быть доступно по адресу `http://localhost:8000`.

## ⚙️ Technologies  
- **PHP 8.2+**  
- **Symfony 7**  
- **Doctrine ORM**  
- **PostgreSQL**  
- **Docker / Docker Compose**  

