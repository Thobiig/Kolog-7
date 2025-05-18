// app/db.js
import mysql from 'mysql2/promise';

export const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: 'eliasSQL7',
  database: 'kolog7',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});
