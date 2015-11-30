if [ -d "cleaner" ]; then
  php cleaner/bin/composer-cleaner
else
  composer create-project dg/composer-cleaner cleaner v0.2
  php cleaner/bin/composer-cleaner
fi