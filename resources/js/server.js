const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

app.use(bodyParser.json());

app.post('/api/products', (req, res) => {
  const newProduct = req.body;
  // Добавление товара в базу данных
  res.status(201).json(newProduct);
});

app.post('/api/categories', (req, res) => {
  const newCategory = req.body;
  // Добавление категории в базу данных
  res.status(201).json(newCategory);
});

app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
