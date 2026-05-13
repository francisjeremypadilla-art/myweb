// ================= GSAP ANIMATION =================

// let tl = gsap.timeline();

// tl.from(".navbar", {
//     y: -100,
//     opacity: 0,
//     duration: 0.8,
//     ease: "power2.out"
// })

// .from(".logo", {
//     y: -20,
//     opacity: 0,
//     duration: 0.5
// })

// .from(".nav-item", {
//     y: -20,
//     opacity: 0,
//     duration: 0.5,
//     stagger: 0.2,
//     ease: "back.out(1.7)"
// })

// .from(".about-image", {
//     y: -20,
//     opacity: 0,
//     duration: 0.5
// })

// .from(".about-text h1", {
//     y: 20,
//     opacity: 0,
//     duration: 0.5
// })

// .from(".about-text p", {
//     y: 20,
//     opacity: 0,
//     duration: 0.5
// });


// ================= FLOATING DOTS =================

const canvas = document.getElementById("floatingDots");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let dots = [];

for (let i = 0; i < 80; i++) {

    dots.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: Math.random() * 2 + 1,
        dx: (Math.random() - 0.5) * 0.5,
        dy: (Math.random() - 0.5) * 0.5
    });

}

function drawDots() {

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    dots.forEach(dot => {

        ctx.beginPath();

        ctx.arc(
            dot.x,
            dot.y,
            dot.radius,
            0,
            Math.PI * 2
        );

        ctx.fillStyle = "rgba(185, 107, 255, 0.7)";
        ctx.fill();

    });
}

function updateDots() {

    dots.forEach(dot => {

        dot.x += dot.dx;
        dot.y += dot.dy;

        if (dot.x < 0 || dot.x > canvas.width) {
            dot.dx *= -1;
        }

        if (dot.y < 0 || dot.y > canvas.height) {
            dot.dy *= -1;
        }

    });
}

function animateDots() {

    drawDots();
    updateDots();

    requestAnimationFrame(animateDots);

}

animateDots();

window.addEventListener("resize", () => {

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

});


// ================= MODAL =================

function openForm() {

    document.getElementById("addModal").style.display = "flex";

    gsap.from(".modal-content", {
        scale: 0.7,
        opacity: 0,
        duration: 0.4,
        ease: "back.out(1.7)"
    });

}

function closeForm() {

    gsap.to(".modal-content", {

        scale: 0.7,
        opacity: 0,
        duration: 0.2,

        onComplete: () => {

            document.getElementById("addModal").style.display = "none";

            gsap.set(".modal-content", {
                scale: 1,
                opacity: 1
            });

        }

    });

}


// ================= NAV INDICATOR =================

const navItems = document.querySelectorAll(".nav-item");
const indicator = document.querySelector(".nav-indicator");

function moveIndicator(element) {

    const rect = element.getBoundingClientRect();

    const parentRect =
        element.parentElement.getBoundingClientRect();

    indicator.style.width = rect.width + "px";

    indicator.style.left =
        (rect.left - parentRect.left) + "px";
}


// Initial Position
window.addEventListener("load", () => {

    const active =
        document.querySelector(".nav-item.active");

    if (active) {
        moveIndicator(active);
    }

});


// Click Behavior
navItems.forEach(item => {

    item.addEventListener("click", () => {

        navItems.forEach(i =>
            i.classList.remove("active")
        );

        item.classList.add("active");

        moveIndicator(item);

    });

});


// ================= CLOSE MODAL WHEN CLICK OUTSIDE =================

window.addEventListener("click", function(e) {

    const modal = document.getElementById("addModal");

    if (e.target === modal) {
        closeForm();
    }

});


// POST PROJECT
(() => {

    const form = document.getElementById("projectForm");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const title =
            document.getElementById("projectTitle").value;

        const description =
            document.getElementById("projectDescription").value;

        const date =
            document.getElementById("projectDate").value;

        const image =
            document.getElementById("projectImage").files[0];

        if (!image) {
            alert("Please choose an image");
            return;
        }

        const projectData = {
            title,
            description,
            date
        };

        const formData = new FormData();

        formData.append(
            "project_data",
            JSON.stringify(projectData)
        );

        formData.append(
            "images",
            image
        );

        try {
            const response = await fetch(
                "http://localhost:80/myweb/web/save_project.php/save_project",
                {
                    method: "POST",
                    body: formData
                }
            );

            const result = await response.json();

            if (!response.ok) {
                showToast(result.message, "error");
            }

            showToast(result.message, "success");


            form.reset();
            closeForm();

        } catch (error) {
            console.error(error);
        }
    });

}) ();

function showToast(message, type = "success") {
    const toast = document.getElementById("toast");

    toast.textContent = message;
    toast.className = type;

    gsap.to(toast, {
        x: -400,
        opacity: 1,
        duration: 0.4,
        ease: "power3.out"
    });

    setTimeout(() => {
        gsap.to(toast, {
            x: 0,
            opacity: 0,
            duration: 0.4
        });
    }, 3000);
}

(async () => {
    
    try {
        const res = await fetch("http://localhost:80/myweb/web/save_project.php/get_projects");
        const projects = await res.json();

        const gallery = document.querySelector(".morph-gallery");

        let html = "";

        projects.forEach((p, index) => {

            html += `
                <div class="morph-card ${index === 0 ? "active" : ""}">
                    <img src="http://localhost:80/myweb/web/${p.imageUrl}" alt="${p.title}">
                    <div class="overlay">
                        <h3>${p.title}</h3>
                        <p>${p.description}</p>
                        <small>${p.date}</small>
                    </div>
                </div>
            `;
        });

        gallery.innerHTML = html;

    } catch (err) {
        console.error("Failed to load projects:", err);
    }

}) ();