# LuqueComics

A Laravel-based comic book store where users can browse, purchase, and rate comics. Includes features such as authentication, shopping cart, checkout with Stripe, multi-language support, and admin tools.

---

## Features

- User authentication and email verification  
- Shopping cart and order management  
- Stripe checkout integration  
- Multi-language support (English/Spanish)  
- Admin panel for managing comics, publishers, characters, and orders  
- Soft delete for comics and publishers  
- User reviews and ratings for comics  

---

## Requirements

- PHP >= 8.2  
- Composer  
- Laravel 12  
- MySQL >= 8.0  
- Node.js & npm (for frontend assets)  

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/comic-store.git
   cd comic-store
   
2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build

3. **Set up environment**
   ```bash
   cp .env.example .env
   ```
   Update .env with your database, mail, and Stripe credentials.

4. **Generate app key**
   ```bash
   php artisan key:generate

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed

6. **Link storage**
   ```bash
   php artisan storage:link

7. **Start development server**
   ```bash
   php artisan serve
