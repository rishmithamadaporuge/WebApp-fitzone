# FitZone Fitness Center Web Application

![FitZone Logo](image/home/FitZoneLogoPNG.png)

A comprehensive web application built for **FitZone Fitness Center** in Kurunegala to promote fitness services, manage memberships, and provide class schedules. This app is designed to help attract new members, streamline management tasks, and engage users with valuable fitness content.

---

## 🚩 Features

- **User registration and authentication** for customers
- **Membership plan management** with subscription options
- **Class scheduling and personal trainer details**
- **Blog section** with workout routines, healthy recipes, and success stories
- **Admin dashboard** for managing users, classes, trainers, memberships, and blog posts
- **Query submission and response system** for customer support
- **Search functionality** for classes, trainers, and blog posts
- **Responsive design** for seamless use across devices

---

## 🛠️ Technology Stack

| Layer       | Technology                    |
| ----------- | -----------------------------|
| Frontend    | HTML5, CSS3, JavaScript       |
| Backend     | PHP, MySQL (via phpMyAdmin)   |
| Authentication | PHP Sessions                |
| Styling     | Custom CSS                   |
| Database    | MySQL                        |

---

## 🔧 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/rishmithamadaporuge/WebApp-fitzone.git
   cd WebApp-fitzone
   ```

2. **Set up the database:**
   - Import the provided SQL file (`fitzone_db.sql`) into your MySQL server using phpMyAdmin or MySQL CLI.
   - Update the database connection details in `db_connect.php`.

3. **Configure your web server:**
   - Place the project files in your local server directory (e.g., `htdocs` for XAMPP).
   - Start Apache and MySQL services.

4. **Open your browser and navigate to:**
   ```
   http://localhost/WebApp-fitzone/
   ```

---

## 📋 Project Structure

- `/css/` – Stylesheets for various pages  
- `/includes/` – Reusable PHP files (header, footer, database connection)  
- `/admin/` – Admin dashboard and management pages  
- `/customer/` – Customer-specific pages like registration, membership  
- `/blog/` – Blog post management and display  
- `/classes/` – Class schedules and management  
- `/queries/` – User query submission and admin response  
- `/index.php` – Home page

---

## 🛡️ Security & Validation

- Server-side validation for form inputs using PHP  
- Passwords hashed before storage  
- Session-based authentication and role management  
- Proper error handling for database and form operations

---

## 📈 Future Enhancements

- Add payment gateway integration for membership purchases  
- Implement RESTful APIs for frontend-backend separation  
- Enhance UI/UX with modern frontend frameworks like React or Vue.js  
- Push notifications and email alerts for class updates and promotions  
- Advanced analytics dashboard for gym management

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to check the [issues page](https://github.com/rishmithamadaporuge/WebApp-fitzone/issues).

To contribute:  
1. Fork the repository  
2. Create a branch (`git checkout -b feature/your-feature`)  
3. Commit your changes (`git commit -m 'Add some feature'`)  
4. Push to the branch (`git push origin feature/your-feature`)  
5. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 📬 Contact

**Author:** Rishmitha Madaporuge
**Email:** rishmithamadaporuge@.com  
**GitHub:** [@rishmithamadaporuge](https://github.com/rishmithamadaporuge)  

---

Thank you for visiting! Stay fit and motivated! 💪
