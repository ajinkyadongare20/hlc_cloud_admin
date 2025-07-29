(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Progress Bar
    $('.pg-bar').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {offset: '80%'});


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav : false
    });


    document.addEventListener("DOMContentLoaded", function () {
    // Weekly Chart - Pie Chart
    const ctxWeekly = document.getElementById("weekly-chart").getContext("2d");
    new Chart(ctxWeekly, {
        type: "pie",
        data: {
            labels: ["Active Users", "Inactive Users"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 200, 83, 0.7)",    // Green
                    "rgba(244, 67, 54, 0.7)"    // Red
                ],
                data: [activeUsers, inactiveUsers]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'User Activity - Weekly View'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Monthly Chart - Doughnut Chart
    const ctxMonthly = document.getElementById("monthly-chart").getContext("2d");
    new Chart(ctxMonthly, {
        type: "doughnut",
        data: {
            labels: ["Active Users", "Inactive Users"],
            datasets: [{
                backgroundColor: [
                    "#2196f3", // Blue
                    "#ff9800"  // Orange
                ],
                data: [monthlyActiveUsers, monthlyInactiveUsers]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'User Activity - Monthly View'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});


function createUserTable(data) {
    if (data.length === 0) return "<p>No users found in this range.</p>";

    let html = `<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>PID</th>
                <th>MID</th>
                <th>Active</th>
                <th>Subscription Start</th>
                <th>Subscription End</th>
            </tr>
        </thead>
        <tbody>`;

    data.forEach((user, index) => {
        html += `<tr>
            <td>${index + 1}</td>
            <td>${user.user_id}</td>
            <td>${user.pid}</td>
            <td>${user.mid}</td>
            <td>${user.is_active == 1 ? 'Yes' : 'No'}</td>
            <td>${user.subscription_start}</td>
            <td>${user.subscription_end}</td>
        </tr>`;
    });

    html += `</tbody></table>`;
    return html;
}

function loadWeeklyExpiringUsers() {
    fetch("get_weekly_users.php")
        .then(res => res.json())
        .then(data => {
            const table = createUserTable(data);
            document.getElementById("weekly-users-table").innerHTML = table;
            document.getElementById("weekly-users-table").style.display = 'block';
        });
}

function loadMonthlyExpiringUsers() {
    fetch("get_monthly_users.php")
        .then(res => res.json())
        .then(data => {
            const table = createUserTable(data);
            document.getElementById("monthly-users-table").innerHTML = table;
            document.getElementById("monthly-users-table").style.display = 'block';
        });
}


    
})(jQuery);

