function Monthly(){
    let months = document.getElementById('months');
    let Gross = parseInt(document.getElementById('gs').value);
    let Transport = parseInt(document.getElementById('ta').value);
    let Insurance = parseInt(document.getElementById('hi').value);
    let Tax = parseInt(document.getElementById('tx').value);
    let MSalary = Gross + Transport - Insurance - Tax;
    months.value = MSalary;
}

function Annual(){
    let annuals = document.getElementById('annuals');
    let Gross = parseInt(document.getElementById('gs').value);
    let Transport = parseInt(document.getElementById('ta').value);
    let Insurance = parseInt(document.getElementById('hi').value);
    let Tax = parseInt(document.getElementById('tx').value);
    let MSalary = Gross + Transport - Insurance - Tax;
    let ASalary = MSalary * 12;
    annuals.value = ASalary;
}

