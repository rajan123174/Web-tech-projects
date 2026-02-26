function printData() {

    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let age = document.getElementById("age").value;
    let dob = document.getElementById("dob").value;
    let country = document.getElementById("country").value;
    let address = document.getElementById("address").value;

    let gender = "";
    let genders = document.getElementsByName("gender");

    for (let i = 0; i < genders.length; i++) {
        if (genders[i].checked) {
            gender = genders[i].value;
        }
    }

    let hobbies = [];
    let hobbyList = document.getElementsByName("hobby");

    for (let i = 0; i < hobbyList.length; i++) {
        if (hobbyList[i].checked) {
            hobbies.push(hobbyList[i].value);
        }
    }

    document.getElementById("output").innerHTML = `
        <h3>Submitted Details</h3>
        <p><b>Name:</b> ${name}</p>
        <p><b>Email:</b> ${email}</p>
        <p><b>Age:</b> ${age}</p>
        <p><b>Date of Birth:</b> ${dob}</p>
        <p><b>Gender:</b> ${gender}</p>
        <p><b>Hobbies:</b> ${hobbies.join(", ")}</p>
        <p><b>Country:</b> ${country}</p>
        <p><b>Address:</b> ${address}</p>
    `;
}