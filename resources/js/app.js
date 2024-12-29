const express = require('express');
const mysql = require('mysql2');
const bcrypt = require('bcryptjs');
const app = express();

// Подключение к базе данных MySQL
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Ваш логин для MySQL
  password: 'your_password', // Ваш пароль для MySQL
  database: 'your_database' // Имя вашей базы данных
});

// Подключаемся к базе данных
connection.connect((err) => {
  if (err) {
    console.error('Ошибка подключения к базе данных:', err);
  } else {
    console.log('Подключение к базе данных успешно!');
  }
});

// Функция для аутентификации пользователя
function authenticateUser(email, password, callback) {
  const query = 'SELECT * FROM users WHERE email = ?';
  
  connection.query(query, [email], (err, results) => {
    if (err) {
      callback('Ошибка при поиске пользователя: ' + err);
      return;
    }

    if (results.length === 0) {
      callback('Пользователь не найден');
      return;
    }

    const user = results[0];

    // Проверяем хэшированный пароль
    bcrypt.compare(password, user.password, (err, isMatch) => {
      if (err) {
        callback('Ошибка при сравнении пароля: ' + err);
        return;
      }

      if (isMatch) {
        callback(null, 'Пароль верный, пользователь аутентифицирован');
      } else {
        callback('Неверный пароль');
      }
    });
  });
}

// Маршрут для логина
app.post('/login', express.json(), (req, res) => {
  const { email, password } = req.body;

  authenticateUser(email, password, (err, message) => {
    if (err) {
      res.status(400).send(err);
    } else {
      res.status(200).send(message);
    }
  });
});

// Запуск сервера
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Сервер запущен на порту ${PORT}`);
});
