CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "phone" varchar,
  "marketing_opt_in" tinyint(1) not null default '0',
  "customer_notes" text,
  "is_admin" tinyint(1) not null default '0'
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "products"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "short_description" text,
  "long_description" text,
  "price" numeric not null,
  "sale_price" numeric,
  "sku" varchar,
  "stock_quantity" integer not null default '0',
  "type" varchar not null default 'gadget',
  "condition" varchar not null default 'new',
  "video_url" varchar,
  "is_visible" tinyint(1) not null default '1',
  "is_featured" tinyint(1) not null default '0',
  "is_new" tinyint(1) not null default '0',
  "colors" text,
  "specifications" text,
  "brand_id" integer,
  "seo_title" varchar,
  "seo_description" varchar,
  "seo_keywords" text,
  "created_at" datetime,
  "updated_at" datetime,
  "delivery_info" text,
  "return_policy" text,
  "main_image_path" varchar,
  "gallery_image_paths" text,
  foreign key("brand_id") references "brands"("id") on delete set null
);
CREATE INDEX "products_name_index" on "products"("name");
CREATE UNIQUE INDEX "products_slug_unique" on "products"("slug");
CREATE INDEX "products_price_index" on "products"("price");
CREATE UNIQUE INDEX "products_sku_unique" on "products"("sku");
CREATE INDEX "products_is_featured_index" on "products"("is_featured");
CREATE TABLE IF NOT EXISTS "reviews"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "user_id" integer not null,
  "rating" integer not null,
  "content" text not null,
  "created_at" datetime,
  "updated_at" datetime,
  "is_approved" tinyint(1) not null default '0',
  "title" varchar,
  foreign key("product_id") references "products"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "parent_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  "seo_title" varchar,
  "seo_description" text,
  "seo_keywords" text,
  "image_path" varchar,
  "banner_path" varchar,
  "is_trending" tinyint(1) not null default '0',
  foreign key("parent_id") references "categories"("id") on delete cascade
);
CREATE UNIQUE INDEX "categories_slug_unique" on "categories"("slug");
CREATE TABLE IF NOT EXISTS "category_product"(
  "category_id" integer not null,
  "product_id" integer not null,
  foreign key("category_id") references "categories"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade,
  primary key("category_id", "product_id")
);
CREATE TABLE IF NOT EXISTS "media"(
  "id" integer primary key autoincrement not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  "uuid" varchar,
  "collection_name" varchar not null,
  "name" varchar not null,
  "file_name" varchar not null,
  "mime_type" varchar,
  "disk" varchar not null,
  "conversions_disk" varchar,
  "size" integer not null,
  "manipulations" text not null,
  "custom_properties" text not null,
  "generated_conversions" text not null,
  "responsive_images" text not null,
  "order_column" integer,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "media_model_type_model_id_index" on "media"(
  "model_type",
  "model_id"
);
CREATE UNIQUE INDEX "media_uuid_unique" on "media"("uuid");
CREATE INDEX "media_order_column_index" on "media"("order_column");
CREATE TABLE IF NOT EXISTS "tags"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  "seo_title" varchar,
  "seo_description" text,
  "seo_keywords" text
);
CREATE UNIQUE INDEX "tags_name_unique" on "tags"("name");
CREATE UNIQUE INDEX "tags_slug_unique" on "tags"("slug");
CREATE TABLE IF NOT EXISTS "post_tag"(
  "id" integer primary key autoincrement not null,
  "post_id" integer not null,
  "tag_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("post_id") references "posts"("id") on delete cascade,
  foreign key("tag_id") references "tags"("id") on delete cascade
);
CREATE UNIQUE INDEX "post_tag_post_id_tag_id_unique" on "post_tag"(
  "post_id",
  "tag_id"
);
CREATE TABLE IF NOT EXISTS "discounts"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "type" varchar not null,
  "value" numeric not null,
  "min_amount" numeric,
  "max_uses" integer,
  "uses" integer not null default '0',
  "starts_at" datetime,
  "expires_at" datetime,
  "is_active" tinyint(1) not null default '0',
  "applies_to" varchar not null default 'all',
  "product_ids" text,
  "category_ids" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "discounts_code_unique" on "discounts"("code");
CREATE TABLE IF NOT EXISTS "banners"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "url" varchar,
  "order" integer not null default '0',
  "is_active" tinyint(1) not null default '0',
  "starts_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  "image_path" varchar
);
CREATE TABLE IF NOT EXISTS "wishlists"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "product_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE UNIQUE INDEX "wishlists_user_id_product_id_unique" on "wishlists"(
  "user_id",
  "product_id"
);
CREATE TABLE IF NOT EXISTS "brands"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "description" text,
  "created_at" datetime,
  "updated_at" datetime,
  "logo_path" varchar,
  "seo_title" varchar,
  "seo_description" text,
  "seo_keywords" text
);
CREATE UNIQUE INDEX "brands_name_unique" on "brands"("name");
CREATE UNIQUE INDEX "brands_slug_unique" on "brands"("slug");
CREATE TABLE IF NOT EXISTS "testimonials"(
  "id" integer primary key autoincrement not null,
  "author_name" varchar not null,
  "author_title" varchar,
  "content" text not null,
  "rating" integer,
  "is_published" tinyint(1) not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  "image_path" varchar
);
CREATE TABLE IF NOT EXISTS "main_sliders"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "subtitle" varchar not null,
  "image_path" varchar not null,
  "button_text" varchar,
  "button_link" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "image_path_mobile" varchar
);
CREATE TABLE IF NOT EXISTS "top_categories"(
  "id" integer primary key autoincrement not null,
  "category_id" integer not null,
  "sort_order" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("category_id") references "categories"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "popular_categories"(
  "id" integer primary key autoincrement not null,
  "category_id" integer not null,
  "sort_order" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("category_id") references "categories"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "deal_of_the_days"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "deal_price" numeric not null,
  "end_date" date not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "featured_products"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "order" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "offers"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "subtitle" varchar,
  "image_path" varchar not null,
  "cta_text" varchar not null,
  "cta_link" varchar not null,
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "settings"(
  "id" integer primary key autoincrement not null,
  "key" varchar not null,
  "value" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "settings_key_unique" on "settings"("key");
CREATE TABLE IF NOT EXISTS "billing_addresses"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "first_name" varchar not null,
  "last_name" varchar not null,
  "address" varchar not null,
  "apartment" varchar,
  "city" varchar not null,
  "state" varchar not null,
  "country" varchar not null,
  "neighborhood" varchar not null,
  "email" varchar not null,
  "phone" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "shipping_addresses"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "first_name" varchar not null,
  "last_name" varchar not null,
  "address" varchar not null,
  "city" varchar not null,
  "state" varchar not null,
  "country" varchar not null,
  "neighborhood" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "order_items"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "product_id" integer,
  "name" varchar not null,
  "quantity" integer not null,
  "price" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "order_status_histories"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "status" varchar not null,
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "shipping_zones"(
  "id" integer primary key autoincrement not null,
  "municipality" varchar not null,
  "neighborhood" varchar not null,
  "price" numeric not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "shipping_zones_municipality_neighborhood_unique" on "shipping_zones"(
  "municipality",
  "neighborhood"
);
CREATE TABLE IF NOT EXISTS "addresses"(
  "id" integer primary key autoincrement not null,
  "order_id" integer,
  "user_id" integer,
  "first_name" varchar not null,
  "last_name" varchar not null,
  "phone" varchar,
  "email" varchar,
  "address" varchar not null,
  "apartment" varchar,
  "city" varchar not null,
  "state" varchar not null,
  "country" varchar not null,
  "neighborhood" varchar,
  "type" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "orders"(
  "id" integer primary key autoincrement not null,
  "user_id" integer,
  "total" numeric not null,
  "subtotal" numeric not null,
  "shipping_cost" numeric not null,
  "payment_method" varchar not null,
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  "uuid" varchar,
  foreign key("user_id") references users("id") on delete set null on update no action
);
CREATE UNIQUE INDEX "orders_uuid_unique" on "orders"("uuid");
CREATE TABLE IF NOT EXISTS "authors"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "email" varchar not null,
  "github" varchar,
  "bio" text,
  "avatar" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "authors_slug_unique" on "authors"("slug");
CREATE UNIQUE INDEX "authors_email_unique" on "authors"("email");
CREATE TABLE IF NOT EXISTS "posts"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "slug" varchar not null,
  "content" text not null,
  "excerpt" text,
  "published_at" datetime,
  "user_id" integer not null,
  "seo_title" varchar,
  "seo_description" text,
  "seo_keywords" text,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  "image_path" varchar,
  "is_published" tinyint(1) not null default('0'),
  "author_id" integer,
  "main_image_path" varchar,
  foreign key("user_id") references users("id") on delete cascade on update no action,
  foreign key("author_id") references "authors"("id") on delete set null
);
CREATE UNIQUE INDEX "posts_slug_unique" on "posts"("slug");

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_07_25_000000_create_products_table',1);
INSERT INTO migrations VALUES(5,'2025_11_17_021448_create_reviews_table',1);
INSERT INTO migrations VALUES(6,'2025_11_21_195223_create_categories_table',1);
INSERT INTO migrations VALUES(7,'2025_11_22_231017_add_seo_and_image_to_categories_table',1);
INSERT INTO migrations VALUES(8,'2025_11_25_182417_create_media_table',1);
INSERT INTO migrations VALUES(9,'2025_11_25_185908_create_posts_table',1);
INSERT INTO migrations VALUES(10,'2025_11_25_185932_create_tags_table',1);
INSERT INTO migrations VALUES(11,'2025_11_25_185953_create_post_tag_table',1);
INSERT INTO migrations VALUES(12,'2025_11_25_194521_create_discounts_table',1);
INSERT INTO migrations VALUES(13,'2025_11_25_195109_create_banners_table',1);
INSERT INTO migrations VALUES(14,'2025_11_25_195611_create_wishlists_table',1);
INSERT INTO migrations VALUES(15,'2025_11_25_200141_add_crm_fields_to_users_table',1);
INSERT INTO migrations VALUES(16,'2025_11_25_231159_create_brands_table',1);
INSERT INTO migrations VALUES(17,'2025_11_25_231806_create_testimonials_table',1);
INSERT INTO migrations VALUES(18,'2025_11_26_000350_add_is_approved_to_reviews_table',1);
INSERT INTO migrations VALUES(19,'2025_11_27_175711_remove_image_from_categories_table',1);
INSERT INTO migrations VALUES(20,'2025_11_27_175905_remove_logo_path_from_brands_table',1);
INSERT INTO migrations VALUES(21,'2025_12_21_193040_add_image_path_to_banners_table',1);
INSERT INTO migrations VALUES(22,'2025_12_21_193940_add_image_path_to_categories_table',1);
INSERT INTO migrations VALUES(23,'2025_12_21_194231_add_logo_path_to_brands_table',1);
INSERT INTO migrations VALUES(24,'2025_12_21_194548_add_image_path_to_posts_table',1);
INSERT INTO migrations VALUES(25,'2025_12_21_202322_add_image_path_to_testimonials_table',1);
INSERT INTO migrations VALUES(26,'2025_12_22_112627_add_banner_path_to_categories_table',1);
INSERT INTO migrations VALUES(27,'2025_12_22_114917_add_seo_fields_to_brands_table',1);
INSERT INTO migrations VALUES(28,'2025_12_22_115511_add_seo_fields_to_tags_table',1);
INSERT INTO migrations VALUES(29,'2025_12_24_134010_create_main_sliders_table',1);
INSERT INTO migrations VALUES(30,'2025_12_24_134241_create_top_categories_table',1);
INSERT INTO migrations VALUES(31,'2025_12_24_143212_create_popular_categories_table',1);
INSERT INTO migrations VALUES(32,'2025_12_24_143709_create_deal_of_the_days_table',1);
INSERT INTO migrations VALUES(33,'2025_12_24_143943_create_featured_products_table',1);
INSERT INTO migrations VALUES(34,'2025_12_24_154936_create_offers_table',1);
INSERT INTO migrations VALUES(35,'2025_12_26_131407_add_image_path_mobile_to_main_sliders_table',1);
INSERT INTO migrations VALUES(36,'2025_12_26_141157_add_image_to_top_categories_table',1);
INSERT INTO migrations VALUES(37,'2025_12_26_151925_add_is_trending_to_categories_table',1);
INSERT INTO migrations VALUES(38,'2025_12_26_225842_create_settings_table',1);
INSERT INTO migrations VALUES(39,'2025_12_27_004330_add_delivery_info_and_return_policy_to_products_table',1);
INSERT INTO migrations VALUES(40,'2025_12_27_125222_add_title_to_reviews_table',1);
INSERT INTO migrations VALUES(41,'2025_12_28_170639_add_is_published_to_posts_table',1);
INSERT INTO migrations VALUES(42,'2025_12_29_000000_add_is_admin_to_users_table',1);
INSERT INTO migrations VALUES(43,'2026_01_09_195611_drop_orphan_order_tables',1);
INSERT INTO migrations VALUES(44,'2026_01_09_195612_create_orders_system_tables',1);
INSERT INTO migrations VALUES(45,'2026_01_13_143301_create_shipping_zones_table',1);
INSERT INTO migrations VALUES(46,'2026_01_14_000000_remove_status_from_orders_table',1);
INSERT INTO migrations VALUES(47,'2026_01_14_104333_add_uuid_to_orders_table',1);
INSERT INTO migrations VALUES(48,'2026_01_14_152135_update_order_price_columns_to_decimal',1);
INSERT INTO migrations VALUES(49,'2026_01_14_183245_create_addresses_table',1);
INSERT INTO migrations VALUES(50,'2026_01_15_105056_make_user_id_nullable_in_orders_table',1);
INSERT INTO migrations VALUES(51,'2026_01_16_112315_create_authors_table',1);
INSERT INTO migrations VALUES(52,'2026_01_16_112811_add_author_id_to_posts_table',1);
INSERT INTO migrations VALUES(53,'2026_01_16_133709_remove_image_from_top_categories_table',1);
INSERT INTO migrations VALUES(54,'2026_01_16_133857_rename_image_to_image_path_in_offers_table',1);
INSERT INTO migrations VALUES(55,'2026_01_16_143301_add_main_image_path_to_posts_table',1);
INSERT INTO migrations VALUES(56,'2026_01_16_165846_add_image_fields_to_products_table',1);
