# 💰 Bank Loan Management System

A professional web-based application for managing employee bank loans with automated benefit calculations based on employment tenure.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [File Structure](#file-structure)
- [Technologies](#technologies)
- [Screenshots](#screenshots)
- [Future Enhancements](#future-enhancements)

---

## ✨ Features

### Employee Management
- ✅ Add new employee records
- ✅ Search and retrieve existing employees
- ✅ Update employee information
- ✅ View all employees in a dedicated sidebar panel

### Loan Calculation
- ✅ **Automatic Benefit Rate Calculation** based on employment period:
  - **≥ 10 years**: 20% benefit rate
  - **≥ 5 years (< 10 years)**: 15% benefit rate
  - **< 5 years**: 10% benefit rate
- ✅ Calculate total loan amount with benefits
- ✅ Monthly payment distribution (12-month period)

### Data Management
- ✅ **Save Data**: Store employee loan records in database
- ✅ **Display From DB**: View all records in a formatted table
- ✅ **Delete All**: Clear all records (with confirmation)
- ✅ **Print**: Generate and print employee records

### User Interface
- ✅ Professional two-panel layout (search panel + main content)
- ✅ Real-time employee list in sidebar
- ✅ Click-to-load employee data from sidebar
- ✅ Responsive design for desktop and tablet views
- ✅ Color-coded buttons for quick identification
- ✅ Form validation and error handling

---

## 🔧 Requirements

### System Requirements
- **Web Server**: Apache with PHP support (or any PHP-enabled server)
- **Database**: MySQL 5.7 or higher
- **PHP**: Version 7.4 or higher
- **Browser**: Chrome, Firefox, Safari, or Edge (latest versions)

### Database Credentials (Default)
```
Host: localhost
Username: root
Password: Ushindi123!
Database: bank_loan_system
```

---

## 📦 Installation

### Step 1: Download/Clone the Project
```bash
git clone https://github.com/yourusername/bank-loan-system.git
cd bank-loan-system
```

Or extract the project folder to your web server directory (e.g., `htdocs` for XAMPP).

### Step 2: Verify PHP Installation
```bash
php -v
```

### Step 3: Verify MySQL Installation
```bash
mysql --version
```

### Step 4: Access the Application
```
http://localhost/bank-loan-system/
```

---

## 🗄️ Database Setup

### Create Database
In **phpMyAdmin** or MySQL command line:

```sql
CREATE DATABASE IF NOT EXISTS bank_loan_system;
USE bank_loan_system;
```

### Create Employees Table
```sql
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    employee_address VARCHAR(255),
    monthly_salary DECIMAL(10,2) NOT NULL,
    employment_period INT NOT NULL,
    benefit_rate DECIMAL(5,2),
    loan_amount DECIMAL(10,2),
    total_amount DECIMAL(10,2),
    monthly_payment DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_employee (employee_name)
);
```

### Update Database Credentials (if needed)
Edit `db.php` and update the connection parameters:

```php
$conn = new mysqli(
    "localhost",      // Server host
    "root",          // MySQL username
    "Ushindi123!",   // MySQL password
    "bank_loan_system" // Database name
);
```

---

## 🚀 Usage

### 1. Add a New Employee

1. Fill in the **Employee Information** section:
   - Employee Name *
   - Employee Address
   - Monthly Salary (₦) *
   - Employment Period (Years) *

2. The **Benefit Rate** will automatically calculate based on employment period

3. Enter the **Loan Amount** (₦)

4. Click **"🧮 CLICK TO CALCULATE"** to compute:
   - Total Amount to be Received
   - Amount Received per Month

5. Click **"💾 SAVE DATA"** to store in database

### 2. Search an Employee

**Option A - Using Search Bar:**
- Type employee name in the search field
- Click **"Search"** button
- Employee data will auto-load into the form

**Option B - Using Sidebar:**
- Click on any employee name in the left sidebar
- Data automatically loads into the form

### 3. Display All Records

- Click **"📂 DISPLAY FROM DB"**
- A formatted table appears showing all saved records
- View details: ID, Name, Address, Salary, Period, Benefit Rate, Loan, Total, Monthly Payment

### 4. Print Records

- First, click **"📂 DISPLAY FROM DB"** to load records
- Then click **"🖨️ PRINT"**
- A print-ready window opens with all employee data
- Select printer and print

### 5. Delete All Records

- Click **"🗑️ DELETE ALL"**
- Confirm the action (irreversible)
- All records will be permanently deleted

---

## 📁 File Structure

```
bank-loan-system/
│
├── index.php                 # Main application interface
├── db.php                    # Database connection configuration
├── save.php                  # Save/Update employee records (AJAX)
├── get_data.php              # Fetch all records from database
├── get_employees_list.php    # Get employee list for sidebar
├── search_employee.php       # Search employee by name
├── delete_all.php            # Delete all records
├── style.css                 # Application styling & responsive design
│
└── README.md                 # This file

```

---

## 💻 Technologies Used

| Technology | Purpose |
|-----------|---------|
| **HTML5** | Page structure and markup |
| **CSS3** | Responsive styling and layout |
| **JavaScript (ES6)** | Client-side logic and interactions |
| **PHP** | Server-side processing |
| **MySQL** | Data persistence |
| **AJAX/Fetch API** | Asynchronous data operations |

---

## 📸 Screenshots

### Main Interface
- **Left Sidebar**: Employee search panel with live employee list
- **Main Content**: Employee information form with calculation results
- **Action Buttons**: Save, Display, Delete, Print operations

### Key Sections
1. **Employee Information** - Input fields for employee details
2. **Benefit Calculation** - Auto-calculated benefit rate based on tenure
3. **Calculation Results** - Total amount and monthly payment display
4. **Data Table** - Display all saved employee records

---

## 🔒 Security Features

✅ **Prepared Statements** - Prevents SQL injection
✅ **Input Validation** - Server-side validation of all inputs
✅ **Error Handling** - Comprehensive error messages
✅ **Data Sanitization** - Trimming and filtering user inputs
✅ **Unique Constraint** - Prevents duplicate employee records
✅ **Confirmation Dialogs** - Prevents accidental data deletion

---

## 🐛 Troubleshooting

### Issue: Database Connection Error
**Solution**: 
1. Verify MySQL is running
2. Check credentials in `db.php`
3. Ensure `bank_loan_system` database exists

### Issue: Data Not Saving
**Solution**:
1. Check browser console (F12) for error messages
2. Verify all required fields are filled
3. Check file permissions on PHP files
4. Ensure `employees` table exists in database

### Issue: Sidebar Not Loading Employees
**Solution**:
1. Refresh the page
2. Verify database connection
3. Check if there are records in the `employees` table

### Issue: Print Function Not Working
**Solution**:
1. First display records with "Display From DB"
2. Check browser's pop-up blocker settings
3. Try a different browser

---

## 📊 Benefit Rate Formula

The system automatically applies benefit rates based on employment tenure:

```
IF employment_period >= 10 years:
    benefit_rate = 20%
ELSE IF employment_period >= 5 years:
    benefit_rate = 15%
ELSE:
    benefit_rate = 10%
```

### Calculation Example
```
Employee: John Doe
Monthly Salary: ₦2,000
Employment Period: 15 years → Benefit Rate: 20%
Loan Amount: ₦300

Benefit Amount: ₦300 × 20% = ₦60
Total Amount: ₦300 + ₦60 = ₦360
Monthly Payment: ₦360 ÷ 12 = ₦30
```

---

## 🔄 API Endpoints

### POST - Save Employee Data
```
save.php
Body: empName, empAddress, monthlySalary, empPeriod, benefitRate, 
       loanAmount, totalAmount, monthlyPayment
Response: { status: 'success'|'error', message: '...' }
```

### GET - Retrieve All Records
```
get_data.php
Response: { status: 'success'|'error', records: [...] }
```

### GET - Search Employee
```
search_employee.php?search=NAME
Response: { status: 'success'|'error', record: {...} }
```

### GET - Employee List
```
get_employees_list.php
Response: { status: 'success', employees: [...] }
```

### POST - Delete All
```
delete_all.php
Response: { status: 'success'|'error', message: '...' }
```

---

## 🚀 Future Enhancements

- [ ] User authentication (login system)
- [ ] Edit/Delete individual records
- [ ] Export to Excel/CSV
- [ ] Advanced filtering and sorting
- [ ] Employee history/audit log
- [ ] Multi-language support
- [ ] Dashboard with statistics
- [ ] Email notifications
- [ ] Data backup functionality
- [ ] Mobile app version

---

## 📝 License

This project is licensed under the **MIT License** - feel free to use and modify.

---

## 👨‍💻 Developer

**Bank Loan Management System**  
Created for: AUCA Web Design Group B  
Date: April 2026

---

## 📧 Support & Feedback

For issues, questions, or suggestions, please create an issue in the project repository or contact the development team.

---

**Built with ❤️ for efficient loan management**

