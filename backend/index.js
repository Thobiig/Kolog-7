const express = require('express');
const app = express();
const PORT = 3001;

app.get('/api/ping', (req, res) => {
  res.send({ message: 'pong' });
});

app.listen(PORT, () => {
  console.log(`Servidor backend escuchando en http://localhost:${PORT}`);
});
