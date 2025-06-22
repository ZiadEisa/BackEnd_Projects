# 🚗 RentalCar System

A full-stack car rental system built with **PHP**, **JavaScript**, **HTML/CSS**, and **MySQL**. This project allows users to browse vehicles, sign up, log in, rent cars, and manage profiles — with dedicated authentication, car detail pages, and admin utilities.

---

## 📁 Project Structure

```
RentalCar/
├── CSS/              # All style sheets for different pages
├── Images/           # Car images and UI visuals
├── JS/               # Frontend interaction scripts
├── PHP/              # Backend logic and routing (AddCars, Login, SignUp...)
├── rental_car.sql    # Database schema (MySQL)
├── README.md         # Project README
```

---

## 🌟 Features

### 👤 User Functionality

* Sign up / Log in
* Browse car listings
* View car details with images
* Submit rental forms
* View and update user profile

### 🛠️ Admin Features (via PHP files like `authAddCar.php`)

* Add new cars
* Edit or update car details
* Authenticate actions with session management

---

## 💻 Technologies Used

| Layer    | Tech                      |
| -------- | ------------------------- |
| Frontend | HTML, CSS, JavaScript     |
| Backend  | PHP                       |
| Database | MySQL (`rental_car.sql`)  |
| Styling  | Custom CSS (no framework) |

---

## 🚀 Getting Started

1. **Clone the repo**

```bash
git clone https://github.com/ZiadEisa/BackEnd_Projects.git
cd BackEnd_Projects/RentalCar
```

2. **Set up your environment**

* Install XAMPP/WAMP/LAMP
* Move `RentalCar/` into your server's `htdocs` directory
* Import `rental_car.sql` into phpMyAdmin/MySQL

3. **Access in browser**

```
http://localhost/RentalCar/PHP/index.php
```

---

## 💬 Final Note

This project brings together frontend interaction, backend logic, and database integration to create a full car rental experience.

Feel free to fork it, use it, or contribute to make it even better!
