# SocialHub - Social Media Platform

A modern, full-featured social media platform built with CodeIgniter 4 and Tailwind CSS.

## 🚀 Features

### Core Functionality
- **User Authentication**: Secure registration and login with password hashing
- **Post Management**: Create, edit, delete posts with image support
- **Social Interactions**: Like posts, comment system with threading
- **User Relationships**: Follow/unfollow users, view followers/following
- **Search**: Find posts by keywords
- **Admin Dashboard**: User and post moderation tools

### Technical Features
- **MVC Architecture**: Clean separation of concerns with CodeIgniter 4
- **Database Sessions**: Secure session management
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **RESTful Routing**: Intuitive URL structure
- **Validation**: Comprehensive input validation and error handling

## 🛠️ Technology Stack

- **Backend**: CodeIgniter 4 (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Frontend**: Tailwind CSS (CDN), HTML5, JavaScript
- **Session Management**: Database-based sessions
- **Development Server**: Built-in CodeIgniter server

## 📋 Requirements

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js (optional, for production Tailwind build)

## 🚀 Installation

1. **Clone or Download** the project
2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Environment Setup**:
   - Copy `.env` file and configure database settings
   - Set `CI_ENVIRONMENT = development`

4. **Database Setup**:
   ```bash
   # Create database
   mysql -u root -e "CREATE DATABASE social_media;"

   # Run migrations
   php spark migrate
   ```

5. **Start Development Server**:
   ```bash
   php spark serve
   ```

6. **Access Application**:
   - Open http://localhost:8080 in your browser
   - Register a new account or login

## 📁 Project Structure

```
appstarter/
├── app/
│   ├── Config/          # Application configuration
│   ├── Controllers/     # Request handlers
│   ├── Database/
│   │   └── Migrations/  # Database schema
│   ├── Models/          # Data models
│   ├── Views/           # Template files
│   └── Helpers/         # Custom helpers
├── public/
│   ├── css/style.css    # Custom Tailwind components
│   └── js/script.js     # Global JavaScript
├── tests/               # Unit tests
├── vendor/              # Composer dependencies
├── writable/            # Logs, cache, sessions
└── .env                 # Environment configuration
```

## 🎨 Styling

The application uses Tailwind CSS for modern, responsive styling:

- **CDN Version**: Currently using Tailwind CDN for development
- **Custom Components**: Additional utility classes in `public/css/style.css`
- **Production Ready**: Can be built with Tailwind CLI for optimized CSS

## 🔐 Security Features

- Password hashing with `password_hash()`
- CSRF protection
- Input validation and sanitization
- Session security
- SQL injection prevention with prepared statements

## 📊 Database Schema

### Tables
- `users`: User accounts and profiles
- `posts`: User posts with content and images
- `comments`: Threaded comments system
- `likes`: Post reactions
- `follows`: User relationships
- `ci_sessions`: Session storage

## 🧪 Testing

Run the test suite:
```bash
php spark test
```

## 📝 API Endpoints

### Authentication
- `GET /auth/login` - Login form
- `POST /auth/login` - Process login
- `GET /auth/register` - Registration form
- `POST /auth/register` - Process registration
- `GET /auth/logout` - Logout

### Posts
- `GET /posts/feed` - User feed
- `GET /posts/create` - Create post form
- `POST /posts/store` - Save new post
- `GET /posts/view/{id}` - View single post
- `GET /posts/edit/{id}` - Edit post form
- `POST /posts/update/{id}` - Update post
- `POST /posts/delete/{id}` - Delete post
- `GET /posts/search` - Search posts

### Users
- `GET /users/profile/{username}` - User profile
- `GET /users/edit` - Edit profile form
- `POST /users/update` - Update profile
- `GET /users/followers/{username}` - Followers list
- `GET /users/following/{username}` - Following list
- `POST /users/follow/{username}` - Follow user
- `POST /users/unfollow/{username}` - Unfollow user

### Comments
- `POST /comments/store` - Add comment
- `GET /comments/edit/{id}` - Edit comment form
- `POST /comments/update/{id}` - Update comment
- `POST /comments/delete/{id}` - Delete comment

### Admin
- `GET /admin/dashboard` - Admin overview
- `GET /admin/manage-users` - User management
- `GET /admin/manage-posts` - Post management
- `POST /admin/toggle-status/{id}` - Toggle user status
- `POST /admin/delete-user/{id}` - Delete user
- `POST /admin/delete-post/{id}` - Delete post

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 📞 Support

For questions or issues, please check the CodeIgniter 4 documentation or create an issue in the repository.

---

**Built with ❤️ using CodeIgniter 4 and Tailwind CSS**

## Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
