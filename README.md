# apiPedidos

.htaccess

Options All -Indexes

Options -MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
