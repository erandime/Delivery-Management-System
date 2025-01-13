$(document).ready(function () {

    // Function to get the ordinal suffix for the date
    function getOrdinalSuffix(date) {
        if (date > 3 && date < 21) return "th";
        switch (date % 10) {
            case 1:
                return "st";
            case 2:
                return "nd";
            case 3:
                return "rd";
            default:
                return "th";
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

        // Update both the large and small screen elements
        $("#currentDay, #currentDayLarge").text(day);
        $("#currentDate, #currentDateLarge").text(formattedDate);
        $("#currentTime, #currentTimeLarge").text(formattedTime);
    }

    updateDateTime(); // Initial call to display the current time
    setInterval(updateDateTime, 1000); // Update the time every second

    // Sample delivery data
    let deliveries = [
        { deliveryId: "DL1001", address: "123 Elm St", status: "Pending", schedule: "2025-01-06 10:00 AM", driverId: "", driverName: "", driverContact: "", orderId: "ORD1001" },
        { deliveryId: "DL1002", address: "456 Oak St", status: "Completed", schedule: "2025-01-05 02:00 PM", driverId: "D002", driverName: "John Doe", driverContact: "555-1234", orderId: "ORD1002" },
        { deliveryId: "DL1003", address: "789 Pine St", status: "Pending", schedule: "2025-01-07 03:00 PM", driverId: "D003", driverName: "Alice Smith", driverContact: "555-5678", orderId: "ORD1003" },
    ];

    // Available drivers
//    const drivers = [
//        { id: "D001", name: "Alice Smith", contact: "555-5678" },
//        { id: "D002", name: "John Doe", contact: "555-1234" },
//        { id: "D003", name: "Charlie Brown", contact: "555-7890" },
//    ];
//
//    const $tableBody = $("#deliveryListTableBody");
//
//    function renderTable(data) {
//        $tableBody.empty();
//        data.forEach((delivery) => {
//            const driverOptions = drivers
//                .map((driver) =>
//                    driver.id === delivery.driverId
//                        ? `<option value="${driver.id}" selected>${driver.id}</option>`
//                        : `<option value="${driver.id}">${driver.id}</option>`
//                )
//                .join("");
//
//            const row = `
//                <tr>
//                    <td>${delivery.deliveryId}</td>
//                    <td>${delivery.address}</td>
//                    <td>${delivery.status}</td>
//                    <td>${delivery.schedule}</td>
//                    <td>
//                        <select class="form-select form-select-sm driver-select" data-delivery-id="${delivery.deliveryId}">
//                            <option value="">Select Driver</option>
//                            ${driverOptions}
//                        </select>
//                    </td>
//                    <td>${delivery.driverName || "N/A"}</td>
//                    <td>${delivery.driverContact || "N/A"}</td>
//                    <td>${delivery.orderId}</td>
//                    <td>
//                        <button class="btn btn-success btn-sm save-driver" data-delivery-id="${delivery.deliveryId}">Save</button>
//                    </td>
//                </tr>
//            `;
//            $tableBody.append(row);
//        });
//    }
//    renderTable(deliveries);
//
//    // Filter functionality
//    $("#filterStatus").on("change", function () {
//        const filter = $(this).val();
//        const filteredData = filter === "all" ? deliveries : deliveries.filter((delivery) => delivery.status.toLowerCase() === filter);
//        renderTable(filteredData);
//    });
//
//    // Sort functionality
//    $("#sortOptions").on("change", function () {
//        const sort = $(this).val();
//        const sortedData = [...deliveries].sort((a, b) => {
//            if (sort === "idAsc") return a.deliveryId.localeCompare(b.deliveryId);
//            if (sort === "idDesc") return b.deliveryId.localeCompare(a.deliveryId);
//            if (sort === "dateAsc") return new Date(a.schedule) - new Date(b.schedule);
//            if (sort === "dateDesc") return new Date(b.schedule) - new Date(a.schedule);
//        });
//        renderTable(sortedData);
//    });
//
//    // Search functionality
//    function searchDeliveries(query) {
//        const searchedData = deliveries.filter(
//            (delivery) =>
//                delivery.deliveryId.toLowerCase().includes(query) ||
//                delivery.orderId.toLowerCase().includes(query)
//        );
//        renderTable(searchedData);
//    }
//
//    $("#searchButton").on("click", function () {
//        const query = $("#searchDelivery").val().toLowerCase();
//        searchDeliveries(query);
//    });
//
//    $("#searchDelivery").on("keypress", function (e) {
//        if (e.which === 13) {
//            const query = $(this).val().toLowerCase();
//            searchDeliveries(query);
//        }
//    });
//
//    // Save driver update
//    $tableBody.on("click", ".save-driver", function () {
//        const deliveryId = $(this).data("delivery-id");
//        const selectedDriverId = $(`.driver-select[data-delivery-id="${deliveryId}"]`).val();
//        const driver = drivers.find((d) => d.id === selectedDriverId);
//
//        if (driver) {
//            const delivery = deliveries.find((d) => d.deliveryId === deliveryId);
//            delivery.driverId = driver.id;
//            delivery.driverName = driver.name;
//            delivery.driverContact = driver.contact;
//            renderTable(deliveries);
//            alert(`Driver updated for Delivery ID: ${deliveryId}`);
//        } else {
//            alert("Please select a valid driver.");
//        }
//    });
//
//    // Logout button functionality
//    $("#logoutButton").on("click", function () {
//        alert("You have logged out!");
//    });

});
