# BÁO CÁO ĐỒ ÁN — WEBSITE NGHE NHẠC TRỰC TUYẾN

---

## MỤC LỤC

1. [Giới thiệu chung](#1-giới-thiệu-chung)
2. [Công nghệ sử dụng](#2-công-nghệ-sử-dụng)
3. [Cấu trúc dự án](#3-cấu-trúc-dự-án)
4. [Thiết kế cơ sở dữ liệu](#4-thiết-kế-cơ-sở-dữ-liệu)
5. [Chức năng phía người dùng (Web)](#5-chức-năng-phía-người-dùng-web)
6. [Chức năng phía quản trị (Admin)](#6-chức-năng-phía-quản-trị-admin)
7. [Hướng dẫn cài đặt & chạy dự án](#7-hướng-dẫn-cài-đặt--chạy-dự-án)
8. [Hướng dẫn sử dụng](#8-hướng-dẫn-sử-dụng)

---

## 1. GIỚI THIỆU CHUNG

Dự án là một **website nghe nhạc trực tuyến** hoàn chỉnh với hai phân hệ:

- **Phân hệ người dùng (Web)**: Đăng ký, đăng nhập, nghe nhạc, tìm kiếm, tạo playlist, yêu thích bài hát, xem podcast, bình luận tin tức, đăng ký gói VIP.
- **Phân hệ quản trị (Admin)**: Quản lý toàn bộ nội dung (bài hát, nghệ sĩ, album, thể loại, podcast, tin tức, quảng cáo), quản lý người dùng, quản lý gói đăng ký, xem thống kê & nhật ký hoạt động.

---

## 2. CÔNG NGHỆ SỬ DỤNG

| Thành phần | Công nghệ |
|---|---|
| Backend Framework | Laravel 11 (PHP 8.2+) |
| Frontend | Blade Templates + Tailwind CSS |
| Database | MySQL / MariaDB |
| Audio Player | HTML5 Audio API |
| File Upload | Laravel Storage (public disk) |
| Excel Import/Export | Maatwebsite Excel (Laravel Excel) |
| Authentication | Laravel Sanctum + Session Auth |
| Migration & Seeder | Laravel Eloquent |
| Charts | Chart.js |
| Payment Gateway | VNPAY |

---

## 3. CẤU TRÚC DỰ ÁN

```
DoAnNhom/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdController.php              # Quản lý quảng cáo (Admin)
│   │   ├── AdminDashboardController.php   # Dashboard Admin
│   │   ├── AlbumController.php            # Quản lý album (Admin)
│   │   ├── ArtistsController.php          # Quản lý nghệ sĩ (Admin)
│   │   ├── AuthController.php             # Đăng nhập / Đăng ký
│   │   ├── CategoriesController.php       # Quản lý thể loại (Admin)
│   │   ├── CommentsController.php         # Quản lý bình luận (Admin)
│   │   ├── Controller.php                 # Base controller
│   │   ├── DashboardController.php        # Dashboard người dùng
│   │   ├── FavoriteSongController.php     # Bài hát yêu thích
│   │   ├── HomeController.php             # Trang chủ người dùng
│   │   ├── ListeningHistoryController.php # Lịch sử nghe
│   │   ├── NewsController.php             # Quản lý tin tức
│   │   ├── PlanController.php             # Quản lý gói đăng ký (Admin)
│   │   ├── PlaylistController.php         # Quản lý playlist
│   │   ├── PodcastController.php          # Quản lý podcast (Admin)
│   │   ├── ProfileController.php          # Quản lý hồ sơ
│   │   ├── SongController.php             # Quản lý bài hát (Admin)
│   │   ├── SongUserLikesController.php    # Lượt thích bài hát
│   │   ├── SongViewsController.php        # Lượt xem bài hát
│   │   ├── SubscriptionController.php     # Quản lý đăng ký (Admin)
│   │   ├── UserController.php             # Quản lý người dùng (Admin)
│   │   └── Web/PlanController.php         # Đăng ký gói Web
│   ├── Models/
│   │   ├── ActivityLog.php
│   │   ├── Ad.php
│   │   ├── Album.php
│   │   ├── Artist.php
│   │   ├── Categories.php
│   │   ├── Comment.php
│   │   ├── ListeningHistory.php
│   │   ├── News.php
│   │   ├── Plan.php
│   │   ├── Playlist.php
│   │   ├── Podcast.php
│   │   ├── Song.php
│   │   ├── SongUserLike.php
│   │   ├── SongView.php
│   │   ├── Subscription.php
│   │   └── User.php
│   ├── Support/
│   │   ├── AudioUpload.php                # Xử lý upload file audio
│   │   └── ImageUpload.php                # Xử lý upload hình ảnh
│   ├── Exports/
│   │   └── SongsExport.php                # Export bài hát ra Excel
│   └── Imports/
│       └── SongsImport.php                # Import bài hát từ Excel
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── ListeningHistorySeeder.php     # Seed dữ liệu lịch sử nghe
│   │   └── ...
├── resources/
│   ├── views/
│   │   ├── admin/                         # Giao diện quản trị
│   │   │   ├── ads/
│   │   │   ├── albums/
│   │   │   ├── artists/
│   │   │   ├── categories/
│   │   │   ├── comments/
│   │   │   ├── layouts/
│   │   │   ├── news/
│   │   │   ├── partials/
│   │   │   ├── podcasts/
│   │   │   ├── songs/
│   │   │   ├── subscriptions/
│   │   │   └── users/
│   │   ├── auth/                          # Login / Register
│   │   └── web/                           # Giao diện người dùng
│   └── js/
├── routes/
│   └── web.php                            # Định tuyến ứng dụng
├── storage/
│   └── app/public/                        # File upload (audio, image)
└── public/
    └── storage/                           # Symlink tới storage/app/public
```

---

## 4. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 4.1 Bảng `users` — Người dùng

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| fullname | VARCHAR(191) | Họ tên |
| email | VARCHAR(191) UNIQUE | Email đăng nhập |
| password | VARCHAR(255) | Mật khẩu (hashed) |
| role | VARCHAR(191) | Vai trò: `admin` / `user` |
| phone | VARCHAR(20) | Số điện thoại |
| address | TEXT | Địa chỉ |
| avatar | VARCHAR(191) | Đường dẫn ảnh đại diện |
| status | BOOLEAN | Trạng thái hoạt động |
| created_at / updated_at | TIMESTAMP | Thời gian tạo / cập nhật |

### 4.2 Bảng `songs` — Bài hát

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| title | VARCHAR(191) | Tên bài hát |
| artist_id | BIGINT FK → artists | Nghệ sĩ biểu diễn |
| category_id | BIGINT FK → categories | Thể loại |
| album_id | BIGINT FK → albums | Album chứa bài hát |
| audio_file | VARCHAR(191) | Đường dẫn file audio |
| thumbnail | VARCHAR(191) | Đường dẫn ảnh bìa |
| lyrics | TEXT | Lời bài hát |
| listen_count | INT DEFAULT 0 | Lượt nghe |
| status | BOOLEAN | Trạng thái hiển thị |
| is_vip | BOOLEAN | Bài hát VIP (chỉ nghe khi có subscription) |
| created_at / updated_at | TIMESTAMP | Thời gian tạo / cập nhật |

### 4.3 Bảng `artists` — Nghệ sĩ

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| name | VARCHAR(191) | Tên nghệ sĩ |
| image | VARCHAR(191) | Ảnh đại diện |
| description | TEXT | Mô tả |
| status | BOOLEAN | Trạng thái |

### 4.4 Bảng `albums` — Album

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| title | VARCHAR(191) | Tên album |
| image | VARCHAR(191) | Ảnh bìa album |
| release_year | INT | Năm phát hành |
| status | BOOLEAN | Trạng thái |

### 4.5 Bảng `categories` — Thể loại

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| name | VARCHAR(191) | Tên thể loại |
| image | VARCHAR(191) | Ảnh đại diện |
| status | BOOLEAN | Trạng thái |

### 4.6 Bảng `podcasts` — Podcast

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| title | VARCHAR(191) | Tiêu đề podcast |
| description | TEXT | Mô tả |
| audio_file | VARCHAR(191) | File audio |
| thumbnail | VARCHAR(191) | Ảnh bìa |
| duration | INT | Thời lượng (giây) |
| views | INT DEFAULT 0 | Lượt xem |
| status | BOOLEAN | Trạng thái |

### 4.7 Bảng `plans` — Gói đăng ký

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| name | VARCHAR(191) | Tên gói (VD: Premium 1 tháng) |
| duration_days | INT | Số ngày hiệu lực |
| price | DECIMAL | Giá gói (VNĐ) |
| status | BOOLEAN | Trạng thái |

### 4.8 Bảng `subscriptions` — Đăng ký gói

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Người đăng ký |
| plan_id | BIGINT FK → plans | Gói đã đăng ký |
| starts_at | TIMESTAMP | Ngày bắt đầu |
| expires_at | TIMESTAMP | Ngày hết hạn |
| status | BOOLEAN | Trạng thái kích hoạt |
| payment_method | VARCHAR(191) | Phương thức thanh toán |

### 4.9 Bảng `playlists` — Playlist

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Chủ sở hữu |
| name | VARCHAR(191) | Tên playlist |
| description | TEXT | Mô tả |

### 4.10 Bảng `playlist_song` — Quan hệ Playlist ↔ Song (Bảng trung gian)

| Cột | Kiểu | Mô tả |
|---|---|---|
| playlist_id | BIGINT FK | ID playlist |
| song_id | BIGINT FK | ID bài hát |
| created_at / updated_at | TIMESTAMP | |

### 4.11 Bảng `song_user_likes` — Bài hát yêu thích

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Người thích |
| song_id | BIGINT FK → songs | Bài hát được thích |

### 4.12 Bảng `listening_history` — Lịch sử nghe

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Người nghe |
| song_id | BIGINT FK → songs | Bài hát nghe |
| listened_seconds | INT UNSIGNED | Số giây đã nghe |
| has_counted | BOOLEAN | Đã tính vào listen_count |
| listened_at | TIMESTAMP | Thời điểm nghe |
| status | BOOLEAN | Trạng thái |

### 4.13 Bảng `news` — Tin tức

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| title | VARCHAR(191) | Tiêu đề |
| slug | VARCHAR(191) UNIQUE | URL thân thiện |
| content | TEXT | Nội dung bài viết |
| summary | TEXT | Tóm tắt |
| image | VARCHAR(191) | Ảnh minh họa |
| category | VARCHAR(191) | Danh mục tin tức |
| user_id | BIGINT FK → users | Người đăng |
| views | INT DEFAULT 0 | Lượt xem |
| status | BOOLEAN | Trạng thái |

### 4.14 Bảng `comments` — Bình luận

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Người bình luận |
| new_id | BIGINT FK → news | Bài tin tức được bình luận |
| content | TEXT | Nội dung bình luận |
| status | BOOLEAN | Trạng thái hiển thị |

### 4.15 Bảng `ads` — Quảng cáo

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| name | VARCHAR(191) | Tên quảng cáo |
| image | VARCHAR(191) | Ảnh quảng cáo |
| link_url | VARCHAR(191) | Liên kết đích |
| description | TEXT | Mô tả |
| is_active | BOOLEAN | Trạng thái hiển thị |

### 4.16 Bảng `activity_logs` — Nhật ký hoạt động

| Cột | Kiểu | Mô tả |
|---|---|---|
| id | BIGINT | Khóa chính |
| user_id | BIGINT FK → users | Người thực hiện |
| module | VARCHAR(191) | Module (Song, User, Ad...) |
| action | VARCHAR(191) | Hành động (CREATE, UPDATE, DELETE) |
| title | VARCHAR(191) | Tiêu đề đối tượng |

### Sơ đồ quan hệ

```
users (1) ────┬──── (M) subscriptions ──── (M:1) plans
              │
              ├─── (M) playlists ──┐
              │                    │
              ├─── (M) song_user_likes ── (M:1) songs (1) ──── (M:1) artists
              │                    │                          ├─── (M:1) categories
              ├─── (M) listening_history ─── (M:1) songs       └─── (M:1) albums
              │
              ├─── (M) comments ──── (M:1) news
              │
              └─── (M) activity_logs
```

---

## 5. CHỨC NĂNG PHÍA NGƯỜI DÙNG (WEB)

### 5.1 Trang chủ (`/`)

**Mô tả**: Hiển thị danh sách bài hát, podcast, nghệ sĩ nổi bật.

**Chi tiết**:
- Danh sách bài hát mới nhất, có phân trang
- Tìm kiếm bài hát theo: tên bài hát, tên nghệ sĩ, tên album, thể loại
- Bài hát VIP chỉ phát khi người dùng có subscription hoạt động
- Hiển thị quảng cáo (banner) ở các vị trí chiến lược
- Section podcast nổi bật
- Section nghệ sĩ phổ biến (top 12)

**Controller**: `HomeController@index`

**Route**: `GET /` → `HomeController@index`

### 5.2 Đăng nhập & Đăng ký (`/login`, `/register`)

**Mô tả**: Xác thực người dùng.

**Chi tiết**:
- Đăng nhập bằng email + mật khẩu
- Ghi nhớ phiên đăng nhập (remember me)
- Redirect theo role: `admin` → `/admin`, `user` → `/dashboard`
- Đăng ký: fullname, email, phone, password (có xác nhận)
- Validation đầy đủ, hiển thị lỗi inline

**Controller**: `AuthController`

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/login` | `showLogin` |
| POST | `/login` | `login` |
| GET | `/register` | `showRegister` |
| POST | `/register` | `register` |
| POST | `/logout` | `logout` |

### 5.3 Dashboard người dùng (`/dashboard`)

**Mô tả**: Trang cá nhân tổng quan của người dùng.

**Chi tiết**:
- Hiển thị thông tin tài khoản
- Thống kê cá nhân (số bài hát yêu thích, số playlist...)
- Gợi ý bài hát dựa trên lịch sử nghe

**Controller**: `DashboardController@index`

### 5.4 Quản lý hồ sơ (`/profile`)

**Mô tả**: Xem và cập nhật thông tin cá nhân.

**Chi tiết**:
- Hiển thị fullname, email, phone, address, avatar
- Chỉnh sửa và lưu thông tin

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/profile` | `ProfileController@show` |
| PATCH | `/profile` | `ProfileController@update` |

### 5.5 Bài hát yêu thích (`/favorites`)

**Mô tả**: Danh sách bài hát mà người dùng đã thích.

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/favorites` | `FavoriteSongController@index` |
| POST | `/favorites/{song}` | `FavoriteSongController@toggle` |

### 5.6 Playlist (`/playlists`)

**Mô tả**: Tạo và quản lý danh sách phát cá nhân.

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/playlists` | `PlaylistController@index` |
| POST | `/playlists` | `PlaylistController@store` |
| GET | `/playlists/{playlist}` | `PlaylistController@show` |
| POST | `/playlists/songs/{song}` | `PlaylistController@addSong` |
| DELETE | `/playlists/{playlist}/songs/{song}` | `PlaylistController@removeSong` |
| DELETE | `/playlists/{playlist}` | `PlaylistController@delete` |

### 5.7 Lịch sử nghe

**Mô tả**: Ghi lại mỗi lần người dùng nghe bài hát.

**Routes**:
| Method | URI | Action |
|---|---|---|
| POST | `/listening-history/{song}` | `ListeningHistoryController@store` |
| POST | `/listening-history/{song}/progress` | `ListeningHistoryController@progress` |

**Chi tiết**:
- Tự động ghi nhận khi người dùng nghe bài hát
- Theo dõi số giây đã nghe (`listened_seconds`)
- Chỉ tính vào `listen_count` khi `has_counted = true`

### 5.8 Gói đăng ký & Thanh toán (`/goi-dang-ky`)

**Mô tả**: Xem danh sách gói VIP, thanh toán qua VNPAY.

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/goi-dang-ky` | `Web\PlanController@index` |
| GET | `/goi-dang-ky/{plan}/thanh-toan` | `Web\PlanController@showPayment` |
| GET | `/goi-dang-ky/vnpay-return` | `Web\PlanController@vnpayReturn` |
| POST | `/goi-dang-ky/{plan}` | `Web\PlanController@subscribe` |

**Chi tiết**:
- Hiển thị các gói đăng ký với giá và thời hạn
- Tích hợp thanh toán VNPAY
- Sau khi thanh toán thành công, tự động tạo subscription và kích hoạt quyền nghe bài VIP

### 5.9 Tin tức (`/tin-tuc`)

**Mô tả**: Xem danh sách và chi tiết bài viết tin tức.

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/tin-tuc` | `NewsController@showPublic` |
| GET | `/tin-tuc/{slug}` | `NewsController@show` |

### 5.10 Nghệ sĩ & Album

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/artists` | `HomeController@artistsIndex` |
| GET | `/nghe-si/{artist}` | `HomeController@artistShow` |

### 5.11 Podcast

**Routes**:
| Method | URI | Action |
|---|---|---|
| GET | `/podcasts` | `HomeController@podcastsIndex` |
| GET | `/podcasts/{podcast}` | `HomeController@podcastShow` |

### 5.12 Xếp hạng

**Route**: `GET /bang-xep-hang` → `HomeController@rankings`

### 5.13 Bình luận (Comments)

- Người dùng có thể bình luận trên các bài tin tức
- Admin quản lý bình luận từ trang quản trị

### 5.14 Phát nhạc (Audio Player)

- HTML5 Audio Player tích hợp trong giao diện
- Bài hát VIP: kiểm tra `can_play` dựa trên subscription của user
- Tự động ghi nhận lịch sử nghe khi phát nhạc

---

## 6. CHỨC NĂNG PHÍA QUẢN TRỊ (ADMIN)

Tất cả route admin đều nằm trong group:
```
Prefix: /admin
Middleware: auth + role:admin
```

### 6.1 Dashboard Admin (`/admin`)

**Mô tả**: Trang tổng quan quản trị.

**Controller**: `AdminDashboardController@index`

**Hiển thị**:
- Tổng quan số liệu (người dùng, bài hát, doanh thu...)
- Các chỉ số thống kê nhanh

### 6.2 Quản lý người dùng (`/admin/users`)

**Controller**: `UserController`

**Chức năng CRUD đầy đủ**:

| Method | URI | Route Name | Action |
|---|---|---|---|
| GET | `/admin/users` | `admin.users.index` | Danh sách |
| GET | `/admin/users/create` | `admin.users.create` | Form tạo |
| POST | `/admin/users` | `admin.users.store` | Lưu mới |
| GET | `/admin/users/{id}/edit` | `admin.users.edit` | Form sửa |
| PUT | `/admin/users/{id}` | `admin.users.update` | Cập nhật |
| DELETE | `/admin/users/{id}` | `admin.users.delete` | Xóa 1 user |
| DELETE | `/admin/users/bulk-delete` | `admin.users.bulk-delete` | Xóa nhiều |

**Chi tiết**:
- Tìm kiếm theo tên
- Phân trang 10 user/trang
- Xóa hàng loạt với checkbox
- Gán role (admin / user)

### 6.3 Quản lý thể loại (`/admin/categories`)

**Controller**: `CategoriesController`

| Method | URI | Route Name | Action |
|---|---|---|---|
| GET | `/admin/categories` | `admin.categories.index` | Danh sách |
| GET | `/admin/categories/create` | `admin.categories.create` | Form tạo |
| POST | `/admin/categories` | `admin.categories.store` | Lưu mới |
| GET | `/admin/categories/{id}/edit` | `admin.categories.edit` | Form sửa |
| PUT | `/admin/categories/{id}` | `admin.categories.update` | Cập nhật |
| DELETE | `/admin/categories/{id}` | `admin.categories.delete` | Xóa 1 |
| DELETE | `/admin/categories/bulk-delete` | `admin.categories.bulk-delete` | Xóa nhiều |

### 6.4 Quản lý bài hát (`/admin/songs`)

**Controller**: `SongController`

| Method | URI | Route Name | Action |
|---|---|---|---|
| GET | `/admin/songs` | `admin.songs.index` | Danh sách |
| GET | `/admin/songs/create` | `admin.songs.create` | Form tạo |
| POST | `/admin/songs` | `admin.songs.store` | Lưu mới |
| GET | `/admin/songs/{id}/edit` | `admin.songs.edit` | Form sửa |
| PUT | `/admin/songs/{id}` | `admin.songs.update` | Cập nhật |
| DELETE | `/admin/songs/{id}` | `admin.songs.delete` | Xóa 1 |
| DELETE | `/admin/songs/bulk-delete` | `admin.songs.bulk-delete` | Xóa nhiều |
| GET | `/admin/songs/export` | `admin.songs.export` | Export Excel |
| POST | `/admin/songs/import` | `admin.songs.import` | Import Excel |

**Thống kê lượt nghe theo tháng** (tính năng mới):

- Dropdown chọn năm (tự động lấy các năm có dữ liệu)
- Biểu đồ cột Chart.js hiển thị lượt nghe mỗi tháng
- Bảng chi tiết số liệu từng tháng
- Lọc theo `has_counted = true` để chỉ đếm lượt nghe hợp lệ

**Chi tiết thêm**:
- Upload file audio (MP3, tối đa 500MB)
- Upload ảnh thumbnail (JPG, PNG, GIF, WEBP, tối đa 4MB)
- Gán nghệ sĩ, album, thể loại
- Đánh dấu bài hát VIP
- Tìm kiếm theo tên bài hát
- Hiển thị bài hát nổi bật (nhiều lượt nghe nhất)

### 6.5 Quản lý nghệ sĩ (`/admin/artists`)

**Controller**: `ArtistsController`

CRUD đầy đủ + bulk delete. Upload ảnh nghệ sĩ, mô tả, trạng thái.

### 6.6 Quản lý album (`/admin/albums`)

**Controller**: `AlbumController`

CRUD đầy đủ + bulk delete. Upload ảnh bìa album, năm phát hành, trạng thái.

### 6.7 Quản lý podcast (`/admin/podcasts`)

**Controller**: `PodcastController`

CRUD đầy đủ + bulk delete. Upload file audio, ảnh bìa, thời lượng, trạng thái.

### 6.8 Quản lý gói đăng ký (`/admin/subscriptions`)

**Controller**: `SubscriptionController`

**Chức năng**:
- CRUD gói đăng ký
- Gán gói cho user
- Tính tự động ngày hết hạn dựa trên `duration_days` của plan

**Thống kê**:
- Tổng số subscription
- Tổng doanh thu
- Biểu đồ doanh thu theo tháng (Chart.js)
- Dropdown chọn năm

### 6.9 Quản lý tin tức (`/admin/news`)

**Controller**: `NewsController`

CRUD đầy đủ + bulk delete. Tự động tạo slug từ tiêu đề. Upload ảnh minh họa.

### 6.10 Quản lý quảng cáo (`/admin/ads`)

**Controller**: `AdController`

CRUD đầy đủ + bulk delete.
- Upload ảnh quảng cáo
- Thiết lập liên kết đích
- Bật/tắt hiển thị
- Optimistic locking (kiểm tra `updated_at` khi cập nhật)

### 6.11 Quản lý bình luận (`/admin/comments`)

**Controller**: `CommentsController`

CRUD đầy đủ + bulk delete. Xem bình luận trên các bài tin tức.

### 6.12 Nhật ký hoạt động (`/admin/activity_logs`)

**Controller**: `ActivityLogController`

**Mô tả**: Ghi lại mọi thao tác CRUD trong hệ thống.

Mỗi log bao gồm:
- `module`: Module thực hiện (Song, User, Ad, News...)
- `action`: CREATE, UPDATE, DELETE
- `title`: Tên đối tượng bị tác động
- `user_id`: Người thực hiện
- `created_at`: Thời gian

### 6.13 Giao diện Admin

- Layout: Sidebar trái + Header + Content area
- Sidebar: Menu điều hướng với các mục Dashboard, Người dùng, Thể loại, Bài hát, Nghệ sĩ, Album, Subscription, Podcast, Comment, Tin tức, Quảng cáo, Activity Logs
- Theme: Dark mode, Tailwind CSS
- Responsive: Mobile-friendly
- Flash messages: Success/Error notifications
- Checkbox select-all cho bulk delete

---

## 7. HƯỚNG DẪN CÀI ĐẶT & CHẠY DỰ ÁN

### 7.1 Yêu cầu hệ thống

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Node.js & npm (cho Vite/Tailwind)

### 7.2 Cài đặt

```bash
# 1. Clone hoặc copy dự án vào thư mục
cd DoAnNhom

# 2. Cài đặt PHP dependencies
composer install

# 3. Cài đặt JS dependencies
npm install

# 4. Tạo file .env
cp .env.example .env

# 5. Cấu hình database trong .env
#    DB_DATABASE=tên_database
#    DB_USERNAME=root
#    DB_PASSWORD=mật_khẩu

# 6. Tạo application key
php artisan key:generate

# 7. Chạy migration
php artisan migrate

# 8. Chạy seeders (tạo dữ liệu mẫu)
php artisan db:seed

# 9. Tạo symlink storage
php artisan storage:link

# 10. Build assets
npm run build

# 11. Chạy server phát triển
php artisan serve
```

### 7.2 Seeders có sẵn

| Seeder | Mô tả |
|---|---|
| `UserSeeder` | Tạo user admin và user thường mẫu |
| `CategorySeeder` | Tạo các thể loại nhạc |
| `ArtistSeeder` | Tạo nghệ sĩ mẫu |
| `AlbumSeeder` | Tạo album mẫu |
| `SongSeeder` | Tạo bài hát mẫu |
| `PlanSeeder` | Tạo gói đăng ký (1 tháng, 3 tháng, 1 năm...) |
| `SubscriptionSeeder` | Tạo subscription mẫu |
| `PodcastSeeder` | Tạo podcast mẫu |
| `NewsSeeder` | Tạo tin tức mẫu |
| `CommentSeeder` | Tạo bình luận mẫu |
| `AdSeeder` | Tạo quảng cáo mẫu |
| `ListeningHistorySeeder` | Tạo lịch sử nghe 3 năm gần nhất (dùng cho thống kê) |

### 7.3 Tài khoản mặc định

Sau khi chạy seeders:

- **Admin**: Đăng nhập tại `/login` → tự động redirect vào `/admin`
- **User**: Đăng nhập tại `/login` → redirect vào `/dashboard`

---

## 8. HƯỚNG DẪN SỬ DỤNG

### 8.1 Người dùng

1. **Đăng ký**: Truy cập `/register`, điền fullname, email, phone, password
2. **Đăng nhập**: Truy cập `/login`, nhập email + password
3. **Nghe nhạc**: Trang chủ `/` hiển thị danh sách bài hát. Click play để nghe
4. **Tìm kiếm**: Nhập từ khóa vào thanh search trên trang chủ
5. **Yêu thích bài hát**: Click nút heart trên mỗi bài hát
6. **Tạo playlist**: Vào trang playlists, tạo playlist mới và thêm bài hát
7. **Đăng ký VIP**: Vào `/goi-dang-ky`, chọn gói, thanh toán qua VNPAY
8. **Xem podcast**: Vào `/podcasts`, chọn podcast để nghe
9. **Xem tin tức**: Vào `/tin-tuc`, đọc bài viết và bình luận
10. **Xem lịch sử nghe**: Dashboard cá nhân hiển thị thống kê

### 8.2 Quản trị viên

1. **Đăng nhập**: Dùng tài khoản admin tại `/login`
2. **Dashboard**: `/admin` — xem tổng quan số liệu
3. **Quản lý nội dung**: CRUD bài hát, nghệ sĩ, album, thể loại, podcast, tin tức
4. **Quản lý người dùng**: Xem, tạo, sửa, xóa user
5. **Quản lý quảng cáo**: Tạo, sửa, xóa banner quảng cáo
6. **Quản lý subscription**: Gán gói VIP cho user
7. **Thống kê lượt nghe**: Vào `/admin/songs`, chọn năm để xem biểu đồ
8. **Thống kê doanh thu**: Vào `/admin/subscriptions`, xem biểu đồ doanh thu
9. **Xem activity logs**: `/admin/activity_logs` — theo dõi mọi thao tác
10. **Import/Export**: Export bài hát ra Excel hoặc import từ file Excel

---

## PHỤ LỤC

### A. Middleware

| Middleware | Mô tả |
|---|---|
| `auth` | Yêu cầu đăng nhập |
| `role:admin` | Yêu cầu vai trò admin |
| `guest` | Chỉ dành cho khách (chưa đăng nhập) |

### B. Validation Rules tiêu biểu

**Bài hát (Song)**:
- `title`: required, string, max:255
- `category_id`: required, exists:categories,id
- `audio_upload`: required, file, mimes:mp3, max:512000 (500MB)
- `image_upload`: nullable, image, mimes:jpg,jpeg,png,gif,webp, max:4096 (4MB)
- `status`: nullable, boolean
- `is_vip`: nullable, boolean

**User**:
- `fullname`: required, string, max:255
- `email`: required, email, unique:users
- `password`: required, confirmed, min:6

**Subscription**:
- `user_id`: required, exists:users,id
- `plan_id`: required, exists:plans,id
- `starts_at`: required, date

### C. File Upload

- **Audio**: `storage/app/public/songs/` → truy cập qua `/storage/songs/`
- **Image**: `storage/app/public/{type}_images/` → truy cập qua `/storage/{type}_images/`
- Các loại thư mục: `song_images`, `ad_images`, `category_images`, `news_images`, `podcasts`, `banner_images`

### D. Cấu trúc URL thân thiện

- Tin tức: `/tin-tuc/{slug}`
- Nghệ sĩ: `/nghe-si/{artist}`
- Gói đăng ký: `/goi-dang-ky/{plan}/thanh-toan`

---

*Báo cáo được tạo tự động từ mã nguồn dự án Laravel — Ngày 31/05/2026*
