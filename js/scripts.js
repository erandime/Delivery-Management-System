$(document).ready(function () {

    // Function to get the ordinal suffix for the date
    function getOrdinalSuffix(date) {
        if (date > 3 && date < 21) return "th";
        switch (date % 10) {
            case 1: return "st";
            case 2: return "nd";
            case 3: return "rd";
            default: return "th";
        }
    }

    // Function to update the current date and time
    function updateDateTime() {
        const now = new Date();
        const day = now.toLocaleDateString('en-US', { weekday: 'long' });
        const date = now.getDate();
        const month = now.toLocaleDateString('en-US', { month: 'long' });
        const year = now.getFullYear();
        const formattedDate = `${month} ${date}${getOrdinalSuffix(date)}, ${year}`;
        const formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });

        $("#currentDay, #currentDayLarge").text(day);
        $("#currentDate, #currentDateLarge").text(formattedDate);
        $("#currentTime, #currentTimeLarge").text(formattedTime);
    }

    updateDateTime(); // Initial call
    setInterval(updateDateTime, 1000); // Update every second

    // Save driver functionality
    $(".save-driver").on("click", function () {
        const deliveryId = $(this).data("delivery-id");
        const selectedDriverId = $(`.driver-dropdown[data-delivery-id="${deliveryId}"]`).val();

        if (!selectedDriverId) {
            alert("Please select a driver.");
            return;
        }

        if ($(this).is(":disabled")) {
            alert("This delivery is already completed and cannot be modified.");
            return;
        }

        // Send AJAX request to assign the driver
        $.post("../controller/deliverycontroller.php", 
            { action: "assignDriver", deliveryId, driverId: selectedDriverId },
            function (response) {
                console.log("AJAX Response:", response); // Debugging log

                // Directly use the response as it's already parsed as a JavaScript object
                if (response.success) {
                    alert(response.message);

                    // Update the table dynamically
                    $(`tr[data-delivery-id="${deliveryId}"] .status-column`).text('Driver Assigned');
                    $(`tr[data-delivery-id="${deliveryId}"] .driver-name-column`).text(selectedDriverId);
                } else {
                    alert(response.message); // Show error message from the server
                }
            },
            "json" // Ensure response is automatically parsed as JSON by jQuery
        ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            alert("Failed to assign driver. Please try again.");
        });
    });

    // Filter functionality
    $("#filterStatus").on("change", function () {
        const filter = $(this).val();
        $("tbody#deliveryListTableBody tr").each(function () {
            const status = $(this).find("td:nth-child(3)").text().trim();
            if (filter === "all" || status === filter) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Sort functionality
    $("#sortSchedule").on("change", function () {
        const sortOrder = $(this).val();
        const rows = $("tbody#deliveryListTableBody tr").get();

        rows.sort(function (a, b) {
            const scheduleA = new Date($(a).find("td:nth-child(4)").text().trim());
            const scheduleB = new Date($(b).find("td:nth-child(4)").text().trim());

            if (isNaN(scheduleA)) return 1; // Handle invalid dates
            if (isNaN(scheduleB)) return -1;

            return sortOrder === "asc" ? scheduleA - scheduleB : scheduleB - scheduleA;
        });

        $.each(rows, function (index, row) {
            $("tbody#deliveryListTableBody").append(row);
        });
    });

    // Search functionality
    $("#searchButton").on("click", function () {
        const query = $("#searchDelivery").val().trim().toLowerCase();
        $("tbody#deliveryListTableBody tr").each(function () {
            const deliveryId = $(this).find("td:nth-child(1)").text().toLowerCase();
            const orderId = $(this).find("td:nth-child(8)").text().toLowerCase();
            if (deliveryId.includes(query) || orderId.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $("#searchDelivery").on("keypress", function (e) {
        if (e.which === 13) {
            $("#searchButton").click();
        }
    });

});
