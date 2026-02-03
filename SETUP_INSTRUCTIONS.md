# Laravel LMS Setup Instructions for XAMPP 8.2.12

## Prerequisites
- XAMPP 8.2.12 installed
- Composer installed
- Node.js and npm installed (optional, for frontend assets)

## Setup Steps

### 1. Database Setup
1. Start XAMPP Control Panel
2. Start Apache and MySQL services
3. Open phpMyAdmin (http://localhost/phpmyadmin)
4. Create a new database named `laravel_lms`

### 2. Environment Configuration
The `.env` file is already configured with:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_lms
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Dependencies
```bash
cd laravel-lms
composer install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate:fresh --seed
```

### 6. Start the Development Server
```bash
php artisan serve
```

The application will be available at: http://127.0.0.1:8000

## Default Users Created

### Admin Dashboard
- **URL**: http://127.0.0.1:8000/dashboard
- **Email**: admin@lms.com
- **Password**: password
- **Features**: 
  - Approve/deny enrollments
  - Create courses
  - Manage users
  - View all system data

### Teacher Dashboard
- **Email**: teacher1@lms.com or teacher2@lms.com
- **Password**: password
- **Features**:
  - View assigned courses
  - See enrolled students
  - Assign and update grades
  - Manage course content

### Student Dashboard
- **Email**: student1@lms.com, student2@lms.com, or student3@lms.com
- **Password**: password
- **Features**:
  - Browse available courses
  - Enroll in courses
  - View enrolled courses
  - Check grades

## API Testing

### Using Postman
1. Import the API endpoints from `API_DOCUMENTATION.md`
2. Set base URL to: `http://127.0.0.1:8000/api`
3. For protected endpoints, add Authorization header: `Bearer {token}`

### Sample API Flow
1. **Register/Login**: Get authentication token
2. **Student Flow**:
   - GET `/api/courses` - View available courses
   - POST `/api/enrollments` - Enroll in course
   - GET `/api/my-courses` - View enrolled courses
   - GET `/api/my-grades` - View grades

3. **Admin Flow**:
   - GET `/api/enrollments` - View pending enrollments
   - PUT `/api/enrollments/{id}` - Approve/deny enrollments
   - POST `/api/courses` - Create new courses

4. **Teacher Flow**:
   - GET `/api/courses` - View assigned courses
   - GET `/api/courses/{id}/students` - View course students
   - POST `/api/grades` - Assign grades

## Frontend Features

### Registration Page
- Role selection (Student, Teacher, Admin)
- Form validation
- Automatic redirect to dashboard

### Dashboard Pages
- **Student Dashboard**: Course enrollment, grade viewing
- **Teacher Dashboard**: Grade assignment, student management
- **Admin Dashboard**: Enrollment approval, course creation

### Responsive Design
- Built with Tailwind CSS
- Mobile-friendly interface
- Modern UI components

## Database Schema

### Users Table
- id, name, email, password, role, timestamps

### Courses Table
- id, title, description, teacher_id, status, timestamps

### Enrollments Table
- id, student_id, course_id, status, timestamps
- Unique constraint on student_id + course_id

### Grades Table
- id, student_id, course_id, assignment_name, grade, max_grade, comments, timestamps

## Security Features
- Laravel Sanctum API authentication
- Role-based access control
- CSRF protection
- Input validation
- SQL injection prevention

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure MySQL is running in XAMPP
   - Check database name and credentials in `.env`

2. **Migration Errors**
   - Run `php artisan migrate:fresh --seed --force`
   - Check database permissions

3. **API Authentication Issues**
   - Ensure Sanctum is properly installed
   - Check token format in Authorization header

4. **Route Not Found**
   - Run `php artisan route:clear`
   - Check if routes are properly defined

### Performance Optimization
- Enable caching: `php artisan config:cache`
- Optimize autoloader: `composer dump-autoload -o`
- Cache routes: `php artisan route:cache`

## Next Steps
1. Test all API endpoints using Postman
2. Customize the frontend design
3. Add more features like file uploads, notifications
4. Implement email verification
5. Add course content management
6. Create reporting features

## Support
For issues or questions, check the Laravel documentation at https://laravel.com/docs