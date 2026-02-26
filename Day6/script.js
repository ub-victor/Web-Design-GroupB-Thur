function Monthly(){
    let disply = document.getElementById('di');
    let Gross = parseInt(document.getElementById('gs').value);
    let Transport = parseInt(document.getElementById('ta').value);
    let Insurance = parseInt(document.getElementById('hi').value);
    let Tax = parseInt(document.getElementById('tx').value);
    let MSalary = Gross + Transport - Insurance - Tax;
    disply.innerHTML = MSalary;
}

function Annual(){
    let disply = document.getElementById('di');
    let Gross = parseInt(document.getElementById('gs').value);
    let Transport = parseInt(document.getElementById('ta').value);
    let Insurance = parseInt(document.getElementById('hi').value);
    let Tax = parseInt(document.getElementById('tx').value);
    let MSalary = Gross + Transport - Insurance - Tax;
    let ASalary = MSalary * 12;
    disply.innerHTML = ASalary;
}


