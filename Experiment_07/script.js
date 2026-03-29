let form = document.getElementById("studentForm");
let table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
let count = 1;

form.addEventListener("submit", function(e) {
    e.preventDefault();

    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let usn = document.getElementById("usn").value;
    let dob = document.getElementById("dob").value;
    let desc = document.getElementById("desc").value;

    let gender = document.querySelector('input[name="gender"]:checked');
    gender = gender ? gender.value : "";

    let languages = [];
    document.querySelectorAll('input[type="checkbox"]:checked').forEach(el => {
        languages.push(el.value);
    });

    // Password validation
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    // Remove "no data"
    let noData = document.getElementById("noData");
    if (noData) noData.remove();

    let row = table.insertRow();

    row.innerHTML = `
        <td>${count++}</td>
        <td>${name}</td>
        <td>${email}</td>
        <td>${usn}</td>
        <td>${gender}</td>
        <td>${languages.join(", ")}</td>
        <td>${dob}</td>
        <td>${desc}</td>
    `;

    form.reset();
});

// COPY TABLE
function copyTable() {
    let text = document.getElementById("dataTable").innerText;
    navigator.clipboard.writeText(text);
    alert("Table copied!");
}

// EXPORT CSV
function exportCSV() {
    let rows = document.querySelectorAll("table tr");
    let csv = [];

    rows.forEach(row => {
        let cols = row.querySelectorAll("td, th");
        let data = [];
        cols.forEach(col => data.push(col.innerText));
        csv.push(data.join(","));
    });

    let blob = new Blob([csv.join("\n")], { type: "text/csv" });
    let url = window.URL.createObjectURL(blob);

    let a = document.createElement("a");
    a.href = url;
    a.download = "students.csv";
    a.click();
}