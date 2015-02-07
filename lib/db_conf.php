<?hh

const string DB_HOST = 'localhost';
const string DB_NAME = 'rsvp';
const string DB_USER = 'root';
const string DB_PASS = '';

/* The authentication system is not particularly secure, notably THESE WILL BE
 * STORED IN A COOKIE AND SENT IN THE CLEAR. Don't use something particularly
 * valuable. */
const string ADMIN_PASS = 'admin';
const string RSVP_PASS = 'password';
