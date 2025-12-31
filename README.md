# TrustFactory Assignment
Simple ecommerce cart functionality appplication.

## Database
### users
* `id`
* `name`
* `email`
* `passowrd`
* `role`
* `email_verified_at`
* `remember_token`
* `created_at`
* `updated_at`
### products
* `id`
* `name`
* `description`
* `price`
* `stock_quantity`
* `created_at`
* `updated_at`
### product_images
* `id`
* `product_id`
* `image_path`
* `created_at`
* `updated_at`
### cart_items
* `id`
* `product_id`
* `user_id`
* `quantity`
* `created_at`
* `updated_at`

## User Roles
* `admin`
* `user`
