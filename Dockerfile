FROM kubedevhub.brin.go.id/image/laravel-vania:1.7
COPY . .
RUN composer install
