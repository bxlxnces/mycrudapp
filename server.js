const express = require('express');
const bodyParser = require('body-parser');
const authRoutes = require('./routes/authRoutes');
const authenticate = require('./middleware/authMiddleware');
const protectedRouteController = require('./controllers/protectedRouteController');

const app = express();

// Middleware для парсинга JSON в теле запроса
app.use(bodyParser.json());

// Маршруты для аутентификации
app.use('/auth', authRoutes);

// Защищенные маршруты
app.get('/protected-route', authenticate, protectedRouteController.getProtectedData);

// Запуск сервера
const port = 5000;
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
