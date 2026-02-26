function Monthly(){
    let Gross = parseInt(document.getElementById('gs').value);
    let Transport = parseInt(document.getElementById('ta').value);
    let Insurance = parseInt(document.getElementById('hi').value);
    let Tax = parseInt(document.getElementById('tx').value);
    let MSalary = Gross + Transport - Insurance - Tax;
    document.write(MSalary)
}