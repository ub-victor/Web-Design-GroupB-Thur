let a = prompt("Enter value of A");
    let b = prompt("Enter value of B");

    // Convert inputs to numbers
    const A = Number(a);
    const B = Number(b);

    // Optional: validate inputs
    if (Number.isNaN(A) || Number.isNaN(B)) {
      document.write("Invalid input. Please enter numbers for A and B.");
    } else {
      const c = A * B;
      document.write("Result: " + c);
    }