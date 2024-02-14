<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Schedule</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* CSS styles */
        .booked {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Update Schedule</h1>
    <form id="schedule-form">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <fieldset>
            <legend>Select Time Slot(s):</legend>
            <label><input type="checkbox" name="time_slot[]" value="9-10">9-10</label>
            <!-- Add more checkboxes for other time slots -->
        </fieldset>
        <button type="submit">Submit</button>
    </form>
    <div id="schedule-container">
        <!-- Schedule table will be displayed here -->
    </div>

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#schedule-form').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                // Send AJAX request to update_schedule.php
                $.ajax({
                    type: 'POST',
                    url: 'update_schedule.php',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Update UI based on the response (if needed)
                        $('#schedule-container').html(response); // Update schedule table
                    }
                });
            });
        });
    </script>
</body>
</html>
