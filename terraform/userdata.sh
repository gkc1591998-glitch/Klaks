#!/bin/bash
set -x

# Update & Install Dependencies
apt-get update
apt-get install -y apache2 php libapache2-mod-php php-mysql php-cli php-curl php-gd php-mbstring php-xml php-zip unzip ffmpeg git awscli certbot python3-certbot-apache

# Enable Apache Modules
a2enmod rewrite ssl

# Variables
DOMAIN_NAME="${domain_name}"
S3_BUCKET="${s3_bucket}"
DB_HOSTNAME="${db_hostname}"
DB_USERNAME="${db_username}"
DB_PASSWORD="${db_password}"
DB_NAME="${db_name}"

# Configure Apache
echo "ServerName $DOMAIN_NAME" >> /etc/apache2/apache2.conf

cat <<EOF > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    ServerName $DOMAIN_NAME
    
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \$\{APACHE_LOG_DIR\}/error.log
    CustomLog \$\{APACHE_LOG_DIR\}/access.log combined
</VirtualHost>
EOF

systemctl restart apache2

# Prepare Web Directory
rm -rf /var/www/html/*
echo "<h1>Site is deploying... please wait.</h1>" > /var/www/html/index.php

# Create Setup Script (for manual or delayed execution)
cat <<EOS > /root/deploy_app.sh
#!/bin/bash
echo "Syncing files from S3..."
aws s3 sync s3://$S3_BUCKET/ /var/www/html/

echo "Configuring Database..."
cd /var/www/html/application/config
# Update database.php
sed -i "s/'hostname' => '.*'/'hostname' => '$DB_HOSTNAME'/" database.php
sed -i "s/'username' => '.*'/'username' => '$DB_USERNAME'/" database.php
sed -i "s/'password' => '.*'/'password' => '$DB_PASSWORD'/" database.php
sed -i "s/'database' => '.*'/'database' => '$DB_NAME'/" database.php

echo "Setting Permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

echo "Deployment Complete."
EOS

chmod +x /root/deploy_app.sh

# Run Deployment immediately (hope S3 is ready, if not, user can run later)
/root/deploy_app.sh >> /var/log/deploy.log 2>&1

# Certbot Placeholder (User needs to run this after DNS)
echo "#!/bin/bash" > /root/setup_ssl.sh
echo "certbot --apache -d $DOMAIN_NAME -m admin@$DOMAIN_NAME --agree-tos --non-interactive" >> /root/setup_ssl.sh
chmod +x /root/setup_ssl.sh
