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

        // Send AJAX request to assign the driver
        $.post("../controller/deliverycontroller.php", 
            { action: "assignDriver", deliveryId, driverId: selectedDriverId },
            function (response) {
                if (response.success) {
                    alert(response.message);

                    // Update the table dynamically
                    $(`tr[data-delivery-id="${deliveryId}"] .status-column`).text('Driver Assigned');
                } else {
                    alert(response.message); // Display error message from the server
                }
            },
            "json"
        ).fail(function () {
            alert("Error occured. Please try again later or Contact Support.");
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
        const query = $("#searchDelivery").val().trim(); // Get the input value
        let matchFound = false; // Flag to track if a match is found

        $("tbody#deliveryListTableBody tr").each(function () {
            const deliveryId = $(this).find("td:nth-child(1)").text().trim(); // Get the delivery ID in the row

            // Ensure both values are treated as numbers for exact comparison
            if (parseInt(deliveryId, 10) === parseInt(query, 10)) {
                $(this).show(); // Show row if it matches exactly
                matchFound = true; // Set the flag if a match is found
            } else {
                $(this).hide(); // Hide rows that don't match
            }
        });

        // Display an error message if no match is found
        if (!matchFound) {
            $("#errorMessage").text("Delivery not found. Please verify the Delivery ID.");
            $("#errorMessage").show(); // Show the error message
        } else {
            $("#errorMessage").hide(); // Hide the error message if a match is found
        }
    });

    // Trigger search on Enter keypress
    $("#searchDelivery").on("keypress", function (e) {
        if (e.which === 13) {
            $("#searchButton").click();
        }
    });

    // Clear search functionality
    $("#clearSearchButton").on("click", function () {
        $("#searchDelivery").val(""); // Clear the input field
        $("#errorMessage").hide(); // Hide the error message
        $("tbody#deliveryListTableBody tr").show(); // Show all rows
    });

    // Event listener for driver dropdown change
    $(".driver-dropdown").on("change", function () {
        const deliveryId = $(this).data("delivery-id");
        const driverId = $(this).val();

        if (driverId) {
            // Send AJAX request to get driver details
            $.post("../controller/deliverycontroller.php", 
                { action: "getDriverDetails", driverId: driverId },
                function (response) {
                    if (response) {
                        // Update the driver name and contact fields
                        $(`#driverName_${deliveryId}`).text(response.drivers_name);
                        $(`#driverContact_${deliveryId}`).text(response.drivers_contact_no);
                    } else {
                        alert("Failed to fetch driver details. Please try again.");
                    }
                },
                "json"
            ).fail(function () {
                alert("Failed to fetch driver details. Please try again.");
            });
        } else {
            // Clear the driver name and contact fields if no driver is selected
            $(`#driverName_${deliveryId}`).text('N/A');
            $(`#driverContact_${deliveryId}`).text('N/A');
        }
    });
});