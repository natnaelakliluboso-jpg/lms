# Laravel LMS API Documentation

## Base URL
```
http://localhost/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

## API Endpoints

### Authentication

#### Register User
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "student" // student, teacher, admin
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Get Current User
```http
GET /api/me
Authorization: Bearer {token}
```

### Courses

#### Get All Courses
```http
GET /api/courses
Authorization: Bearer {token}
```

#### Get Single Course
```http
GET /api/courses/{id}
Authorization: Bearer {token}
```

#### Create Course (Admin only)
```http
POST /api/courses
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Course Title",
    "description": "Course description",
    "teacher_id": 1
}
```

#### Update Course (Admin/Teacher)
```http
PUT /api/courses/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Title",
    "description": "Updated description",
    "status": "active"
}
```

#### Delete Course (Admin only)
```http
DELETE /api/courses/{id}
Authorization: Bearer {token}
```

#### Get Course Students (Teacher/Admin)
```http
GET /api/courses/{id}/students
Authorization: Bearer {token}
```

### Enrollments

#### Get All Enrollments
```http
GET /api/enrollments
Authorization: Bearer {token}
```

#### Enroll in Course (Student only)
```http
POST /api/enrollments
Authorization: Bearer {token}
Content-Type: application/json

{
    "course_id": 1
}
```

#### Update Enrollment Status (Admin only)
```http
PUT /api/enrollments/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "status": "approved" // pending, approved, denied
}
```

#### Get My Enrollments (Student only)
```http
GET /api/my-enrollments
Authorization: Bearer {token}
```

#### Get My Enrolled Courses (Student only)
```http
GET /api/my-courses
Authorization: Bearer {token}
```

### Grades

#### Get All Grades
```http
GET /api/grades
Authorization: Bearer {token}
```

#### Assign Grade (Teacher/Admin)
```http
POST /api/grades
Authorization: Bearer {token}
Content-Type: application/json

{
    "student_id": 1,
    "course_id": 1,
    "assignment_name": "Assignment 1",
    "grade": 85.5,
    "max_grade": 100,
    "comments": "Good work!"
}
```

#### Update Grade (Teacher/Admin)
```http
PUT /api/grades/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "grade": 90,
    "comments": "Excellent improvement!"
}
```

#### Get My Grades (Student only)
```http
GET /api/my-grades
Authorization: Bearer {token}
```

#### Get Course Grades (Teacher/Admin)
```http
GET /api/courses/{id}/grades
Authorization: Bearer {token}
```

## Sample Users (Created by Seeder)

### Admin
- Email: admin@lms.com
- Password: password
- Role: admin

### Teachers
- Email: teacher1@lms.com / teacher2@lms.com
- Password: password
- Role: teacher

### Students
- Email: student1@lms.com / student2@lms.com / student3@lms.com
- Password: password
- Role: student

## Postman Collection Examples

### 1. Register Student
```json
{
    "name": "Test Student",
    "email": "test@student.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "student"
}
```

### 2. Login
```json
{
    "email": "admin@lms.com",
    "password": "password"
}
```

### 3. Enroll in Course
```json
{
    "course_id": 1
}
```

### 4. Assign Grade
```json
{
    "student_id": 4,
    "course_id": 1,
    "assignment_name": "Midterm Exam",
    "grade": 88.5,
    "max_grade": 100,
    "comments": "Great understanding of the concepts!"
}
```

## Error Responses

All endpoints return consistent error responses:

```json
{
    "message": "Error description",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

## Status Codes
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 409: Conflict
- 422: Validation Error
- 500: Server Error