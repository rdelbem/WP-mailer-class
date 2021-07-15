## Simple WordPress Mailer class

The intention of this snippet is to facilitate the use of wp_mail native function.
Normally, when using, wp_mail, some parameters are required in order for it to work: headers, subject, body etc.

If all you have is the user id, you will need to use other WordPress function to get the email and, only then, pass it to wp_mail. While, coding a plugin or a theme, this will require a different file and class, as calling all this wp functions will, most certanly, make a mess in your code.

However, if you use WP_mailer_class, you only need to provide ONE relevant receiver data, id OR email. See the examples:

Here, only id is provided

```php
$send_mail = new WP_mailer_class( 1, false, 'Amazing subject!', 'Amazing message!' );
```

Here, only e-mail is provided

```php
$send_mail = new WP_mailer_class( false, 'youruser@mail.com', 'Amazing subject!', 'Amazing message!' );
```
