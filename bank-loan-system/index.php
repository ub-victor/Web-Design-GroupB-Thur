<!DOCTYPE html>
<html>
<head>
    <title>Bank Loan Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- LEFT SIDEBAR -->
<div class="sidebar">
    <h3>🔍 SEARCH EMPLOYEE</h3>
    
    <div class="search-section">
        <input type="text" id="searchInput" placeholder="Enter employee name...">
        <button onclick="searchEmployee()">Search</button>
    </div>

    <div class="employee-list">
        <h4>Employees in DB:</h4>
        <div id="employeesList"></div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container">
        <h2>💰 BANK LOAN MANAGEMENT SYSTEM</h2>

        <form id="loanForm">
            
            <!-- EMPLOYEE INFORMATION SECTION -->
            <div class="form-section">
                <h4>📋 EMPLOYEE INFORMATION</h4>
                
                <div class="form-row">
                    <div>
                        <label for="empName">Employee Name *</label>
                        <input type="text" id="empName" name="empName" required>
                    </div>
                    <div>
                        <label for="empAddress">Employee Address</label>
                        <input type="text" id="empAddress" name="empAddress">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label for="monthlySalary">Monthly Salary (₦) *</label>
                        <input type="number" id="monthlySalary" name="monthlySalary" step="0.01" required>
                    </div>
                    <div>
                        <label for="empPeriod">Employment Period (Years) *</label>
                        <input type="number" id="empPeriod" name="empPeriod" min="0" required onchange="calculateBenefit()">
                    </div>
                </div>
            </div>

            <!-- BENEFIT CALCULATION SECTION -->
            <div class="form-section">
                <h4>💳 BENEFIT CALCULATION</h4>
                
                <div class="form-row">
                    <div>
                        <label for="benefitRate">Benefit Rate (%) *</label>
                        <input type="number" id="benefitRate" name="benefitRate" step="0.01" readonly>
                        <div class="info-display" id="benefitInfo"></div>
                    </div>
                    <div>
                        <label for="loanAmount">Loan Amount (₦) *</label>
                        <input type="number" id="loanAmount" name="loanAmount" step="0.01" required>
                    </div>
                </div>
            </div>

            <!-- CALCULATION BUTTONS -->
            <button type="button" class="btn-calculate" onclick="calculateLoan()">🧮 CLICK TO CALCULATE</button>

            <!-- RESULTS SECTION -->
            <div class="form-section">
                <h4>📊 CALCULATION RESULTS</h4>
                
                <div class="form-row">
                    <div>
                        <label>Total Amount to be Received (₦)</label>
                        <div class="info-display" id="totalAmount">₦0.00</div>
                    </div>
                    <div>
                        <label>Amount Received per Month (₦)</label>
                        <div class="info-display" id="monthlyAmount">₦0.00</div>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="button-group">
                <button type="button" class="btn-save" onclick="saveData()">💾 SAVE DATA</button>
                <button type="button" class="btn-display" onclick="displayFromDB()">📂 DISPLAY FROM DB</button>
                <button type="button" class="btn-delete" onclick="deleteAll()">🗑️ DELETE ALL</button>
                <button type="button" class="btn-print" onclick="printData()">🖨️ PRINT</button>
            </div>
        </form>

        <!-- DATA TABLE -->
        <div id="dataTableContainer" style="display:none; margin-top:30px;">
            <h3>Employee Records</h3>
            <table class="data-table" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Address</th>
                        <th>Monthly Salary</th>
                        <th>Employment Period</th>
                        <th>Benefit Rate</th>
                        <th>Loan Amount</th>
                        <th>Total Amount</th>
                        <th>Monthly Payment</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

// Load employees list on page load
window.onload = function() {
    loadEmployeesList();
};

// BENEFIT CALCULATION LOGIC
function calculateBenefit() {
    const period = parseFloat(document.getElementById('empPeriod').value);
    const benefitRateInput = document.getElementById('benefitRate');
    const benefitInfo = document.getElementById('benefitInfo');
    let rate = 0;
    let info = '';

    if (period >= 10) {
        rate = 20;
        info = '✓ >= 10 years: 20% rate applied';
    } else if (period >= 5) {
        rate = 15;
        info = '✓ >= 5 years (< 10 years): 15% rate applied';
    } else if (period > 0) {
        rate = 10;
        info = '✓ < 5 years: 10% rate applied';
    }

    benefitRateInput.value = rate;
    benefitInfo.innerHTML = info;
}

// CALCULATE LOAN
function calculateLoan() {
    const empName = document.getElementById('empName').value.trim();
    const monthlySalary = parseFloat(document.getElementById('monthlySalary').value);
    const loanAmount = parseFloat(document.getElementById('loanAmount').value);
    const benefitRate = parseFloat(document.getElementById('benefitRate').value);

    if (!empName || !monthlySalary || !loanAmount || benefitRate === '') {
        alert('⚠️ Please fill in all required fields and calculate benefit rate');
        return;
    }

    // Calculate total amount with benefit
    const totalAmount = loanAmount + (loanAmount * (benefitRate / 100));
    
    // Calculate monthly payment (assuming 12 months)
    const monthlyPayment = totalAmount / 12;

    // Display results
    document.getElementById('totalAmount').innerHTML = '₦' + totalAmount.toFixed(2);
    document.getElementById('monthlyAmount').innerHTML = '₦' + monthlyPayment.toFixed(2);
}

// SAVE DATA
function saveData() {
    const empName = document.getElementById('empName').value.trim();
    const empAddress = document.getElementById('empAddress').value.trim();
    const monthlySalary = parseFloat(document.getElementById('monthlySalary').value);
    const empPeriod = parseFloat(document.getElementById('empPeriod').value);
    const benefitRate = parseFloat(document.getElementById('benefitRate').value);
    const loanAmount = parseFloat(document.getElementById('loanAmount').value);
    const totalAmount = parseFloat(document.getElementById('totalAmount').innerHTML.replace('₦', ''));
    const monthlyPayment = parseFloat(document.getElementById('monthlyAmount').innerHTML.replace('₦', ''));

    if (!empName || !monthlySalary || !loanAmount || empPeriod === '') {
        alert('⚠️ Please fill in all required fields');
        return;
    }

    const formData = new FormData();
    formData.append('empName', empName);
    formData.append('empAddress', empAddress);
    formData.append('monthlySalary', monthlySalary);
    formData.append('empPeriod', empPeriod);
    formData.append('benefitRate', benefitRate);
    formData.append('loanAmount', loanAmount);
    formData.append('totalAmount', totalAmount);
    formData.append('monthlyPayment', monthlyPayment);

    fetch('save.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            document.getElementById('loanForm').reset();
            document.getElementById('totalAmount').innerHTML = '₦0.00';
            document.getElementById('monthlyAmount').innerHTML = '₦0.00';
            document.getElementById('benefitRate').value = '';
            document.getElementById('benefitInfo').innerHTML = '';
            loadEmployeesList();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error saving data');
    });
}

// DISPLAY FROM DATABASE
function displayFromDB() {
    fetch('get_data.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            data.records.forEach(record => {
                const row = `
                    <tr>
                        <td>${record.id}</td>
                        <td>${record.employee_name}</td>
                        <td>${record.employee_address}</td>
                        <td>₦${parseFloat(record.monthly_salary).toFixed(2)}</td>
                        <td>${record.employment_period} years</td>
                        <td>${record.benefit_rate}%</td>
                        <td>₦${parseFloat(record.loan_amount).toFixed(2)}</td>
                        <td>₦${parseFloat(record.total_amount).toFixed(2)}</td>
                        <td>₦${parseFloat(record.monthly_payment).toFixed(2)}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });

            document.getElementById('dataTableContainer').style.display = 'block';
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error retrieving data');
    });
}

// DELETE ALL DATA
function deleteAll() {
    if (confirm('⚠️ Are you sure you want to delete ALL records? This action cannot be undone!')) {
        fetch('delete_all.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                document.getElementById('dataTableContainer').style.display = 'none';
                loadEmployeesList();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error deleting data');
        });
    }
}

// PRINT DATA
function printData() {
    const dataTable = document.getElementById('dataTable');
    
    if (dataTable.getElementsByTagName('tbody')[0].rows.length === 0) {
        alert('⚠️ No data to print. Please click "Display From DB" first.');
        return;
    }

    const printWindow = window.open('', '', 'height=600,width=900');
    printWindow.document.write('<html><head><title>Bank Loan System - Print Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('h1 { text-align: center; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('table, th, td { border: 1px solid black; padding: 10px; text-align: left; }');
    printWindow.document.write('th { background-color: #2c3e50; color: white; }');
    printWindow.document.write('</style></head><body>');
    printWindow.document.write('<h1>BANK LOAN MANAGEMENT SYSTEM - REPORT</h1>');
    printWindow.document.write('<p>Generated on: ' + new Date().toLocaleString() + '</p>');
    printWindow.document.write(dataTable.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// SEARCH EMPLOYEE
function searchEmployee() {
    const searchTerm = document.getElementById('searchInput').value.trim();
    
    if (!searchTerm) {
        alert('⚠️ Please enter an employee name');
        return;
    }

    fetch('search_employee.php?search=' + encodeURIComponent(searchTerm))
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.record) {
            const record = data.record;
            document.getElementById('empName').value = record.employee_name;
            document.getElementById('empAddress').value = record.employee_address;
            document.getElementById('monthlySalary').value = record.monthly_salary;
            document.getElementById('empPeriod').value = record.employment_period;
            document.getElementById('loanAmount').value = record.loan_amount;
            calculateBenefit();
            document.getElementById('totalAmount').innerHTML = '₦' + parseFloat(record.total_amount).toFixed(2);
            document.getElementById('monthlyAmount').innerHTML = '₦' + parseFloat(record.monthly_payment).toFixed(2);
            alert('✓ Employee data loaded successfully');
        } else {
            alert('❌ Employee not found');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error searching employee');
    });
}

// LOAD EMPLOYEES LIST
function loadEmployeesList() {
    fetch('get_employees_list.php')
    .then(response => response.json())
    .then(data => {
        const employeesList = document.getElementById('employeesList');
        employeesList.innerHTML = '';

        if (data.status === 'success' && data.employees.length > 0) {
            data.employees.forEach(emp => {
                const div = document.createElement('div');
                div.className = 'employee-item';
                div.textContent = emp.employee_name;
                div.style.cursor = 'pointer';
                div.onclick = function() {
                    document.getElementById('searchInput').value = emp.employee_name;
                    searchEmployee();
                };
                employeesList.appendChild(div);
            });
        } else {
            employeesList.innerHTML = '<p style="color: #999;">No employees found</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>

</body>
</html>