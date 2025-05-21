# 🛒 Shopping Cart Simulation

This is a simple simulation of an e-commerce shopping cart system built with **PHP**, **MySQL**, and **JavaScript**. The project demonstrates how cart data is handled both for logged-in and guest users, using **cookies** and **server-side sessions**.

## 🚀 Features

- User login and registration system
- Persistent shopping cart for both guests and logged-in users
- Cart items stored in **cookies** for guests
- On login, cart items from cookies are **transferred** to the authenticated user's cart
- Secure backend API communication using `fetch` and `credentials: "include"`

## 🔧 Technologies

- **Frontend**: HTML, CSS, JavaScript (vanilla)
- **Backend**: PHP (native, no frameworks)
- **Database**: MySQL

## 📦 How it works

1. A **guest user** can browse the site and add products to the cart.
2. These cart items are saved locally in **cookies**.
3. When the user **logs in**:
   - The backend checks for any existing cart data in cookies.
   - If found, those items are automatically **merged** into the user's cart stored in the database or session.
4. The user's cart is now managed server-side and kept across sessions.

## 🔐 Authentication

- Basic login system (no frameworks)
- PHP sessions (`$_SESSION`) are used to manage user state
- Cookies are used for temporary cart storage before login
- Cross-origin safe requests with `fetch` and `credentials: "include"`
