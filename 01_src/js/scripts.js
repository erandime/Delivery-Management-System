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

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Save driver functionality with dynamic status update
    $(".save-driver").on("click", function () {
        const deliveryId = $(this).data("delivery-id"); //extract delivery ID
        const selectedDriverId = $(`.driver-dropdown[data-delivery-id="${deliveryId}"]`).val(); //get the selected driver

        if (!selectedDriverId) {
            alert("Please select a driver.");
            return;
        }

        // Send AJAX request to deliverycontroller to assign the driver
        $.post("../controller/deliverycontroller.php",
            { action: "assignDriver", deliveryId, driverId: selectedDriverId },
            function (response) {
                if (response.success) {
                    alert(response.message);

                    // Update the status column dynamically
                    $(`tr[data-delivery-id="${deliveryId}"] .status-column`).text('Driver Assigned');

                    // Optionally highlight the updated row
                    $(`tr[data-delivery-id="${deliveryId}"]`).addClass('status-updated');
                } else {
                    alert(response.message);
                }
            },
            "json"
        ).fail(function () {
            alert("An error occurred. Please try again later or Contact Support."); //If AJAX request fails (server/network issue), display alert messgae
        });
    });

    // Optional: Remove highlight after click
    $(document).on("click", ".status-updated", function () {
        $(this).removeClass('status-updated');
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

            if (isNaN(scheduleA)) return 1;
            if (isNaN(scheduleB)) return -1;

            return sortOrder === "asc" ? scheduleA - scheduleB : scheduleB - scheduleA;
        });

        $.each(rows, function (index, row) {
            $("tbody#deliveryListTableBody").append(row);
        });
    });

    // Search functionality
    $("#searchButton").on("click", function () {
        const query = $("#searchDelivery").val().trim();
        let matchFound = false;

        $("tbody#deliveryListTableBody tr").each(function () {
            const deliveryId = $(this).find("td:nth-child(1)").text().trim();
            if (parseInt(deliveryId, 10) === parseInt(query, 10)) {
                $(this).show();
                matchFound = true;
            } else {
                $(this).hide();
            }
        });

        if (!matchFound) {
            $("#errorMessage").text("Delivery not found. Please verify the Delivery ID.").show();
        } else {
            $("#errorMessage").hide();
        }
    });

    $("#searchDelivery").on("keypress", function (e) {
        if (e.which === 13) {
            $("#searchButton").click();
        }
    });

    $("#clearSearchButton").on("click", function () {
        $("#searchDelivery").val("");
        $("#errorMessage").hide();
        $("tbody#deliveryListTableBody tr").show();
    });

    // Driver details update on driver selection
    $(".driver-dropdown").on("change", function () {
        const deliveryId = $(this).data("delivery-id");
        const driverId = $(this).val();
        //Send AJAX request to get driver details
        if (driverId) {
            $.post("../controller/deliverycontroller.php",
                { action: "getDriverDetails", driverId: driverId },
                function (response) {
                    if (response) {
                        $(`#driverName_${deliveryId}`).text(response.drivers_name);
                        $(`#driverContact_${deliveryId}`).text(response.drivers_contact_no);
                    } else {
                        alert("Failed to fetch driver details.");
                    }
                },
                "json"
            ).fail(function () {
                alert("Failed to fetch driver details.");
            });
        } else {
            $(`#driverName_${deliveryId}`).text('N/A');
            $(`#driverContact_${deliveryId}`).text('N/A');
        }
    });
});
